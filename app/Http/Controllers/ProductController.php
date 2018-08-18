<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use App\Models\OrderProducts;
use App\Notifications\OrderPlaced;
use App\Services\Shipping;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;
use Stripe\Charge;
use Stripe\Stripe;
use USPS\Address;
use USPS\AddressVerify;
use App\Http\Controllers\EdiController;
use DB;
use Mail;

class ProductController extends Controller
{

    public $shipping;

    public function __construct()
    {
        $this->shipping = new Shipping();
        $this->middleware('admin')->except('index', 'show', 'addToCart', 'cart', 'updateCart', 'removeFromCart', 'checkOut', 'postCheckOut', 'shipping', 'postShipping', 'pay', 'postPay', 'applyCouponCode', 'thanks');
    }

    public function index()
    {
        $products = Product::orderBy('id','desc')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required|string',
            'image' => 'required|image|mimes:jpeg,bmp,png',
            'description' => 'required',
            'price' => 'required',
            'sku' => 'required',
            'detail_images' => 'required',
            'product_type_id' => 'required',
            'video_link' => 'required|url',
        ]);
        $data['image'] = Str::random(40);
        Image::make(request('image')->getRealPath())->save(storage_path('app/public/products/' . $data['image']));
        $data['detail_images'] = [];
        foreach (request('detail_images') as $key => $detail_image) {
            $data['detail_images'][$key] = $detail_image->store('public/detail_images');
            // Image::make($data['detail_images'][$key]);
        }
        Product::create($data);
        flash('Product has been created successfully!')->success();
        return back();
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Product $product)
    {
 $this->validate(request(),[
            'name' => 'required|string',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,bmp,png',
            'price' => 'required',
            'sku' => 'required',
            'product_type_id' => 'required',
            'video_link' => 'required|url',
       ]);
        $data = request()->all();
        if (array_key_exists('image', $data)) {
            $data['image'] = Str::random(40);
            Image::make(request('image')->getRealPath())->save(storage_path('app/public/products/' . $data['image']));
        }

        if (array_key_exists('detail_images', $data)) {
            $data['detail_images'] = [];
            foreach (request('detail_images') as $key => $detail_image) {
                $data['detail_images'][] = $detail_image->store('public/detail_images');
            }
        }
        if($product->update($data)){
        flash('Product has been updated successfully!')->success();
}else{
flash('Product has Not been updated successfully!')->error();

}
        return back();
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => 1,
            'message' => 'Product has been deleted'
        ]);
    }

    public function addToCart()
    {
        $id = request('product_id');
        $quantity = request('quantity');
        $quantity = $quantity <= 0 ? 1 : $quantity;
        $cart_items[$id] = [
            'quantity' => $quantity
        ];
        $cookie = isset($_COOKIE['comcast_cart_items_cookie']) ? $_COOKIE['comcast_cart_items_cookie'] : '';
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);

        if (!$saved_cart_items) {
            $saved_cart_items = [];
        }

        if (array_key_exists($id, $saved_cart_items)) {
            flash('Product existed in the cart!')->error();
            return back();
        } else {
            if (count($saved_cart_items)>0) {
                foreach ($saved_cart_items as $key => $value) {
                    $cart_items[$key] = [
                        'quantity' => $value['quantity']
                    ];
                }
            }

            $json = json_encode($cart_items, true);
            setcookie('comcast_cart_items_cookie', $json, time()+60*60*24*30, '/');
            $_COOKIE['comcast_cart_items_cookie'] = $json;
            flash('Product has been added to the cart!')->success();
            return back();
        }
    }

    public function cart()
    {
        return view('products.cart');
    }

    public function updateCart()
    {
        $id = request('product_id');
        $quantity = request('quantity');
        $quantity = $quantity <= 0 ? 1 : $quantity;
        $cookie = $_COOKIE['comcast_cart_items_cookie'];
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);
        unset($saved_cart_items[$id]);
        setcookie('comcast_cart_items_cookie', '', time()-3600);
        $saved_cart_items[$id] = [
            'quantity' => $quantity
        ];
        $json = json_encode($saved_cart_items, true);
        setcookie('comcast_cart_items_cookie', $json, time()+60*60*24*30, '/');
        $_COOKIE['comcast_cart_items_cookie'] = $json;
        flash('Product has been updated to the cart!')->success();
        return back();
    }

    public function removeFromCart()
    {
        $id = request('product_id');
        $cookie = $_COOKIE['comcast_cart_items_cookie'];
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);
        unset($saved_cart_items[$id]);
        unset($_COOKIE['comcast_cart_items_cookie']);
        setcookie('comcast_cart_items_cookie', '', time() - 3600);
        $json = json_encode($saved_cart_items, true);
        setcookie('comcast_cart_items_cookie', $json, time()+60*60*24*30, '/');
        $_COOKIE['comcast_cart_items_cookie'] = $json;
        flash('Product has been removed from the cart!')->success();
        return back();
    }

    public function checkOut()
    {
        return view('products.check_out');
    }

    public function postCheckOut(){
        $taxAmount =0;
       request()->validate([
            'email' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'phone_number' => 'required',
        ]);
       if(request('state') == 37){
            $taxAmount = 8.375;
       }
        $cookie = $_COOKIE['comcast_cart_items_cookie'];
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);
        
        $total = 0;
        $product_ids = [];
        $quantities = [];
		$newOrderId = "9".rand(1,9).rand(111,999);
		$chkq = null;
        foreach ($saved_cart_items as $id => $item) {
            $product = Product::findOrFail($id);
            $total += $product->price*$item['quantity'];
			
            $OrderProducts = new OrderProducts;
            $OrderProducts->order_id =$newOrderId;
            $OrderProducts->product_id =$id;
            $OrderProducts->quantity = $item['quantity'];
            $OrderProducts->save();
			
            array_push($product_ids, $product->id);
            array_push($quantities, $item['quantity']);
        }
        $discount = 0;
        if (session('discount_type') == 'percent') {
            $discount = (($total + ($total*$taxAmount/100)) * session('discount')/100);
        } else {
            $discount = session('discount');
        }
        $total += ($total*$taxAmount/100);
        $total -= $discount;
        $order = new Order;
        $order->email = request('email');
        $order->first_name = request('first_name');
        $order->last_name = request('last_name');
        $order->address_1 = request('address_1');
        $order->address_2 = request('address_2');
        $order->city = request('city');
        $order->state = State::find(request('state'))->name;
        $order->zip = request('zip');
        $order->phone_number = request('phone_number');
        if (request('same_address') == null) {
            $order->same_address = 0;
        } else {
            $order->same_address = request('same_address');
        }
        $order->billing_full_name = request('billing_full_name');
        $order->billing_address_1 = request('billing_address_1');
        $order->billing_address_2 = request('billing_address_2');
        $order->billing_city = request('billing_city');
        $order->billing_state = State::find(request('state'))->name;
        $order->billing_zip = request('billing_zip');
        $order->billing_phone_number = request('billing_phone_number');
        $order->total = $total;
        $order->orderId =$newOrderId;

        $user = User::firstOrNew([
            'email' => request('email')
        ]);
        $user->save();
       $validate = $this->shipping->validateAddress($order);
        if (!$validate->isSuccess()) {
            flash($validate->getErrorMessage())->error();
            return back();
        }
        
        $order->save();
       
        //$this->emptyCart($saved_cart_items);
        return redirect()->route('shipping', compact('order'));
    }

    public function shipping()
    {
        $order = Order::findOrFail(request('order'));
        $rateFirstClass = $this->shipping->rateFirstClass($order);
        $ratePriorityMail = $this->shipping->ratePriorityMail($order);
        $rateServiceExpress = $this->shipping->rateServiceExpress($order);
        return view('products.shipping', compact('rateFirstClass','ratePriorityMail','rateServiceExpress'));
    }

    public function postShipping()
    {
     request()->validate([
            'order' => 'required',
            'amount' => 'required',
            'rate' => 'required'
        ]);
       
        $order = Order::findOrFail(request('order'));
        $new_total = $order->total + request('amount');
        $order->total = $new_total;
        $order->shipping_option = request('rate');
        $order->shipping_amount=request('amount');
        $order->save();
        return redirect()->route('pay', compact('order'));
    }

    public function pay()
    {
        return view('products.pay');
    }

    public function postPay(){
        $taxAmount = 0;
        Stripe::setApiKey(env('STRIPE_PRIVATE_KEY',''));
        try {
            $order = Order::findOrFail(request('order'));
            if($order->state == "Oklahoma"){
                $taxAmount=8.375;
            }
            if($order->same_address){
                $stripeBilling = $order->address_1." ".$order->address_2.",".$order->city.",".$order->state.",".$order->zip;
            }else{
                $stripeBilling = $order->billing_address_1." ".$order->billing_address_2.",".$order->city.",".$order->state.",".$order->zip;
            }
            Charge::create ([
                'amount' =>$order->total * 100,
                'currency' => 'USD',
                'source' => request('stripeToken'),
                'description' => 'Order from Comcast.',
                'metadata' => [
                    'email' => $order->email,
                    'order_source' => 'JASCST',
                    'order_id' => $order->orderId,
                    'order_number' => $order->orderId,
                    'tax_amount' => $taxAmount /100 * 100,
                    'shipping_amount' => $order->shipping_amount,
                    'billing_address' => $stripeBilling
                ]
            ]);
            $order->paid = 1;
            $order->save();
            session()->forget('discount_type');
            session()->forget('discount');
            $user = User::where('email', $order->email)->first();

            $orderProducts = OrderProducts::where('order_id',$order->orderId)->get();
            $to = $order->email;
            Mail::send('vendor.mail.layout', compact('order','orderProducts'),function($message) use($to){$message->to($to)->subject('Thank you for your Order');});
            EdiController::generateEdiFile($order);
            return response()->json([
                'success' => 1,
                'message' => 'Success',
                'order_id' => $order->orderId
            ]);
        } catch (Exception $e) {

            return response()->json([
                'success' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function thanks($order_id)
    {
        $order = Order::where('orderId', $order_id)->first();
        return view('products.thanks', compact('order'));
    }

    public function applyCouponCode()
    {
        $coupon_code = CouponCode::where('coupon_code', request('coupon_code'))->first();
        if ($coupon_code == null) {
            flash('The code does not exist!')->error();
            return back();
        }
        if (!$coupon_code->active) {
            flash('The code is expired!')->error();
            return back();
        }
        if ($coupon_code->type == 'percent') {
            session([
                'discount_type' => 'percent',
                'discount' => $coupon_code->amount
            ]);
        } else {
            session([
                'discount_type' => 'number',
                'discount' => $coupon_code->amount
            ]);
        }
        return back();
    }

    public function emptyCart($saved_cart_items)
    {
        header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        $cookie = $_COOKIE['comcast_cart_items_cookie'];
        $cookie = stripslashes($cookie);
        $saved_cart_items = json_decode($cookie, true);
        unset($saved_cart_items);
        unset($_COOKIE['comcast_cart_items_cookie']);
        setcookie('comcast_cart_items_cookie', '', time() - 3600);
        $json = json_encode([], true);
        setcookie('comcast_cart_items_cookie', $json, time()+60*60*24*30, '/');
        $_COOKIE['comcast_cart_items_cookie'] = $json;
        return true;
    }
}
