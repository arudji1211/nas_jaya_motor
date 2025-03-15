<?php

namespace App\Services\Impl;

use App\Services\FinancialService;
use App\Services\TransactionService;
use Carbon\Carbon;

class FinancialServiceImpl implements FinancialService
{

    private TransactionService $transactionService;

    public function __construct(TransactionService $ts)
    {
        $this->transactionService = $ts;
    }

    function LabaBersih(string $start, $stop): array
    {
        $data_output = [];
        //ambil pemasukan terlebih dahulu

        $data_pemasukan = $this->Pemasukan($start, $stop);

        $data_beban = $this->Beban($start, $stop);

        $laba_bersih = $data_pemasukan['pemasukan'] - $data_beban['beban'];

        $data_output['raw'] = ['pemasukan' => $data_pemasukan['raw'], 'beban' => $data_beban['raw']];
        $data_output['pemasukan'] = $data_pemasukan['pemasukan'];
        $data_output['beban'] = $data_beban['beban'];
        $data_output['laba_bersih'] = $laba_bersih;
        return $data_output;
    }

    function Pemasukan(string $start, $stop): array
    {
        $data_output = [];
        $data_pemasukan = $this->transactionService->getByDateRangeAndJenis($start, $stop, 'pemasukan');
        $pemasukan = 0;
        $data_output['raw'] = $data_pemasukan->toArray();
        foreach ($data_output['raw'] as $d) {
            $pemasukan += ($d['cost'] * $d['jumlah']);
        }
        $data_output['pemasukan'] = $pemasukan;
        return $data_output;
    }

    function Beban(string $start, $stop): array
    {
        $data_output = [];
        $data_beban = $this->transactionService->getByDateRangeAndJenis($start, $stop, 'biaya_operasional');
        $data_output['raw'] = $data_beban->toArray();
        $beban = 0;
        foreach ($data_output['raw'] as $d) {
            $beban += ($d['cost'] * $d['jumlah']);
        }

        $data_output['beban'] = $beban;
        return $data_output;
    }

    function PajakPerbulan(string $start, $stop): array
    {
        return [];
    }
}
