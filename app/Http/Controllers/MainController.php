<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($id = 0)
    {
        $category = Category::all();
        
        // Создаем запрос
        $query = Item::where('count', '>', 0)->orderBy('created_at', 'desc');
        
        // Если категория выбрана
        if ($id != 0) {
            $query->where('category_id', $id);
        }
        
        // ПАГИНАЦИЯ - 9 товаров на страницу
        $items = $query->paginate(6);
        
        return view('index', [
            'category' => $category, 
            'items' => $items, 
            'categorys' => $id
        ]);
    }

    public function item($id)
    {
        $item = Item::find($id);
        return view('item', ['item' => $item]);
    }
    public function we()
    {
        $items = Item::where('count', '>', '0')->orderBy('created_at', 'desc')->limit(6)->get();
        return view('we', ['items' => $items]);
    }
    public function contact()
    {
        return view('contact');
    }

public function sorting(Request $r)
{
    $query = Item::where('count', '>', 0);
    
    if ($r->id != 0) {
        $query->where('category_id', $r->id);
    }
    
    $parts = explode('_', $r->type);
    $field = $parts[0];
    $direction = $parts[1] ?? 'asc';
    

    $allowedFields = ['name', 'price'];
    if (!in_array($field, $allowedFields)) {
        $field = 'name';
        $direction = 'asc';
    }
    
    $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';
    
    $items = $query->orderBy($field, $direction)->paginate(6);
    
    return view('incl.items', ['items' => $items]);
}
}
