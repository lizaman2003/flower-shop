<?php

namespace App\Http\Controllers;

use App\Models\Bin;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function admin()
    {

        $category = Category::all();
        $items = Item::orderBy('created_at', 'desc')->get();
        $orders = Order::select(
            'orders.id as id',
            'orders.status as status',
            'orders.user_id as user_id',
            'orders.created_at as created_at',
            'users.name as name',
            'users.surname as surname',
            'users.patronymic as patronymic'
        )
            ->join('users', 'users.id', 'orders.user_id')
            ->orderBy('orders.created_at', 'desc')
            ->get();

        // Для каждого заказа получаем товары
        foreach ($orders as $order) {
            $order->items = Bin::select(
                'bins.count',
                'bins.id as bin_id',
                'items.name as item_name',
                'items.price as item_price',
                'items.img as item_img'
            )
                ->join('items', 'items.id', 'bins.item_id')
                ->where('bins.order_id', $order->id)
                ->get();
 
            // Считаем общую сумму заказа
            $order->total = $order->items->sum(function ($item) {
                return $item->count * $item->item_price;
            });
        }

         $clientsCount = User::where('is_admin', 0)->count();

        return view('admin', ['category' => $category, 'items' => $items, 'orders' => $orders, 'clientsCount' => $clientsCount,]);
    }


    public function deleteCategory($id)
    {
        Item::where('category_id', $id)->delete();
        Category::where('id', $id)->delete();
        return redirect()->back();
    }

    public function createCategory(Request $r)
    {
        Category::create([
            'name' => $r->name
        ]);
        return redirect()->back();
    }

    public function deleteItem($id)
    {
        Bin::where('item_id', $id)->delete();
        Item::where('id', $id)->delete();
        return redirect()->back();
    }
    public function filter(Request $r)
    {
        if ($r->status == 'Все') {
            $orders = Order::select(
                'orders.id as id',
                'orders.user_id as user_id',
                'orders.status as status',
                'orders.created_at as created_at',
                'users.name as name',
                'users.surname as surname',
                'users.patronymic as patronymic'
            )
                ->join('users', 'users.id', 'orders.user_id')
                ->orderBy('orders.created_at', 'desc')
                ->get();
        } else {
            $orders = Order::select(
                'orders.id as id',
                'orders.user_id as user_id',
                'orders.status as status',
                'orders.created_at as created_at',
                'users.name as name',
                'users.surname as surname',
                'users.patronymic as patronymic'
            )
                ->join('users', 'users.id', 'orders.user_id')
                ->where('orders.status', $r->status)
                ->orderBy('orders.created_at', 'desc')
                ->get();
        }

        // Для каждого заказа получаем товары
        foreach ($orders as $order) {
            $order->items = Bin::select(
                'bins.count',
                'bins.id as bin_id',
                'items.name as item_name',
                'items.price as item_price',
                'items.img as item_img'
            )
                ->join('items', 'items.id', 'bins.item_id')
                ->where('bins.order_id', $order->id)
                ->get();

            $order->total = $order->items->sum(function ($item) {
                return $item->count * $item->item_price;
            });
        }

        return view('incl.orders', ['orders' => $orders]);
    }

    public function selectStatus1(Request $r)
    {
        $order = Order::find($r->id);
        $order->status = $r->status;
        $order->save();
        return redirect()->back();
    }
    public function selectStatus2(Request $r)
    {
        $order = Order::find($r->id);
        $order->status = $r->status;
        $order->comment = $r->comment;
        $order->save();
        return redirect()->back();
    }

    public function createItem(Request $r)
    {

        $file = Storage::putFile('public/img', $r->file);

        Item::create([
            'name' => $r->name,
            'country' => $r->country,
            'type' => $r->type,
            'color' => $r->color,
            'category_id' => $r->category,
            'count' => $r->count,
            'price' => $r->price,
            'img' => Storage::url($file)
        ]);
        return redirect()->back();
    }
    public function editItemPage($id)
    {
        $category = Category::all();
        $item = Item::find($id);

        return view('edititem', ['category' => $category, 'item' => $item]);
    }
    public function editItem(Request $r)
    {
        $item = Item::find($r->id);

        $item->name = $r->name;
        $item->type = $r->type;
        $item->color = $r->color;
        $item->count = $r->count;
        $item->country = $r->country;
        $item->price = $r->price;
        $item->category_id = $r->category;
        if (!is_null($r->file)) {
            $file = Storage::putFile('public/img', $r->file);
            $item->img = Storage::url($file);
        }
        $item->save();
        return redirect(route('admin'));
    }
}
