<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UsersExport implements FromCollection, Responsable, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    private $fileName;

    public function __construct()
    {
        $this->fileName = date('Ymd_His') . '_users.xlsx';
    }

    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Username',
            'Email',
            'Phone Number',
            'role',
            'email verified at',
            'created at',
            'updated at'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A' => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        return User::all();
    }
}
