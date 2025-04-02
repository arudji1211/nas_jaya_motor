<?php

namespace App\Services\Impl;

use App\Models\Transaction;
use App\Models\TransactionWrapper;
use App\Services\ItemService;
use App\Services\TransactionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\VarDumper\VarDumper;

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


            if (is_null($data_transaksi)) {
                //var_dump($data_transaksi);
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
                //tentukan cost total=
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
            if (!($this->itemService->decrementStock($user_id, $data_barang->id, $jumlah))) {
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
        } else if ($jenis == 'restock') {
            ///pengeluaran karena mmenambah stock
            //ambil data barang
            //cost wajib 0 karena tidak termasuk pengeluaran namun aset
            //sedangkan cost akan di gunakan untuk menjadi acuan pemasukan/pengeluaran bersih
            $data_barang = $this->itemService->getByID($item_id);

            //override nama menggunakan nama dari database item
            $nama = $data_barang->nama;
            $cost = 0;
            //tentukan cost total / tidak menghitung markup karena termasuk penambahan aset
            $cost_total = $data_barang->harga * $jumlah;

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
        } else if ($jenis == 'biaya_operasional') {
            ///ini akan mengurangi laba bersih
            $cost_total = $cost * $jumlah;
            $data_transaksi = new Transaction(
                [
                    'user_id' => $user_id,
                    'item_id' => null,
                    'jenis' => $jenis,
                    'nama' => $nama,
                    'transaction_wrapper_id' => null,
                    'harga' => null,
                    'cost' => $cost,
                    'jumlah' => $jumlah,
                    'cost_total' => $cost_total
                ]
            );
            //buat data transaksi
            if (!($data_transaksi->save())) {
                throw new Exception("Gagal membuat transaksi " + $nama, 500);
            }
            return $data_transaksi;
        } else {
            throw new Exception("Gagal membuat transaksi " + $nama, 403);
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

    function getByWrapperID($id): Collection
    {
        $data = Transaction::query()->where('transaction_wrapper_id', '=', $id)->get();
        return $data;
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

    function getByDateRangeAndJenis($start, $end, $jenis): Collection
    {
        $tstart = Carbon::parse($start)->startOfDay();
        $tstop = Carbon::parse($end)->endOfDay();
        $data = Transaction::query()->with('item')->where('jenis', '=', $jenis)->whereBetween('updated_at', [$tstart, $tstop])->get();
        return $data;
    }

    function updateAmount($id, $id_user, $action): bool
    {

        Log::info("triggered | Transaction Service->updateAmount");
        $jumlah = 1;
        if ($action == 'increment') {
            Log::info("triggered | increment condition | Transaction Service->updateAmount");
            return DB::transaction(function () use ($id, $id_user, $jumlah) {
                Log::info("Hit |Transaction Service->updateAmount |Transaction Service->getByID");
                $data = $this->getByID($id);
                $data->jumlah += $jumlah;
                $data->cost_total = ($data->harga + $data->cost) * $data->jumlah;
                $data->save();

                ///increment item
                Log::info("Hit |Transaction Service->updateAmount |Item Service->decrementStock");
                $this->itemService->decrementStock($id_user, $data->item_id, 1);
                Log::info("Hit |Transaction Service->updateAmount |TransactionWrapper service->touch");
                $TW = TransactionWrapper::query()->find($data->item_id);
                $TW->touch();

                return true;
            });
        } else {
            Log::info("Hit | decrement condition |Transaction Service->updateAmount");
            return DB::transaction(function () use ($id, $id_user, $jumlah) {
                Log::info("Hit | Transaction Service->updateAmount | Transaction Service->getByID");
                $data = $this->getByID($id);
                $data->jumlah -= $jumlah;
                if ($data->jumlah < 1) {
                    Log::info("Triggered | delete transaction condition |Transaction Service->updateAmount");
                    Log::info("Hit | Transaction Service->updateAmount | Transaction Service->delete");
                    $delete = $this->delete($id);

                    if ($delete != true) {
                        Log::info("triggered | delete != true condition | Transaction Service->updateAmount | Transaction Service->delete");
                        throw new Exception("Data Gagal di Hapus", 500);
                    }
                } else {
                    Log::info("Triggered | increment jumlah item condition |Transaction Service->updateAmount");
                    $data->cost_total = ($data->harga + $data->cost) * $data->jumlah;
                    $data->save();
                }


                ///decrement item
                Log::info("Hit | Transaction Service->updateAmount | Item service->incrementstock");
                $this->itemService->incrementStock($id_user, $data->item_id, 1);
                Log::info("Hit | Transaction Service->updateAmount | TransactionWrapper->touch");
                $TW = TransactionWrapper::query()->find($data->item_id);
                $TW->touch();
                return true;
            });
        }
    }



    function delete($id): bool
    {
        Log::info("Triggered | Transaction Service->delete");
        $data = Transaction::query()->find($id);
        Log::info("Success | Transaction Service->delete");
        if ($data != null) {
            Log::info("action | Transaction Service->delete | transaction_wrapper->touch");
            $TW = TransactionWrapper::query()->find($data->transaction_wrapper_id);

            $TW->touch();
            Log::info("action | Transaction Service->delete | destroy data id = " . $id);
            $del = $data->delete();
            //DD($del);
            Log::info("Transaction Service->delete | done");
            return $del > 0 ? true : false;
        }

        Log::info("Transaction Service->delete | done");
        return false;
    }
}
