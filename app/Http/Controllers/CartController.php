<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartDetail;
use App\Models\ShippingMethod;
use App\Models\AuctionLot;
use Session;
use Auth;
use App\Models\Product;
use App\Models\UserMembershipPlan;
use App\Models\SubscriptionPlan;
use App\Models\AdminCommission;
use QuickBooksOnline\API\DataService\DataService;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $id = null;
        $cartCount = 0;
        $product = Product::whereId($request->id)->first();
        
        if($product->user_id == Auth::id())
        {
            return response([
                'status' => false,
                'msg' => 'You can not purchase your own product.'
            ]);
        }

        if (Auth::check()) {
            
            $id = Auth::id();

            if($cartDetail = CartDetail::whereUserId(Auth::id())->whereProductId($request->id)->first())
            {
                $cartDetail->delete();
                $cartCount = CartDetail::whereUserId(Auth::id())->count();

                return response()->json([
                    'status' => true,
                    'cart' => false,
                    'cartCount' => $cartCount,
                    'msg' => 'Product removed from your cart.'
                ]);
            }
        }

        if(isset($request->qty))
        {
            $quantity = $request->qty;
        }else{
            $quantity = 1;
        }

        $cart = CartDetail::create([
            'user_id' => $id,
            'product_id' => $request->id,
            'quantity' => $quantity,
        ]);

        if(Auth::check())
        {
            $cartCount = CartDetail::whereUserId(Auth::id())->count();
        }

        return response()->json([
            'status' => true,
            'cart' => true,
            'cartCount' => $cartCount,
            'cartId' => $cart->id,
            'msg' => 'Product added to your cart.'
        ]);
    }

    public function cart()
    {
        if (Auth::check()) {
            $cartDetails = CartDetail::whereUserId(Auth::id())->get();
        } 

        return view('front-user.pages.checkout', compact('cartDetails'));
    }

    public function removeProduct(Request $request)
    {
        if(CartDetail::whereId($request->id)->delete()){
            $cartDetails = [];
            if (Auth::check()) {
                $id = Auth::id();
                $cartDetails = CartDetail::whereUserId(Auth::id())->get();
            } 
    
            $cartCount = $cartDetails->count();

            return response()->json([
                'status' => true,
                'total' => $total,
                'cartCount' => $cartCount,
                'msg' => 'Product removed from cart'
            ]);
        }else{
            
            return response()->json([
                'status' => false,
                'msg' => 'Something went wrong !'
            ]);
        }
    }

    public function orderSummary($id = null)
    {
        $cartDetails = CartDetail::whereUserId(Auth::id())->get();
        \Stripe\Stripe::setApiKey(config('settings.env.STRIPE_SECRET'));
        $customer = \Stripe\Customer::create();
        $customer_id = $customer->id;
        $intent = \Stripe\SetupIntent::create([
            'customer' => $customer->id
          ]);

        return view('front-user.pages.checkout', compact('cartDetails', 'intent'));
    }
}
