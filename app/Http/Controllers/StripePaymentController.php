<?php

namespace App\Http\Controllers;
use Session;
use Stripe;
use Auth;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\CartDetail;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Notifications\OrderPlacedCustomer;
use App\Notifications\OrderPlacedAdmin;
use App\Notifications\OrderPlacedSeller;

class StripePaymentController extends Controller
{
    public function orderStore(Request $request)
    {
        $user = auth()->user(); 
        $cartDetails = CartDetail::whereUserId(Auth::id())->get();
       
        try {
            return  DB::transaction(function () use($request, $user, $cartDetails) {
                    Stripe\Stripe::setApiKey(config('settings.env.STRIPE_SECRET'));
                    
                    $token =  $request->stripeToken;

                    $stripe = Stripe\Charge::create ([
                        "amount" => $request->total * 100,
                        'currency' => 'USD',
                        'description' => 'Payment received  at '.config('app.name'),
                        'source' => $token
                    ]);

                    if($stripe['status'] == 'succeeded'){
                       $type = $cartDetails->first()->product->type ;
                       Auth::user()->assignRole($type);

                        $order = Order::create([
                        'transaction_id' => $stripe['id'],
                        'order_number' => (string) mt_rand(111111, 999999),
                        'user_id' => Auth::id(),
                        'name' => $request->name,
                        'address' => $request->address,
                        'item_total' => str_replace(',', '',$request->total),
                        'total' => str_replace(',', '',$request->total), 
                        'payment_status' => $stripe['status'], 
                        'order_status' => 'pending',
                        ]); 

                        foreach($cartDetails as $cart)
                        {
                            OrderProduct::create([
                                'order_id' => $order->id,
                                'product_id' => $cart->product_id,
                                'quantity' => $cart->quantity,
                                'price' => $cart->product->price,
                                'item_total' => $cart->product->price * $cart->quantity,
                            ]);

                        }

                        $admin = User::whereHas('roles', function($q){
                            $q->where('name', 'admin');
                        })->first();

                        $user->notify(new OrderPlacedCustomer($order));  

                        $admin->notify(new OrderPlacedAdmin($order));  

                        CartDetail::whereUserId(Auth::id())->delete();

                        return redirect('/dashboard')->with('success','Your order placed successfully.');
                    }else{
                        return redirect()->back()->with('error','Something went wrong.');
                    }
                // } catch (Exception $e) {
                //     return back()->with('error',$e->getMessage());
                // }
            });
        } catch (Exception $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
