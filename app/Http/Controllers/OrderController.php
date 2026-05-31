<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function addOrder(Request $r)
    {
        $validation = Validator::make($r->all(), [
            'password' => 'required|string|current_password',
        ]);
        if ($validation->fails()) {
            return response()->json($validation->errors(), 400);
        }

        $order = Order::create([
            'user_id' => Auth::user()->id,
        ]);

        $bin = Bin::where('status', '0')->where('user_id', Auth::user()->id)->get();

        foreach ($bin  as $b) {
            $b->order_id = $order->id;
            $b->status = '1';
            $item = Item::find($b->item_id);
            $item->count = $item->count - $b->count;
            $item->save();
            $b->save();
        }

        return response()->json(['order' => 'success'], 200);
    }

    public function order()
    {
        $orders = Bin::select(
            'orders.id as id',
            'orders.status as status',
            'orders.comment as comment',
            'orders.created_at as created_at',
            'orders.user_id as user_id'
        )
            ->join('orders', 'orders.id', 'bins.order_id')
            ->where('bins.status', '1')
            ->where('orders.user_id', Auth::user()->id)
            ->groupBy(
                'orders.id',
                'orders.status',
                'orders.comment',
                'orders.created_at',
                'orders.user_id'
            )  // ВСЕ поля из SELECT!
            ->orderBy('orders.created_at', 'desc')
            ->get();

        foreach ($orders as $order) {
            $order->items = Bin::select('bins.count', 'items.name', 'items.img', 'items.price')
                ->join('items', 'items.id', 'bins.item_id')
                ->where('bins.order_id', $order->id)
                ->get();

            $order->count = $order->items->sum('count');
        }

        return view('myorders', ['orders' => $orders]);
    }

    public function deleteOrder($id)
    {

        $bins = Bin::where('order_id', $id)->get();

        foreach ($bins as $bin) {
            $item = Item::find($bin->item_id);
            if ($item) {
                $item->count += $bin->count;
                $item->save();
            }
        }

        Bin::where('order_id', $id)->delete();

        $order = Order::find($id);
        if ($order) {
            $order->delete();
        }

        return redirect()->back();
    }
}
