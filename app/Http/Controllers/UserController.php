<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionWrapper;
use App\Services\ItemService;
use App\Services\StockHistoryService;
use App\Services\TransactionService;
use App\Services\TransactionWrapperService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    //panggil service item
    private ItemService $itemservice;
    private TransactionService $transactionservice;
    private TransactionWrapperService $transactionwservice;
    private StockHistoryService $stockhistoryservice;

    public function __construct(ItemService $itservice, TransactionService $trservice, TransactionWrapperService $trwservice, StockHistoryService $sthservice)
    {
        $this->itemservice = $itservice;
        $this->transactionservice = $trservice;
        $this->transactionwservice = $trwservice;
        $this->stockhistoryservice = $sthservice;
    }

    //json response

    //tambah stock barang
    public function ItemRestockCreateAction(Request $request, string $id)
    {

        try {
            //code...
            //cek item valid atau tidak
            $data_item = $this->itemservice->getByID($id);
            //buat transaksi
            $type = 'restock';
            // transaction data
            $transaction_data = [
                [
                    'user_id' => 1,
                    'item_id' => $data_item->id,
                    'jenis' => $type,
                    'nama' => $data_item->nama,
                    'transaction_wrapper_id' => null,
                    'cost' => 0,
                    'jumlah' => $request->amount
                ]
            ];
            $tr = $this->transactionservice->createWithTransaction($transaction_data);
        } catch (Exception $th) {
            return response()->json(['msg' => $th->getMessage()], $th->getCode());
        }

        if ($tr) {
            return response()->json(['msg' => 'Sukses membuat transaksi'], 200);
        } else {
            return response()->json(['msg' => 'Gagal membuat transaksi'], 500);
        }
    }

    //update Transaksi wrapper
    public function TransactionWrapperUpdateStatusAction(Request $request, string $id)
    {
        $input = [];
        try {
            $trw = $this->transactionwservice->getByID(intval($id));
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], $e->getCode());
        }
        $input['id'] = intval($id);
        $input['status'] = $request->status == '' ? $trw->status : $request->status;

        //update
        try {
            $res = $this->transactionwservice->updateStatus($input['id'], $input['status']);
        } catch (Exception $e) {
            return response()->json(['msg' => $e->getMessage()], $e->getCode());
        }
        if ($res) {
            return response()->json(['msg' => 'sukses update status transaksi', 'refresh' => true], 200);
        } else {
            return response()->json(['msg' => 'gagal update status transaksi', 'refresh' => false], 200);
        }
    }

    ///membuat transaksi
    public function TransactionCreateAction(Request $request)
    {
        if ($request->jenis == 'pemasukan') {
            if ($request->item_id == '') {
                $itemid = null;
            }
            $data = [[
                'user_id' => 1,
                'item_id' => $request->item_id,
                'jenis' => 'pemasukan',
                'nama' => $request->nama,
                'transaction_wrapper_id' => $request->transaction_wrapper_id,
                'cost' => $request->cost,
                'jumlah' => $request->jumlah
            ]];

            try {
                $tr = $this->transactionservice->createWithTransaction($data);
            } catch (Exception $th) {
                //throw $th;
                return response()->json(['msg' => $th->getMessage()], $th->getCode());
            }


            if ($tr) {
                return response()->json(['msg' => 'Transaction berhasil ditambahkan'], 200);
            }
        }
    }

    ///incrmeent jumlah pada transaksi
    public function TransactionIncrementAction(Request $request, string $id)
    {
        Log::info("Hit Transaction Service");
        try {
            $this->transactionservice->updateAmount($id, 1, 'increment');
        } catch (Exception $th) {
            //throw $th;
            Log::info("Error | Hit Transaction Service->updateAmount");
            return response()->json(['msg' => $th->getMessage()], $th->getCode());
        }
        return response()->json(['msg' => "Success update data"], 200);
    }

    ///decrmeent jumlah pada transaksi sukses,
    public function TransactionDecrementAction(Request $request, string $id)
    {
        try {
            $update = $this->transactionservice->updateAmount($id, 1, 'decrement');
        } catch (Exception $th) {
            //throw $th;
            return response()->json(['msg' => $th->getMessage()], $th->getCode());
        }
        return response()->json(['msg' => "Success update data"], 200);
    }

    public function TransactionWrapperCreateAction(Request $request)
    {
        try {
            $trw = $this->transactionwservice->create($request->nama_konsumen, $request->plat, 'Belum Lunas');
        } catch (Exception $e) {
            return redirect('/user/transaction-wrapper');
        }
        return redirect("/user/transaction-wrapper/$trw->id");
    }


    public function TransactionListWithWrapperID(Request $request, string $wrapperID)
    {
        $transactions = $this->transactionservice->getByWrapperID($wrapperID);
        return response()->json(['transactions' => $transactions->toArray()], 200);
    }

    //pages response
    ////get item
    public function itemList(Request $request)
    {
        try {
            //code...
            $items = $this->itemservice->getAll();
        } catch (Exception $th) {
            //throw $th;
            return response()->json(['msg' => $th->getMessage()], $th->getCode());
        }

        $data = [
            'items' => $items,
            'title' => 'items page'
        ];

        echo view('components.header', ['title' => 'transaction detail']);
        echo view('components.page_wrapper');
        echo view('components.sidebar');
        echo view('components.body_wrapper');
        echo view('components.navbar');
        echo view('pages.item_page', $data);
        echo view('components.footer');
    }

    public function transactionList(Request $request)
    {
        $tr_list = $this->transactionservice->getAll();
        $trw_list = $this->transactionwservice->getAll();
        $data = ['transactions' => $tr_list, 'transaction_wrappers' => $trw_list];
        echo view('components.header', ['title' => 'transaction detail']);
        echo view('components.page_wrapper');
        echo view('components.sidebar');
        echo view('components.body_wrapper');
        echo view('components.navbar');
        echo view('pages.transaction_list', $data);
        echo view('components.footer');
    }

    public function CreateTransactionWrapper(Request $request, string $id)
    {
        $trw = $this->transactionwservice->getByID(intval($id));
        $items = $this->itemservice->getAll()->toArray();
        $data = [];
        $data['items'] = $items;
        $data['transaction_wrapper'] = $trw->toArray();
        echo view('components.header', ['title' => 'transaction detail']);
        echo view('components.page_wrapper');
        echo view('components.sidebar');
        echo view('components.body_wrapper');
        echo view('components.navbar');
        echo view('pages.create_transaction_wrapper', $data);
        echo view('components.footer');
    }

    public function transactionWrapperList(Request $request)
    {
        $trw_list = $this->transactionwservice->getAll();
        $data = ['transaction_wrappers' => $trw_list];
        echo view('components.header', ['title' => 'transaction detail']);
        echo view('components.page_wrapper');
        echo view('components.sidebar');
        echo view('components.body_wrapper');
        echo view('components.navbar');
        return response()->view('pages.transaction_wrapper_list', $data);
    }

    //tak terpakai
    public function transactionWrapperDetail(Request $request, string $id)
    {
        $trw_detail = $this->transactionwservice->getByID(intval($id));
        $data = [];
        $data['trw'] = $trw_detail;
        echo view('components.header', ['title' => 'transaction detail']);
        return response()->view('pages.transaction_wrapper_detail', $data);
    }

    public function stockHistoryList(Request $request) {}
}
