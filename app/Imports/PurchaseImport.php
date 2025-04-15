<?php

namespace App\Imports;

use App\Models\Purchase;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class PurchaseImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $newPurchaseDate = Date::excelToDateTimeObject($row['purchasedate'])->format('Y-m-d');

        $newPurchase = new Purchase([
            'id' => Str::uuid(),
            'itemID' => $row['itemid'],
            'purchaseDate' => $newPurchaseDate,
            'qtyPurchased' => $row['qtypurchased'],
            'cost' => $row['cost'],
            'totalCost' => $row['totalcost'],
        ]);

        return $newPurchase;
    }

}
