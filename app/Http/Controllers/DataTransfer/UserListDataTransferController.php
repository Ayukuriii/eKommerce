<?php

namespace App\Http\Controllers\DataTransfer;

use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserListDataTransferController extends Controller
{
    public function export()
    {
        return new UsersExport();
    }
}
