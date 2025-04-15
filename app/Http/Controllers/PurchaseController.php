<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PurchaseImport;

class PurchaseController extends Controller
{
    //
    public function index()
    {
        # code...
        $purchase = Purchase::orderByRaw('CAST(SUBSTRING(itemID, 5) AS UNSIGNED)')->orderBy('purchaseDate', 'asc')->get();

        return view('items.purchase.purchase', compact('purchase'));
    }

    public function create(Request $request)
    {
        # code...
        $item = Item::get();
        $date = now()->setTimezone('Asia/Jakarta')->format('Y-m-d');

        return view('items.purchase.fpurchase', compact('item', 'date'));
    }

    public function edit($id)
    {
        # code...
        $purchase = Purchase::find($id);
        $item = Item::get();

        return view('items.purchase.fpurchase', compact('purchase', 'item'));
    }

    public function import()
    {
        return view('items.purchase.fpurchase');
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'purchaseDate' => 'required',
            'qtyPurchased' => 'required|min:1|max:10',
            'cost' => 'required|min:1|max:10',
            'totalCost' => 'required|min:1|max:10',
        ]);

        $purchase = Purchase::create([
            'id' => Str::uuid(),
            'itemID' => $request -> itemID,
            'purchaseDate' => $request -> purchaseDate,
            'qtyPurchased' => $request -> qtyPurchased,
            'cost' => $request -> cost,
            'totalCost' => $request -> totalCost,
        ]);

        return redirect()
        ->route('purchase')
        ->with('success', 'Successfully added purchase');
    }

    public function pushImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new PurchaseImport, $file);

        return redirect()
        ->route('purchase')
        ->with('success', 'Successfully imported purchase');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'itemID' => 'required|min:2|max:8',
            'purchaseDate' => 'required',
            'qtyPurchased' => 'required|min:1|max:10',
            'cost' => 'required|min:1|max:10',
            'totalCost' => 'required|min:1|max:10',
        ]);

        $purchase = Purchase::find($id);
        $purchase -> update([
            'itemID' => $request -> itemID,
            'purchaseDate' => $request -> purchaseDate,
            'qtyPurchased' => $request -> qtyPurchased,
            'cost' => $request -> cost,
            'totalCost' => $request -> totalCost,
        ]);

        return redirect()
        ->route('purchase')
        ->with('success', 'Successfully updated purchase');
    }

    public function delete($id)
    {
        # code...
        $purchase = Purchase::find($id);
        $purchase->delete();

        return redirect()
        ->route('purchase')
        ->with('success', 'Successfully deleted purchase');
    }

}
