<?php

namespace App\Imports;

use App\Models\Sale;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SaleImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $newSaleDate = Date::excelToDateTimeObject($row['saledate'])->format('Y-m-d');

        $newSale = new Sale([
            'id' => Str::uuid(),
            'itemID' => $row['itemid'],
            'saleDate' => $newSaleDate,
            'qtySold' => $row['qtysold'],
            'sale' => $row['sale'],
            'totalSold' => $row['totalsold'],
        ]);

        return $newSale;
    }
}
