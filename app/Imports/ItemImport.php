<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToModel, WithHeadingRow, SkipsEmptyRows

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {

        $newItem = new Item([
            'id' => $row['id'],
            'itemName' => $row['itemname'],
            'unit' => $row['unit'],
        ]);

        // dd($newItem);

        return $newItem;
    }

}
