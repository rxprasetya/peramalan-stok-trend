<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Imports\SaleImport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    //
    public function index()
    {
        # code...
        $sale = Sale::orderByRaw('CAST(SUBSTRING(itemID, 5) AS UNSIGNED)')->orderBy('saleDate', 'asc')->get();
        return view('items.sale.sale', compact('sale'));
    }

    public function create()
    {
        # code...
        $item = Item::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');
        
        return view('items.sale.fsale', compact('item', 'date'));
    }

    public function edit($id)
    {
        # code...
        $sale = Sale::find($id);
        $item = Item::get();

        return view('items.sale.fsale', compact('sale', 'item'));
    }

    public function import()
    {
        # code...

        return view('items.sale.fsale');
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'saleDate' => 'required',
            'qtySold' => 'required|min:1|max:10',
            'sale' => 'required|min:1|max:10',
            'totalSold' => 'required|min:1|max:10',
        ]);

        $sale = Sale::create([
            'id' => Str::uuid(),
            'itemID' => $request -> itemID,
            'saleDate' => $request -> saleDate,
            'qtySold' => $request -> qtySold,
            'sale' => $request -> sale,
            'totalSold' => $request -> totalSold,
        ]);

        return redirect()
        ->route('sale')
        ->with('success', 'Successfully added sale');
    }

    public function pushImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new SaleImport, $file);

        return redirect()
        ->route('sale')
        ->with('success', 'Successfully imported sale');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'saleDate' => 'required',
            'qtySold' => 'required|min:1|max:10',
            'sale' => 'required|min:1|max:10',
            'totalSold' => 'required|min:1|max:10',
        ]);

        $sale = Sale::find($id);
        $sale -> update([
            'itemID' => $request -> itemID,
            'saleDate' => $request -> saleDate,
            'qtySold' => $request -> qtySold,
            'sale' => $request -> sale,
            'totalSold' => $request -> totalSold,
        ]);

        return redirect()
        ->route('sale')
        ->with('success', 'Successfully updated sale');
    }

    public function delete($id)
    {
        # code...
        $sale = Sale::find($id);
        $sale->delete();

        return redirect()
        ->route('sale')
        ->with('success', 'Successfully deleted sale');
    }
    
}
