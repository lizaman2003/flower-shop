<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BinController extends Controller
{
    public function bin()
    {

        $bins = Bin::select('bins.id as id', 'bins.count as count', 'items.img as img', 'items.name as name', 'items.price as price')->join('items', 'items.id', 'bins.item_id')->where('bins.status', '0')->where('bins.user_id', Auth::user()->id)->get();
        $sum = Bin::selectRaw('SUM(bins.count * items.price) as sum')->join('items', 'items.id', 'bins.item_id')->where('status', '0')->where('user_id', Auth::user()->id)->first();
        return view('bin', ['bins' => $bins, 'sum' => $sum]);
    }

    public function addBin(Request $r)
    {
        $item = Item::find($r->id);
        $bin = Bin::where('status', '0')->where('user_id', Auth::user()->id)->where('item_id', $r->id)->first();

        if (is_null($bin)) {
            if ($item->count > 0) {
                Bin::insert([
                    'user_id' => Auth::user()->id,
                    'item_id' => $item->id
                ]);
            } else {
                return response()->json(['bin' => 'nocount'], 400);
            }
        } else {
            if ($bin->count + 1 > $item->count) {
                return response()->json(['bin' => 'nocount'], 400);
            } else {
                $bin->count = $bin->count + 1;
                $bin->save();
            }
        }
        return response()->json(['bin' => 'success'], 200);
    }
    public function changeCount(Request $r)
    {
        $bin = Bin::select('bins.count as b_count', 'items.count as t_count', 'items.price as price')->join('items', 'items.id', 'bins.item_id')->where('bins.status', '0')->where('bins.user_id', Auth::user()->id)->where('bins.id', $r->id)->first();

        switch ($r->type) {
            case 'add':
                if ($bin->b_count + 1 > $bin->t_count) {
                    return response()->json(['bin' => 'noCount'], 401);
                } else {
                    $bin->b_count++;
                }
                break;

            case 'remove':
                if ($bin->b_count - 1 < 1) {
                    return response()->json(['error' => 'null'], 400);
                } else {
                    $bin->b_count--;
                }
                break;
        }
        Bin::where('id', $r->id)->update([
            'count' => $bin->b_count
        ]);
        $sum = Bin::selectRaw('SUM(bins.count * items.price) as sum')->join('items', 'items.id', 'bins.item_id')->where('status', '0')->where('user_id', Auth::user()->id)->first();
        return response()->json([
            'count' => $bin->b_count,
            'sumPrice' => $bin->b_count * $bin->price,
            'sum' => $sum->sum
        ], 200);
    }

    public function removeItem(Request $request)
{
    // Находим товар в корзине
    $bin = Bin::find($request->id);
    
    // Проверяем что товар существует и принадлежит текущему пользователю
    if ($bin && $bin->user_id == Auth::user()->id) {
        // Удаляем товар из корзины
        $bin->delete();
        
        // Пересчитываем общую сумму корзины
        $bins = Bin::where('user_id', Auth::user()->id)
                   ->where('status', 0)  // 0 = в корзине, 1 = оформлен
                   ->get();
        
        $totalSum = 0;
        foreach ($bins as $b) {
            $item = Item::find($b->item_id);
            if ($item) {
                $totalSum += $item->price * $b->count;
            }
        }
        
        return response()->json([
            'success' => true,
            'totalSum' => $totalSum,
            'message' => 'Товар удален из корзины'
        ]);
    }
    
    return response()->json([
        'success' => false,
        'message' => 'Товар не найден'
    ], 404);
}

public function getCount()
{
    $count = Bin::where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->sum('count');
    
    return response()->json(['count' => $count]);
}
}


