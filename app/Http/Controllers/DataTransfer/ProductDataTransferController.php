<?php

namespace App\Http\Controllers\DataTransfer;

use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;

class ProductDataTransferController extends Controller
{
    public function export()
    {
        return new ProductExport();
    }
}
