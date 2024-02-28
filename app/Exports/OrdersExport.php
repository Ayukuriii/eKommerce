<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromQuery, WithMapping, Responsable, WithHeadings, WithStyles
{
    use Exportable;

    private $fileName;

    public function __construct()
    {
        $this->fileName = date('Ymd_His') . '_orders.xlsx';
    }

    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function headings(): array
    {
        return [
            'id',
            'user_id',
            'Status',
            'Payment Type',
            'Gross Amount',
            'Items',
            'snap_token',
            'snap_url',
            'created_at',
            'updated_at',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A' => ['font' => ['bold' => true]],
        ];
    }

    public function map($row): array
    {
        $items = $row->items;

        $itemDetails = $items->map(function ($item) {
            $product = $item->product;

            return $product->name . ' (' . $item->quantity . ')';
        })->implode(', ');

        return [
            $row->id,
            $row->user_id,
            $row->status,
            $row->payment_type,
            $row->gross_amount,
            $itemDetails,
            $row->snap_token,
            $row->snap_url,
            $row->created_at,
            $row->updated_at,
        ];
    }

    public function query()
    {
        return Order::query();
    }
}
