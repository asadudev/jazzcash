<?php

namespace zfhassaan\jazzcash;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class JazzCash
{

    protected $api_mode;
    protected $apiUrl;
    protected $merchant_id;
    protected $return_url;
    protected $password;
    protected $timezone;

//    Post Fields
    private $amount;
    private $billreference;
    private $productdescription;

    /**
     * Constructor for JazzCash Payment Gateway
     * @return void
     */
    public function __construct()
    {
        $this->initConfig();
    }


    /**
     * Initialize Config Values
     * @return void
     */
    public function initConfig(): void
    {
        $this->api_mode = config('jazzcash.mode');
        $this->api_mode === 'sandbox' ? $this->setApiUrl(config('jazzcash.sandbox_api_url')) : $this->setApiUrl(config('jazzcash.api_url'));
        $this->merchant_id = config('jazzcash.merchant_id');
        $this->return_url = config('jazzcash.return_url');
        $this->password = config('jazzcash.password');
        $this->timezone = date_default_timezone_get('Asia/Karachi');
    }

    public function sendRequest()
    {
        $data['amount'] = $this->getAmount();
        $data['billRef'] = $this->getBillRefernce();
        $data['description'] = $this->getProductDescription();
        $data['isRegisteredCustomer'] = "No";
        $data['Language'] = "EN";
        $data['TxnCurrency'] = 'PKR';
        $data['TxnDateTime'] = date('YmdHis');
        $data['TxnExpiryDateTime'] = date('YmdHis', strtotime('+1 Days'));
        $data['TxnRefNumber'] = "TR" . date('YmdHis') . mt_rand(10, 100); // You can customize it (only Max 20 Alpha-Numeric characters)
        $data['TxnType'] = '';
        $data['Version'] = '2.0';
        $data['SubMerchantID'] = '';
        $data['BankID'] = '';
        $data['ProductID'] = '';
        $data['ppmpf_1'] = '';
        $data['ppmpf_2'] = '';
        $data['ppmpf_3'] = '';
        $data['ppmpf_4'] = '';
        $data['ppmpf_5'] = '';

        dd($data);
    }


    /**
     * Set Amount for Orders
     *
     */
    public function setAmount($amount): static
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Get the amount for Order
     * @return int;
     */
    public function getAmount():int
    {
        return $this->amount;
    }

    /**
     * Set Bill Reference for Jazz Cash Order
     *
     */
    public function setBillReference($billref)
    {
        $this->billreference = $billref;
        return $this;
    }

    /**
     * Get the Bill Reference Number for Jazz Cash Order
     *
     */
    public function getBillRefernce() {
        return $this->billreference;
    }

    /**
     * Set Product Description for Jazz Cash Order
     *
     */
    public function setProductDescription($description): static
    {
        $this->productdescription = $description;
        return $this;
    }

    /**
     * Get the Product Description for Jazz Cash Order
     *
     */
    public function getProductDescription() {
        return $this->billreference;
    }

    /**
     * Set the value of apiUrl
     *
     * @param $apiUrl
     * @return  self
     */
    public function setApiUrl($apiUrl): static
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }
}
