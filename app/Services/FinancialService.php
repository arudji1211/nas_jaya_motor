<?php

namespace App\Services;

interface FinancialService
{
    function LabaBersih(string $start, $stop): array;
    function Pemasukan(string $start, $stop): array;
    function Beban(string $start, $stop): array;
    function PajakPerbulan(string $start, $stop): array;
}
