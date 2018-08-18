<?php

namespace App\Http\Controllers;

use App\Models\CouponCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Usps;
use Usps\RatePackage;

class HomeController extends Controller
{
    /**
     * Show the application index.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function energy()
    {
        return view('energy-saving-tips');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $orders = Order::where('email', auth()->user()->email)->paginate(5, ['*'], 'orders');
        return view('home', compact('orders'));
    }

    /**
     * Show the application admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $products = Product::paginate(5, ['*'], 'products');
        $product_types = ProductType::paginate(5, ['*'], 'product-types');
        $orders = Order::paginate(5, ['*'], 'orders');
        $coupon_codes = CouponCode::paginate(5, ['*'], 'coupon-codes');
        return view('admin', compact('products', 'product_types', 'orders', 'coupon_codes'));
    }
   public function uspsTest(){
$rate = new Usps\Rate('830JASCO1006');
$package = new RatePackage();
$package->setService(RatePackage::SERVICE_FIRST_CLASS);
$package->setFirstClassMailType(RatePackage::MAIL_TYPE_LETTER);
$package->setZipOrigination(73114);
$package->setZipDestination(91730);
$package->setPounds(0);
$package->setOunces(3.5);
$package->setContainer('');
$package->setSize(RatePackage::SIZE_REGULAR);
$package->setField('Machinable', true);
$rate->addPackage($package);

 $arr = simplexml_load_string($rate->getRate());
if ($rate->isSuccess()) {
    dd($arr);
    echo 'Done';
   
} else {
    echo 'Error: '.$rate->getErrorMessage();
}
}
}
