<?php

namespace App\Exports;

use App\Models\Opname;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class OpnameExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        if (Request::routeIs('topname')) {
            # code...
            return [
                'itemID',
                'opnameDate',
                'systemStock',
                'physicalStock',
                'difference',
                'remarks',
            ];
        } else {
            return [
                'itemID',
                'opnameDate',
                'systemStock',
                'physicalStock',
                'difference',
                'remarks',
                'created_at',
                'updated_at',
            ];
        }
    }

    public function collection()
    {
        if (Request::routeIs('topname')) {
            # code...
            return collect([]);
        } else {
            $columns = Schema::getColumnListing('opnames');
            $columns = array_diff($columns, ['id']);

            $opname = Opname::select($columns)->get();

            return $opname;
        }
    }
}
