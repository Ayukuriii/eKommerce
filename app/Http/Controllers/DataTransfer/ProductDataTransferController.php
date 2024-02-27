<?php

namespace App\Http\Controllers\DataTransfer;

use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductDataTransferController extends Controller
{
    public function export()
    {
        return new ProductExport();
    }

    public function import(Request $request)
    {
        $validatedData = $request->validate([
            'templateFile' => ['required', 'mimes:xlsx'],
        ]);

        // store local
        $current = date('YmdHis');
        $fileName = $current . '-' . $request->file('templateFile')->getClientOriginalName();
        $validatedData['templateFile'] = request()->file('templateFile')->storeAs('importData', $fileName, 'public');

        // store table
        $path = storage_path('app/public/importData/' . $fileName);
        Excel::import(new ProductsImport, $path);

        // delete local
        Storage::delete('public/importData' . $fileName);

        return to_route('product.index')->with('success', 'Data imported successfully!');
    }

    public function download()
    {
        $template = storage_path('app/public/import-templates/template-products.xlsx');

        return response()->download($template);
    }
}
