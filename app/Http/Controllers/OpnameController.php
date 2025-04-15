<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use App\Models\Opname;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\OpnameExport;
use App\Imports\OpnameImport;
use Maatwebsite\Excel\Facades\Excel;

class OpnameController extends Controller
{
    //
    public function index()
    {
        # code...
        $opname = Opname::orderByRaw('CAST(SUBSTRING(id, 5) AS UNSIGNED)')->orderBy('opnameDate', 'asc')->orderBy('created_at', 'asc')->get();

        return view('items.opname.opname', compact('opname'));
    }

    public function create()
    {
        # code...
        $item = Item::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('items.opname.fopname', compact('item', 'date'));
    }

    public function import()
    {
        # code...
     
        return view('items.opname.fopname');
    }

    public function pushImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new OpnameImport, $file);

        return redirect()
        ->route('opname')
        ->with('success', 'Successfully imported opname');
    }

    public function getSystemStock(Request $request)
    {
        # code...
        $itemID = $request->input('itemID');
        $opnameDate = $request->input('opnameDate');

        $month = date('m', strtotime($opnameDate));
        $year = date('Y', strtotime($opnameDate));
        
        $systemStock = Stock::where('itemID', $itemID)
        ->whereRaw('MONTH(stockDate) = ?  and YEAR(stockDate) = ? ' , [
            $month,
            $year
        ])->sum('stockClosing');

        return response()->json(compact('systemStock'));
    }

    public function edit($id)
    {
        # code...
        $opname = Opname::find($id);
        $item = Item::get();

        return view('items.opname.fopname', compact('opname', 'item'));
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'opnameDate' => 'required',
            'systemStock' => 'required|min:1|max:10',
            'physicalStock' => 'required|min:1|max:10',
            'difference' => 'required|min:1|max:11',
        ]);

        $itemID = $request->input('itemID');
        $opnameDate = $request->input('opnameDate');

        $month = date('m', strtotime($opnameDate));
        $year = date('Y', strtotime($opnameDate));
        
        $systemStock = Stock::where('itemID', $itemID)
        ->whereRaw('MONTH(stockDate) = ?  and YEAR(stockDate) = ? ' , [
            $month,
            $year
        ])->first();

        $systemStock->update([
            'stockClosing' => $request -> physicalStock,
        ]);

        $opname = Opname::create([
            'id' => Str::uuid(),
            'itemID' => $request -> itemID,
            'opnameDate' => $request -> opnameDate,
            'systemStock' => $request -> systemStock,
            'physicalStock' => $request -> physicalStock,
            'difference' => $request -> difference,
            'remarks' => $request -> remarks,
        ]);

        return redirect()
        ->route('opname')
        ->with('success', 'Successfully added opname');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'opnameDate' => 'required',
            'systemStock' => 'required|min:1|max:10',
            'physicalStock' => 'required|min:1|max:10',
            'difference' => 'required|min:1|max:10',
        ]);

        $itemID = $request->input('itemID');
        $opnameDate = $request->input('opnameDate');

        $month = date('m', strtotime($opnameDate));
        $year = date('Y', strtotime($opnameDate));
        
        $systemStock = Stock::where('itemID', $itemID)
        ->whereRaw('MONTH(stockDate) = ?  and YEAR(stockDate) = ? ' , [
            $month,
            $year
        ])->first();

        $systemStock->update([
            'stockClosing' => $request -> physicalStock,
        ]);

        $opname = Opname::find($id);
        $opname -> update([
            'itemID' => $request -> itemID,
            'opnameDate' => $request -> opnameDate,
            'systemStock' => $request -> systemStock,
            'physicalStock' => $request -> physicalStock,
            'difference' => $request -> difference,
            'remarks' => $request -> remarks,
        ]);

        return redirect()
        ->route('opname', compact('opname'))
        ->with('success', 'Successfully updated opname');
    }

    public function export() 
    {
        return Excel::download(new OpnameExport, 'opname.xlsx');
    }

    public function delete($id)
    {
        # code...
        $opname = Opname::find($id);

        $itemID = $opname->itemID;
        $opnameDate = $opname->opnameDate;

        $month = date('m', strtotime($opnameDate));
        $year = date('Y', strtotime($opnameDate));
        
        $systemStock = Stock::where('itemID', $itemID)
        ->whereRaw('MONTH(stockDate) = ?  and YEAR(stockDate) = ? ' , [
            $month,
            $year
        ])->first();

        $systemStock->update([
            'stockClosing' => $opname->systemStock,
        ]);

        $opname->delete();

        return redirect()
        ->route('opname')
        ->with('success', 'Successfully deleted opname');
    }
    
}
