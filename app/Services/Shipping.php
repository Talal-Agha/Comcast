<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use \Shippo;
use \Shippo_CarrierAccount;
use \Shippo_Address;
use \Shippo_Shipment;
use \Shippo_Transaction;
use Usps;
use Usps\RatePackage;
new USPS\OpenDistributeLabel;
new USPS\AddressVerify;
new USPS\Address;

class Shipping
{

    public $from_address = [
        'object_purpose' => 'PURCHASE',
        'name' => 'Xfinity',
        'company' => 'Xfinity',
        'street1' => '10 East Memorial Road',
        'city' => 'Oklahoma',
        'state' => 'OK',
        'zip' => '73114-2205',
        'country' => 'US',
        'phone' => '+1 855 527 2687',
        'email' => 'sales@easyzigbee.com'
    ];

    public $parcels = [
        'length' => '5',
        'width' => '5',
        'height' => '5',
        'distance_unit' => 'in',
        'weight' => '2',
        'mass_unit' => 'lb',
    ];

    public function __construct()
    {
        // Grab this private key from
        // .env and setup the Shippo api
        Shippo::setApiKey(env('SHIPPO_PRIVATE'));
    }


    /**
    * Validate an address through Shippo service
    *
    * @param Order $order
    * @return Shippo_Adress
    */
    function count_digit($number) {
  return strlen($number);
}
    public function validateAddress(Order $order){
        $to_address = $order;
        $verify = new \USPS\AddressVerify('830JASCO1006');
$address = new \USPS\Address();
$address->setFirmName('Apartment');
$address->setApt($to_address->address_1);
$address->setAddress('');
$address->setCity($to_address->city);
$address->setState($to_address->state);
if ($this->count_digit($to_address->zip) == 4) {
$address->setZip5('');
$address->setZip4($to_address->zip);
}else{
$address->setZip5($to_address->zip);
$address->setZip4('');
}

$verify->addAddress($address);
$verify->verify();
$verify->getArrayResponse();
$verify->isError();
return $verify;
}


    /**
     * Create a Shippo shipping rates
     *
     * @param Order $order
     * @return Shippo_Shipment
     */
    public function rateFirstClass(Order $order)
    {
        // Grab the shipping address from the User model
        $to_address = $order->shippingAddress();
$rateFirstClass = new Usps\Rate('830JASCO1006');
$packageFirstClass = new RatePackage();
$packageFirstClass->setService(RatePackage::SERVICE_FIRST_CLASS);
$packageFirstClass->setFirstClassMailType(RatePackage::MAIL_TYPE_LETTER);
$packageFirstClass->setZipOrigination(73114);
$packageFirstClass->setZipDestination($to_address["zip"]);
$packageFirstClass->setPounds(0);
$packageFirstClass->setOunces(3.5);
$packageFirstClass->setContainer('');
$packageFirstClass->setSize(RatePackage::SIZE_REGULAR);
$packageFirstClass->setField('Machinable', true);
$rateFirstClass->addPackage($packageFirstClass);
$return = simplexml_load_string($rateFirstClass->getRate());
if ($rateFirstClass->isSuccess()) {
    return $return->Package->Postage;
}
}
        public function ratePriorityMail(Order $order){
        // Grab the shipping address from the User model
$to_address = $order->shippingAddress();
$ratePriorityMail = new Usps\Rate('830JASCO1006');
$packagePriorityMail = new RatePackage();
$packagePriorityMail->setService(RatePackage::SERVICE_PRIORITY);
$packagePriorityMail->setFirstClassMailType(RatePackage::MAIL_TYPE_LETTER);
$packagePriorityMail->setZipOrigination(73114);
$packagePriorityMail->setZipDestination($to_address["zip"]);
$packagePriorityMail->setPounds(0);
$packagePriorityMail->setOunces(3.5);
$packagePriorityMail->setContainer('');
$packagePriorityMail->setSize(RatePackage::SIZE_REGULAR);
$packagePriorityMail->setField('Machinable', true);
$ratePriorityMail->addPackage($packagePriorityMail);
$return = simplexml_load_string($ratePriorityMail->getRate());
if ($ratePriorityMail->isSuccess()) {
    return $return->Package->Postage;
}
}
        public function rateServiceExpress(Order $order){
        // Grab the shipping address from the User model
$to_address = $order->shippingAddress();
$rateServiceExpress = new Usps\Rate('830JASCO1006');
$packageServiceExpress = new RatePackage();
$packageServiceExpress->setService(RatePackage::SERVICE_EXPRESS);
$packageServiceExpress->setFirstClassMailType(RatePackage::MAIL_TYPE_LETTER);
$packageServiceExpress->setZipOrigination(73114);
$packageServiceExpress->setZipDestination($to_address["zip"]);
$packageServiceExpress->setPounds(0);
$packageServiceExpress->setOunces(3.5);
$packageServiceExpress->setContainer('');
$packageServiceExpress->setSize(RatePackage::SIZE_REGULAR);
$packageServiceExpress->setField('Machinable', true);
$rateServiceExpress->addPackage($packageServiceExpress);
$return = simplexml_load_string($rateServiceExpress->getRate());
if ($rateServiceExpress->isSuccess()) {
    return $return->Package->Postage;
}
}

    /**
     * Create the shipping label transaction
     *
     * @param $rate_id -- object_id from rates_list
     * @return Shippo_Transaction
     */
    public function createLabel($order)
    {
        $label = new \USPS\OpenDistributeLabel('830JASCO1006');
$label->setFromAddress('John', 'Doe', 'Jasco', '5161 Lankershim Blvd', 'North Hollywood', 'CA', '73114', '# 204');
$label->setToAddress($order->first_name.$order->last_name,$order->address_1,$order->city,$order->state,$order->zip,$order->address_2);
$label->setWeightOunces(1);
$label->createLabel();
$label->getPostData();
if ($label->isSuccess()) {
    dd($label->getConfirmationNumber());
    $label = $label->getLabelContents();
    if ($label) {
        $contents = base64_decode($label);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="label.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($contents));
        echo $contents;
        exit;
    }
} else {
    echo 'Error: ' . $label->getErrorMessage();
}
        // return Shippo_Transaction::create([
        //     'rate' => $rate_id,
        //     'label_file_type' => 'PDF',
        //     'async' => false
        // ]);
    }
}
