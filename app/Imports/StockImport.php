<?php

namespace App\Imports;

use App\Models\Stock;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $newStockDate = Date::excelToDateTimeObject($row['stockdate'])->format('Y-m-d');

        $newStock = new Stock([
            'id' => Str::uuid(),
            'itemID' => $row['itemid'],
            'stockDate' => $newStockDate,
            'stockOpening' => $row['stockopening'],
            'stockClosing' => $row['stockclosing'],
            'qtySold' => $row['qtysold'],
            'qtyPurchased' => $row['qtypurchased'],
        ]);

        return $newStock;
    }
}
