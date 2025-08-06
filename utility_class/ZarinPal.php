<?php

namespace utility_class;

class ZarinPal
{

    public $merchant_id='ef80de98-374d-4070-942f-6b3f3ab34fe2';
    public $amount;
    public $callback_url='http://localhost/E-commerce%20Website/aboutUser/zarinpal/callback.php';

    public $transaction_type='sandbox';

    public $description='a';

    public $mobile='09307181124';

    public $email='navid@gmail.com';

    function __construct($amount)
    {
        $this->amount = $amount;
    }

    public function getResponse()
    {
        $data=[
            'merchant_id'=>$this->merchant_id,
            'amount'=>$this->amount,
            'callback_url'=>$this->callback_url,
            'description'=>$this->description,
            'metadata'=>[
                'mobile'=>$this->mobile,
                'email'=>$this->email
            ]
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://'.$this->transaction_type.'.zarinpal.com/pg/v4/payment/request.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }
    public function connectResult(){
        $response=$this->getResponse();
        if (!empty($response['data']) &&  $response['data']['code']==100) {
            return ['result'=>true,'data'=>$response['data']['authority']];
        }else
            return ['result'=>false,'message'=>$response['errors']['message'],'code'=>$response['errors']['code']];
    }
    public function linkUrl($authority){
        header('Location: https://'.$this->transaction_type.'.zarinpal.com/pg/StartPay/'.$authority);
    }
    public function callback($authority){
        $response=$this->getResponse();
        $data=[
            "merchant_id"=>$this->merchant_id,
             "amount"=> $this->amount,
            "authority"=> $authority
        ];

        //{"data":{"wages":null,"code":100,"message":"Paid","card_hash":"0866A6EAEA5CB085E4CF6EF19296BF19647552DD5F96F1E530DB3AE61837EFE7","card_pan":"999999******9999","ref_id":2997001,"fee_type":"Merchant","fee":1000,"shaparak_fee":1200,"order_id":null},"errors":[]}

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response, true);
        return $response;
    }

    public function validation($authority)
    {
        $response=$this->callback($authority);
        if (!empty($response['data']) &&  $response['data']['code']==100) {
            return ['result'=>true,'message'=>'Transaction Successful!'];
        }else
            return ['result'=>false,'message'=>$response['errors']['message'],'code'=>$response['errors']['code']];

    }
}