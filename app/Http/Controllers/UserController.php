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

    public function transactionList(Request $request) {}

    public function transactionWrapperList(Request $request)
    {
        return response()->view('transaction_wrapper_list');
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
