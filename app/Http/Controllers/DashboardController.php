<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use App\Models\Opname;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        # code...
        $sumUser = User::get()->count('id');
        $item = Item::get()->count('id');
        $opname = Opname::latest('created_at')->first();

        $opnameDate = $opname ? $opname->created_at : null;

        $year = Carbon::now()->format('Y');

        $sale = Sale::selectRaw('MONTH(saleDate) as month, SUM(qtySold) as totalSales')
                    ->whereYear('saleDate', $year)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();


        $months = $sale->pluck('month')->map(function ($month) {
            return Carbon::create()->month($month)->format('M');
        });

        $totalSales = $sale->pluck('totalSales');

        // dd($sale);

        if ($request->ajax()) {
            # code...
            return response()->json(compact('months', 'totalSales'));
        }

        return view('dashboard.dashboard', compact('sumUser', 'item', 'opnameDate', 'year'));
    }
}
