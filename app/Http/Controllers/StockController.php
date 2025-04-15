<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Purchase;
use Illuminate\Support\Str;
use App\Imports\StockImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    //
    public function index()
    {
        # code...
        $stock = Stock::orderByRaw('CAST(SUBSTRING(itemID, 5) AS UNSIGNED)')->orderBy('stockDate', 'asc')->get();
        return view('items.stock.stock', compact('stock'));
    }

    public function create()
    {
        # code...

        $item = Item::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('items.stock.fstock', compact('item', 'date'));
    }

    public function import()
    {
        # code...

        return view('items.stock.fstock');
    }

    public function getOpening(Request $request)
    {
        # code...
        $itemID = $request->input('itemID');
        $stockDate = $request->input('stockDate');

        $previousMonth = date('m', strtotime('-1 month', strtotime($stockDate)));
        $previousYear = date('Y', strtotime('-1 month', strtotime($stockDate)));

        $previousClosingStock = Stock::where('itemID', $itemID)
        ->whereRaw('MONTH(stockDate) = ? AND YEAR(stockDate) = ?', [
            $previousMonth,
            $previousYear
        ])->sum('stockClosing');

        if ($previousClosingStock == '') {
            $previousClosingStock = 0;
        }
        
        $qtyPurchased = Purchase::where('itemID', $itemID)
        ->whereRaw('MONTH(purchaseDate) = ? AND YEAR(purchaseDate) = ?', [
            date('m', strtotime($stockDate)),
            date('Y', strtotime($stockDate))
        ])->sum('qtyPurchased');

        $qtySold = Sale::where('itemID', $itemID)
        ->whereRaw('MONTH(saleDate) = ? AND YEAR(saleDate) = ?', [
            date('m', strtotime($stockDate)),
            date('Y', strtotime($stockDate))
        ])->sum('qtySold');
        
        $openingStock = $previousClosingStock + $qtyPurchased;
        $closingStock = $openingStock - $qtySold;

        return response()->json(compact('qtyPurchased', 'qtySold', 'previousClosingStock', 'closingStock', 'openingStock'));
    }

    public function edit($id)
    {
        # code...
        $stock = Stock::find($id);
        $item = Item::get();

        return view('items.stock.fstock', compact('stock', 'item'));
    }

    public function insert(Request $request)
    {
        # code...
        // dd($request->all());
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'stockDate' => 'required',
            'stockOpening' => 'required|integer|digits_between:1,10',
            'stockClosing' => 'required|integer|digits_between:1,10',
            'qtySold' => 'required|integer|digits_between:1,10',
            'qtyPurchased' => 'required|integer|digits_between:1,10',
        ]);

        $stock = Stock::create([
            'id' => Str::uuid(),
            'itemID' => $request -> itemID,
            'stockDate' => $request -> stockDate,
            'stockOpening' => $request -> stockOpening,
            'stockClosing' => $request -> stockClosing,
            'qtySold' => $request -> qtySold,
            'qtyPurchased' => $request -> qtyPurchased,
        ]);

        return redirect()
        ->route('stock')
        ->with('success', 'Successfully added stock');
    }

    public function pushImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new StockImport, $file);

        return redirect()
        ->route('stock')
        ->with('success', 'Successfully imported stock');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'stockDate' => 'required',
            'stockOpening' => 'required|integer|digits_between:1,10',
            'stockClosing' => 'required|integer|digits_between:1,10',
            'qtySold' => 'required|integer|digits_between:1,10',
            'qtyPurchased' => 'required|integer|digits_between:1,10',
        ]);

        $stock = Stock::find($id);
        $stock -> update([
            'itemID' => $request -> itemID,
            'stockDate' => $request -> stockDate,
            'stockOpening' => $request -> stockOpening,
            'stockClosing' => $request -> stockClosing,
            'qtySold' => $request -> qtySold,
            'qtyPurchased' => $request -> qtyPurchased,
        ]);

        return redirect()
        ->route('stock')
        ->with('success', 'Successfully updated stock');
    }

    public function delete($id)
    {
        # code...
        $stock = Stock::find($id);
        $stock->delete();

        return redirect()
        ->route('stock')
        ->with('success', 'Successfully deleted stock');
    }
}
