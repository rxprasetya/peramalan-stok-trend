<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Stock;
use Nette\Utils\DateTime;
use Illuminate\Http\Request;

class ForecastingController extends Controller
{
    //
    public function index()
    {
        # code...
        $stock = Stock::selectRaw('YEAR(stockDate) as year')
            ->groupBy('year')
            ->get();

        $item = Item::get();

        return view('items.forecasting.forecasting', compact('stock', 'item'));
    }

    public function trendMoment(Request $request)
    {
        # code...
        $year = $request->input('chooseYear');
        $item = $request->input('chooseItem');

        $itemName = Item::where('id', $item)->first()->itemName;

        $stock = Stock::where('itemID', $item)
        ->whereRaw('YEAR(stockDate) = ?', [$year])
        ->orderBy('stockDate');

        $n = $stock->count();

        $x = range(0, $n-1);

        // y = data actual
        $y = $stock->pluck('stockOpening')->toArray();
            
        $sumY = $stock->sum('stockOpening');

        $sumX = array_sum($x);

        $sumX2 = array_sum(
            array_map(function($x){
            return $x * $x;
            }, $x)
        );

        $sumXY = array_sum(
            array_map(function($x, $y){
            return $y * $x;
            }, $x, $y)
        );

        $eliminateA = 0;
        $eliminateB = $sumX * 2;
        $eliminateX = 0;
        $eliminateX2 = $sumX2 * 2;
        $eliminateY = 0;
        $eliminateXY = $sumXY * 2;

        if ($x != $n) {
            # code...
            for ($idx = 1; $idx < 100; $idx++) { 
                $eliminateY = $sumY * $idx;
                $eliminateA = $n * $idx;
                $eliminateX = $sumX * $idx;

                if($eliminateA == $eliminateB){
                    break;
                }
            }
        }

        // dd([$x, 'a' => $eliminateA, 'b' => $eliminateB, 'x' => $eliminateX, 'x2' => $eliminateX2, 'y' => $eliminateY, 'xy' => $eliminateXY]);

        $b = abs(($eliminateA - $eliminateB) + (($eliminateX2 - $eliminateX)/($eliminateXY - $eliminateY)));

        $a = abs(($sumX * $b) - $sumY) / $n;

        $lastDate = $stock->max('stockDate');

        $nextDate = new DateTime($lastDate);

        $newDate = [];

        $lastIndex = count($x);

        $newX = $x;

        for ($idx = $lastIndex; $idx < $lastIndex + $n; $idx++) { 
            $newX = range($lastIndex, $idx);
            $x = range(0, $idx);
            $nextDate->modify('+1 month');
            $newDate[] = $nextDate->format('F Y');
        }

        $predictedY = array_map(function($a, $b, $x) {
            return $a + $b * $x;
        }, array_fill(0, count($newX), $a), array_fill(0, count($newX), $b), $newX);

        $roundedY = array_map(function($a, $b, $x) {
            return round($a + $b * $x);
        }, array_fill(0, count($newX), $a), array_fill(0, count($newX), $b), $newX);

        $er = array_map(function ($at, $ft){
            # code...
            return $at - $ft;
        }, $y, $roundedY);

        $absEr = array_map(function($er){
            return abs($er);
        }, $er);

        $resultAbsErAt = array_map(function($absEr, $at){
            return abs($absEr / $at);
        }, $absEr, $y);

        $sumAbsErAt = array_sum($resultAbsErAt);

        $mape = $sumAbsErAt / $n * 100;

        $resultCategory = '';

        if ($mape >= 0 && $mape <= 10) {
            $resultCategory = 'Peramalan sangat akurat.';
        } elseif ($mape >= 10.1 && $mape <= 20) {
            $resultCategory = 'Peramalan akurat.';
        } elseif ($mape >= 20.1 && $mape <= 50) {
            $resultCategory = 'Peramalan cukup akurat.';
        } elseif ($mape >= 50.1 && $mape <= 100) {
            $resultCategory = 'Peramalan buruk.';
        }
        
        // dd([$mape]);
        // dd([$year, $item, $roundedY]);

        return response()->json(compact('newX', 'itemName', 'newDate', 'y', 'roundedY', 'er', 'absEr', 'resultAbsErAt', 'sumAbsErAt', 'mape', 'resultCategory'));
    }

