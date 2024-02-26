<?php

namespace App\Http\Controllers\DataTransfer;

use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;

class OrderDataTransferController extends Controller
{
    public function export()
    {
        return new OrdersExport();
    }
}
