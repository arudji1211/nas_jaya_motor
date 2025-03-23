<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionWrapper;
use App\Services\ItemService;
use App\Services\StockHistoryService;
use App\Services\TransactionService;
use App\Services\TransactionWrapperService;
use Illuminate\Http\Request;

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
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['msg' => $th->getMessage()], $th->getCode());
            }


            if ($tr) {
                return response()->json(['msg' => 'Transaction berhasil ditambahkan'], 200);
            }
        }
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
        $items = $this->itemservice->getAll();
        $data = [
            'items' => $items,
            'title' => 'items page'
        ];
        return response()->view('pages.item_page', $data);
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

    public function CreateTransactionWrapper(Request $request)
    {
        $items = $this->itemservice->getAll()->toArray();
        $data = [];
        $data['items'] = $items;
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
        return response()->view('pages.transaction_wrapper_list', $data);
    }

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