    // public function trendMoment(Request $request)
    // {
    //     # code...
    //     $month = $request->input('chooseMonth');
    //     $item = $request->input('chooseItem');

        
    //     $itemName = Item::where('id', $item)->first()->itemName;
        
        
    //     $stock = Stock::where('itemID', $item)
    //     ->orderBy('stockDate')->get();
        
    //     $n = $stock->count();
        
    //     $x = range(0, $n-1);
        
    //     // y = data actual
    //     $y = $stock->pluck('stockOpening')->toArray();
        
    //     $sumY = $stock->sum('stockOpening');

    //     $sumX = array_sum($x);

    //     $sumX2 = array_sum(
    //         array_map(function($x){
    //         return $x * $x;
    //         }, $x)
    //     );

    //     $sumXY = array_sum(
    //         array_map(function($x, $y){
    //         return $y * $x;
    //         }, $x, $y)
    //     );

    //     $eliminateA = 0;
    //     $eliminateB = $sumX * 2;
    //     $eliminateX = 0;
    //     $eliminateX2 = $sumX2 * 2;
    //     $eliminateY = 0;
    //     $eliminateXY = $sumXY * 2;

    //     if ($x != $n) {
    //         # code...
    //         for ($idx = 1; $idx < 100; $idx++) { 
    //             $eliminateY = $sumY * $idx;
    //             $eliminateA = $n * $idx;
    //             $eliminateX = $sumX * $idx;

    //             if($eliminateA == $eliminateB){
    //                 break;
    //             }
    //         }
    //     }

    //     $b = abs(($eliminateA - $eliminateB) + (($eliminateX2 - $eliminateX)/($eliminateXY - $eliminateY)));

    //     $a = abs(($sumX * $b) - $sumY) / $n;

        
    //     $lastDate = $stock->max('stockDate');

    //     $nextDate = new DateTime($lastDate);

    //     $newDate = [];

    //     $lastIndex = count($x);

    //     $newX = $x;
        
    //     for ($idx = $lastIndex; $idx < $lastIndex + $month; $idx++) { 
    //         $newX = range($lastIndex, $idx);
    //         $x = range(0, $idx);
    //         $nextDate->modify('+1 month');
    //         $newDate[] = $nextDate->format('F Y');
    //     }

    //     $predictedY = array_map(function($a, $b, $x) {
    //         return $a + $b * $x;
    //     }, array_fill(0, count($newX), $a), array_fill(0, count($newX), $b), $newX);

    //     $roundedY = array_map(function($a, $b, $x) {
    //         return round($a + $b * $x);
    //     }, array_fill(0, count($newX), $a), array_fill(0, count($newX), $b), $newX);

    //     $er = array_map(function ($at, $ft){
    //         # code...
    //         return $at - $ft;
    //     }, $y, $roundedY);

    //     $absEr = array_map(function($er){
    //         return abs($er);
    //     }, $er);

    //     $resultAbsErAt = array_map(function($absEr, $at){
    //         return abs($absEr / $at);
    //     }, $absEr, $y);

    //     $sumAbsErAt = array_sum($resultAbsErAt);

    //     $mape = $sumAbsErAt / $n * 100;

    //     $resultCategory = '';

    //     if ($mape >= 0 && $mape <= 10) {
    //         $resultCategory = 'Peramalan sangat akurat.';
    //     } elseif ($mape >= 10.1 && $mape <= 20) {
    //         $resultCategory = 'Peramalan akurat.';
    //     } elseif ($mape >= 20.1 && $mape <= 50) {
    //         $resultCategory = 'Peramalan cukup akurat.';
    //     } elseif ($mape >= 50.1 && $mape <= 100) {
    //         $resultCategory = 'Peramalan buruk.';
    //     }
        
    //     // dd([$roundedY, $b]);
    //     // dd([$mape, $month, $item, $roundedY]);

    //     return response()->json(compact('newX', 'itemName', 'newDate', 'y', 'roundedY', 'er', 'absEr', 'resultAbsErAt', 'sumAbsErAt', 'mape', 'resultCategory'));
    // }

}
