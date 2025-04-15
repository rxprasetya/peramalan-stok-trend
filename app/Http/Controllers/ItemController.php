<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Imports\ItemImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    //
    public function index()
    {
        # code...
        $item = Item::orderByRaw('CAST(SUBSTRING(id, 5) AS UNSIGNED)')->get();
        return view('items.list.item', compact('item'));
    }

    public function create()
    {
        # code...
        return view('items.list.fitem');
    }

    public function edit($id)
    {
        # code...
        $item = Item::find($id);

        return view('items.list.fitem', compact('item'));
    }

    public function import()
    {
        return view('items.list.fitem');
    }

    public function insert(Request $request)
    {
        # code...
        $request->validate([
            'id' => 'required|min:2|max:8',
            'itemName' => 'required|min:2|max:32',
            'unit' => 'required|min:1|max:4',
        ]);

        $item = Item::create([
            'id' => $request -> id,
            'itemName' => $request -> itemName,
            'unit' => $request -> unit,
        ]);

        return redirect()
        ->route('item')
        ->with('success', 'Successfully added item');
    }

    public function pushImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        $file = $request->file('file');

        Excel::import(new ItemImport, $file);

        return redirect()
        ->route('item')
        ->with('success', 'Successfully imported item');
    }

    public function update(Request $request, $id)
    {
        # code...
        $request->validate([
            'id' => 'required|min:2|max:8',
            'itemName' => 'required|min:2|max:32',
            'unit' => 'required|min:1|max:4',
        ]);

        $item = Item::find($id);
        $item -> update([
            'id' => $request -> id,
            'itemName' => $request -> itemName,
            'unit' => $request -> unit,
        ]);

        return redirect()
        ->route('item')
        ->with('success', 'Successfully updated item');
    }

    public function delete($id)
    {
        # code...
        $item = Item::find($id);

        if ($item) {
            # code...
            $item->delete();
        }

        return redirect()
        ->route('item')
        ->with('success', 'Successfully deleted item');
    }
    
}
