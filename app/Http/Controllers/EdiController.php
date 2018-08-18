<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\State;
use DB;
use App\Models\OrderProducts;

class EdiController extends Controller
{
    public static function generateEdiFile($order){
$host     = env('EDI_HOST', 'null');
$port     = env('EDI_PORT', 22);
$path     = env('EDI_UPLOAD_PATH', '/');
$username = env('EDI_USERNAME', 'admin');
$password = env('EDI_PASSWORD', 'admin');
$i = 0;
$orderNumber = $order->orderId;
$name = $order->first_name.$order->last_name;
if($order->state == "Oklahoma"){
    $taxamount = 8.375/100;
    $tax = "TXI*CG*".$taxamount."~";
}else{
    $tax = "TXI*CG*0~";
}
if($order->address_2 == null){
$shippingAddress = "N3*".$order->address_1;
}else{
$shippingAddress = "N3*".$order->address_1."*".$order->address_2;   
}
$shipping = $shippingAddress.
"~N4*".$order->state.
  "*".State::where("name",$order->state)->first()->code.
  "*".$order->zip."*US~PER*BD**TE*"
  .$order->phone_number."~";


$filename = 'COMCAST_'.$orderNumber.'.txt';
$textOutput = "ISA*00*          *00*          *ZZ*COMCAST       *01*082567025      *".date("ymd")."*".date("hi")."*U*00501*000000001*0*P*>~GS*PO*COMCAST*082567025*".date("ymd")."*".date("his")."*00001*X*005010~ST*850*".$orderNumber."~BEG*00*SA*".$orderNumber."**".date("Ymd")."~TD5*****".$order->shipping_option."~N1*ST*".$name."~".$shipping;

$items = OrderProducts::where('order_id',$orderNumber)->get();
foreach ($items as $item) {
$product = Product::where("id",$item->product_id)->get()->first();
$i++;
$textOutput =$textOutput."PO1*".$i."*".$item->quantity."*EA*".$product->price."**VN*".$product->sku."~";
}

$textOutput = $textOutput.$tax;
$c= $i+10;
$textOutput = $textOutput."CTT*".$i."~SE*".$c."*".$orderNumber."~GE*1*00001~IEA*1*000000001~";

try {
    $sshConnection = ssh2_connect($host, $port);
    if (! $sshConnection) {
        Log::info("Failed to open connection to $host.\n");
        die(0);
    }
    ssh2_auth_password($sshConnection, $username, $password);
    $sftp = ssh2_sftp($sshConnection);
    $sftpStream = @fopen("ssh2.sftp://".intval($sftp) . $path . $filename, 'w');
} catch(Exception $e) {
    Log::info("Failed to open SFTP connection to $host: " . $e->getMessage() . "\n");
    die(0);
}
if (!$sftpStream) {Log::info("Failed to open stream to $host\n"); die(0); }
try {
    $writeResult = @fwrite($sftpStream, $textOutput);
} catch(Exception $e) {
    Log::info("Failed to write $path/$filename to $host: " . $e->getMessage() . "\n");
    die(0);
}
if ($writeResult === false) {Log::info("Failed to write $path/$filename to $host\n");die(0);}
fclose($sftpStream);
return 1;
}

}
