<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarketPlaceController extends Controller
{
    /* to handle index view */
    public function index ()
    {
        /* get banner and product data */
        $banner = Banner::where('is_active', 1)->get();
        $product = Product::where('is_active', 1)->get();

        /* get count cart */
        $userId = auth()->check() ? auth()->user()->id : null;
        $countCart = Cart::where([['user_id', $userId], ['is_checkout', 0]])->count();

        /* parsing to view */
        return view('marketplace.index', compact('banner', 'product', 'countCart'));
    }

    /* to handle mycart view */
    public function myCart ()
    {
        /* get count cart */
        $userId = auth()->check() ? auth()->user()->id : null;
        $cart = Cart::with(['product'])->where([['user_id', $userId], ['is_checkout', 0]])->get();
        $countCart = $cart->count();

        /* parsing to view */
        return view('marketplace.mycart', compact('cart', 'countCart'));
    }

    /* to handle detail product */
    public function detailProduct ($slug)
    {
        /* get data product and another product from slug */
        $products = Product::where('is_active', 1)->get();
        $product = $products->firstWhere('slug', $slug);
        if (!$product) {
            return redirect()->route('MarketPlace.index')->with('error', 'Product not found');
        }
        $anotherProduct = $products->where('slug', '!=', $slug)->values();

        /* get count cart */
        $userId = auth()->check() ? auth()->user()->id : null;
        $countCart = Cart::where([['user_id', $userId], ['is_checkout', 0]])->count();

        /* parsing to view */
        return view('marketplace.detail', compact('product', 'anotherProduct', 'countCart'));
    }

    /* to add cart product */
    public function addToCart(Request $request)
    {

        /* check if user not login */
        if (!auth()->check()) {
            return response()->json(['status' => 'failed', 'message' => 'Please login first'], 200);
        }

        /* validator post data */
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:products,id',
            'slug' => 'required|string|exists:products,slug',
            'qty' => 'required|integer|min:1',
        ]);

        /* check if validation fails */
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        /* get product data */
        $product = Product::find($request->id);

        /* validate product existence and availability */
        if (!$product || $product->is_active != 1 || $product->stock < $request->qty) {
            $message = match (true) {
                !$product => 'Product not found',
                $product->is_active != 1 => 'Product is not available',
                $product->stock < $request->qty => 'Requested quantity exceeds available stock',
            };

            return response()->json(['status' => 'failed', 'message' => $message,], 200);
        }

        /* input to table cart */
        $checkCart = Cart::where([['user_id', auth()->user()->id], ['product_id', $request->id], ['is_checkout', 0]])->first();

        /* if product already and not ready in cart */
        if (!$checkCart) {
            Cart::create([
                'user_id' => auth()->user()->id,
                'product_id' => $request->id,
                'qty' => $request->qty,
                'is_checkout' => 0,
            ]);
        } else {
            $checkCart->update([
                'qty' => $checkCart->qty + $request->qty,
            ]);
        }

        /* countCart */
        $countCart = Cart::where([['user_id', auth()->user()->id], ['is_checkout', 0]])->count();

        /* parsing to view */
        return response()->json(['status' => 'success', 'message' => 'Successfully added to cart', 'cartCount' => $countCart], 200);
    }

    /* to remove product from cart */
    public function removeFromCart(Request $request)
    {
        /* check if user not login */
        if (!auth()->check()) {
            return response()->json(['status' => 'failed', 'message' => 'Please login first'], 200);
        }

        /* validator post data */
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:carts,id',
        ]);

        /* check if validation fails */
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        /* get product data */
        $cart = Cart::where([['user_id', auth()->user()->id], ['id', $request->id]])->first();

        /* validate product existence and availability */
        if (!$cart) {
            return response()->json(['status' => 'failed', 'message' => 'Product not found'], 200);
        }

        /* delete from table cart */
        $cart->delete();

        /* parsing to view */
        return response()->json(['status' => 'success', 'message' => 'Successfully removed from cart'], 200);
    }

    /* to checkout cart */
    public function checkout(Request $request)
    {
        /* check if user not login */
        if (!auth()->check()) {
            return response()->json(['status' => 'failed', 'message' => 'Please login first'], 200);
        }

        /* validator post data */
        $validator = Validator::make($request->all(), [
            'cart' => 'required|array',
            'cart.*.id' => 'required|integer|exists:carts,id',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        /* check if validation fails */
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('error', $validator->errors()->first());
        }

        /* get cart data */
        $cartIds = array_column($request->cart, 'id');
        $cart = Cart::where([['user_id', auth()->user()->id], ['is_checkout', 0]])->whereIn('id', $cartIds)->get();

        if ($cart->count() !== count($cartIds)) {
            return response()->json(['status' => 'failed', 'message' => 'One or more cart items are invalid or unavailable'], 200);
        }

        /* update qty per cart item */
        foreach ($request->cart as $item) {
            $cartItem = $cart->firstWhere('id', $item['id']);
            if ($cartItem) {
                $cartItem->qty = $item['qty'];
                $cartItem->save();
            }
        }

        /* create on table Transaction */
        $createTransaction = [];
        foreach ($cart as $item) {
            $createTransaction[] = [
                'user_id' => auth()->user()->id,
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'price' => $item->product->price,
                'status' => 100,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Transaction::insert($createTransaction);

        /* update stock product */
        foreach ($cart as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->stock -= $item->qty;
                $product->save();
            }

            /* change is_checkout */
            $item->is_checkout = 1;
            $item->save();
        }

        /* parsing to view */
        return response()->json(['status' => 'success', 'message' => 'Successfully checkout'], 200);
    }
}
