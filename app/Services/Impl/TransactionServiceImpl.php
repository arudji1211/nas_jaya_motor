<?php

namespace App\Services\Impl;

use App\Models\Transaction;
use App\Models\TransactionWrapper;
use App\Services\ItemService;
use App\Services\TransactionService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class TransactionServiceImpl implements TransactionService
{
    protected ItemService $itemService;

    function __construct(ItemService $is)
    {
        $this->itemService = $is;
    }

    function create($user_id, $item_id, $jenis, $nama, $transaction_wrapper_id, $cost, $jumlah): Transaction
    {
        if ($item_id != null and $jenis == 'pemasukan') {

            //pemasukan berasal dari barang
            //validasi stock barang
            $data_barang = $this->itemService->getByID($item_id);
            if ($jumlah > $data_barang->stock) {
                throw new Exception("Stock Tidak Mencukupi", 400);
            }

            //override nama menggunakan nama dari database item
            $nama = $data_barang->nama;

            ///jika cost kosong isi menggunakan cost dari harga barang
            if ($cost == 0) {
                $cost = $data_barang->markup;
            }



            //jadi untuk  menentukan laba cukup menghitung selisih dari variabel harga dan cost_total
            ///cek jika ternyata sudah ada barang yang sama dalam 1 transaksi wrapper
            $data_transaksi = Transaction::query()->where('transaction_wrapper_id', '=', $transaction_wrapper_id)->where('item_id', '=', $item_id)->where('jenis', '=', $jenis)->first();
            if (isNull($data_transaksi)) {
                ///bikin object
                //tentukan cost total
                //
                $cost_total = ($data_barang->harga + $cost) * $jumlah;

                //harga bahan baku
                $harga = $data_barang->harga;

                $data_transaksi = new Transaction(
                    [
                        'user_id' => $user_id,
                        'item_id' => $item_id,
                        'jenis' => $jenis,
                        'nama' => $nama,
                        'transaction_wrapper_id' => $transaction_wrapper_id,
                        'harga' => $harga,
                        'cost' => $cost,
                        'jumlah' => $jumlah,
                        'cost_total' => $cost_total
                    ]
                );
            } else {
                //tentukan cost total
                echo "data transaksi isnot null";
                $jumlah = $data_transaksi->jumlah + $jumlah;

                //harga bahan baku
                $harga = $data_barang->harga;

                //tentukan cost total
                $cost_total = ($data_barang->harga + $cost) * $jumlah;

                //override data
                $data_transaksi->jumlah = $jumlah;
                $data_transaksi->harga = $harga;
                $data_transaksi->cost = $cost;
                $data_transaksi->cost_total = $cost_total;
            }


            ///kurangi item
            if (!($this->itemService->decrementStock($data_barang->id, $jumlah))) {
                throw new Exception("Gagal mengurangi stock", 500);
            }
            //buat data transaksi
            if (!($data_transaksi->save())) {
                throw new Exception("Gagal membuat transaksi " + $nama, 500);
            }
            return $data_transaksi;
        } else if (($item_id == null or $item_id == 0) and $jenis == 'pemasukan') {
            //pemasukan berasal dari jasa
            ///bikin object
            $data_transaksi = new Transaction(
                [
                    'user_id' => $user_id,
                    'item_id' => $item_id,
                    'jenis' => $jenis,
                    'nama' => $nama,
                    'transaction_wrapper_id' => $transaction_wrapper_id,
                    'harga' => 0,
                    'cost' => $cost,
                    'jumlah' => $jumlah,
                    'cost_total' => $cost * $jumlah
                ]
            );

            //buat data transaksi
            if (!($data_transaksi->save())) {
                throw new Exception("Gagal membuat transaksi " . $nama, 500);
            }
            return $data_transaksi;
        } else {
            ///pengeluaran karena mmenambah stock
            //ambil data barang
            $data_barang = $this->itemService->getByID($item_id);

            //override nama menggunakan nama dari database item
            $nama = $data_barang->nama;

            //tentukan cost total
            $cost_total = ($data_barang->harga + $cost) * $jumlah;

            //harga bahan baku
            $harga = $data_barang->harga;

            //jadi untuk  menentukan laba cukup menghitung selisih dari variabel harga dan cost_total

            ///bikin object
            $data_transaksi = new Transaction(
                [
                    'user_id' => $user_id,
                    'item_id' => $item_id,
                    'jenis' => $jenis,
                    'nama' => $nama,
                    'transaction_wrapper_id' => $transaction_wrapper_id,
                    'harga' => $harga,
                    'cost' => $cost,
                    'jumlah' => $jumlah,
                    'cost_total' => $cost_total
                ]
            );

            ///tambah item
            //sekaligus validasi akses
            if (!($this->itemService->incrementStock($user_id, $data_barang->id, $jumlah))) {
                throw new Exception("Gagal menambah stock", 500);
            }

            //buat data transaksi
            if (!($data_transaksi->save())) {
                throw new Exception("Gagal membuat transaksi " + $nama, 500);
            }
            return $data_transaksi;
        }
    }

    function createWithTransaction(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            foreach ($data as $d) {
                $this->create(
                    $d['user_id'],
                    $d['item_id'],
                    $d['jenis'],
                    $d['nama'],
                    $d['transaction_wrapper_id'],
                    $d['cost'],
                    $d['jumlah']
                );
            }
            return true;
        });
    }

    function getAll(): Collection
    {
        $data = Transaction::query()->get();
        return $data;
    }

    function getByID($id): Transaction
    {
        $data = Transaction::query()->find($id);
        if ($data->id == null) {
            throw new Exception("Data tidak di temukan", 404);
        }
        return $data;
    }

    function getByDateRange($start, $end): Collection
    {
        $data = Transaction::query()->where('updated_at', '>', $start)->where('updated_at', '<', $end)->get();
        return $data;
    }

    function updateAmount($id, $jumlah): bool
    {
        $data = Transaction::query()->find($id);
        $data->jumlah = $jumlah;
        $data->cost_total = ($data->harga + $data->cost) * $jumlah;
        //perbarui transaksi wrapper

        $result = $data->save();
        $TW = TransactionWrapper::query()->find($data->item_id);
        $TW->touch();
        return $result;
    }



    function delete($id): bool
    {
        $data = Transaction::query()->find($id);
        $TW = TransactionWrapper::query()->find($data->item_id);
        $TW->touch();

        //$data = Transaction::destroy($id);
        return Transaction::query()->destroy($id);
    }
}
