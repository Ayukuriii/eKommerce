<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CategoriesImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;
    
    public function model(array $row)
    {
        return new Category([
            'name' => $row['name'],
            'slug' => $row['slug'],
        ]);
    }
}
