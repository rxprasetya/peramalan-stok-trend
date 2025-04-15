<?php

namespace App\Imports;

use App\Models\Stock;
use App\Models\Opname;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OpnameImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $newOpnameDate = Date::excelToDateTimeObject($row['opnamedate'])->format('Y-m-d');

        $month = date('m', strtotime($newOpnameDate));
        $year = date('Y', strtotime($newOpnameDate));
        
        $systemStock = Stock::where('itemID', $row['itemid'])
        ->whereRaw('MONTH(stockDate) = ?  and YEAR(stockDate) = ? ' , [
            $month,
            $year
        ])
        ->first();

        $updateStock = $systemStock->update([
            'stockClosing' => $row['physicalstock'],
        ]);

        $newOpname = new Opname([
            //
            'id' => Str::uuid(),
            'itemID' => $row['itemid'],
            'opnameDate' => $newOpnameDate,
            'systemStock' => $row['systemstock'],
            'physicalStock' => $row['physicalstock'],
            'difference' => $row['difference'],
            'remarks' => $row['remarks'],
        ]);
        
        return $newOpname;
    }
}
