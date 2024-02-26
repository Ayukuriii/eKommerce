<?php

namespace App\Http\Controllers\DataTransfer;

use Illuminate\Http\Request;
use App\Exports\CategoriesExport;
use App\Http\Controllers\Controller;
use App\Imports\CategoriesImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CategoryDataTransferController extends Controller
{
    public function export()
    {
        return new CategoriesExport();
    }

    public function import(Request $request)
    {
        // dd(Carbon::now());
        $validatedData = $request->validate([
            'templateFile' => ['required', 'mimes:xlsx'],
        ]);

        $current = date('YmdHis');
        $fileName = $current . '-' . $request->file('templateFile')->getClientOriginalName();
        $validatedData['templateFile'] = request()->file('templateFile')->storeAs('importData', $fileName, 'public');
        $path = storage_path('app/public/importData/' . $fileName);

        Excel::import(new CategoriesImport, $path);

        Storage::delete('public/importData/' . $fileName);

        return back()->with('success', 'Data imported successfully!');
    }

    public function download()
    {
        $template = storage_path('app/public/import-templates/template-categories.xlsx');

        return response()->download($template);
    }
}
