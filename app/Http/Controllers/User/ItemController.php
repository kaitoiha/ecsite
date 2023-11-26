<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('item');

            if (!is_null($id)) {
                $itemId = Product::availableItems()->where('products.id', $id)->exists();
                if (!$itemId) {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $sort = $request->get('sort');
        $pagination = $request->get('pagination');
        $products = Product::availableItems()
        ->sortOrder($request->sort)
        ->paginate($request->pagination ?? '20');

        return view('user.index', compact('products', 'sort', 'pagination'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum('quantity');

        // 一旦Maxを9とする
        if ($quantity > 9) {
            $quantity = 9;
        }

        return view('user.show',
        compact('product', 'quantity'));
    }
}
