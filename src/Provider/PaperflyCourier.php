<?php
namespace Wddyousuf\Paperfly\Provider;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Hamcrest\Number\OrderingComparison;
use Illuminate\Support\Facades\DB;
use Wddyousuf\Paperfly\Exception\ParameterException;

class PaperflyCourier{
    public function sendRequest(array $orderInformation=[]){

        if(count($orderInformation) ==0)
        {
            throw new ParameterException('Send request array parameter missing');
        }

        $environment=env('APP_ENV');
        $baseurl=$this->baseUrl($environment);
        $data=[
            "merOrderRef"=>$orderInformation['OrderNo'],
            "pickMerchantName"=>$orderInformation['MerchantName'],
            "pickMerchantAddress"=>$orderInformation['MerchantAddress'],
            "pickMerchantThana"=>$orderInformation['MerchantThana'],
            "pickMerchantDistrict"=>$orderInformation['MerchantDistrict'],
            "pickupMerchantPhone"=>$orderInformation['MerchantPhone'],
            "productSizeWeight"=>$orderInformation['SizeWeight'],
            "productBrief"=>$orderInformation['productDetails'],
            "packagePrice"=>$orderInformation['packagePrice'],
            "deliveryOption"=>$orderInformation['deliveryType'],
            "custname"=>$orderInformation['CustomerName'],
            "custaddress"=>$orderInformation['CustomerAddress'],
            "customerThana"=>$orderInformation['CustomerThana'],
            "customerDistrict"=>$orderInformation['CustomerDistrict'],
            "custPhone"=>$orderInformation['CustomerPhone']
        ];
        $headers=[
            'Content-Type'=>'application/json',
            'Accept'        => 'application/json',
            'paperflykey' => config('paperfly.paperflykey')
        ];
        $content=array(
            'headers'=>$headers,
            'json'=>$data
        );
        // dd($content);
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify'=> false,
        ]);
        try {
            $response =$client->request('POST',$baseurl.'/OrderPlacement',$content);
            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                $message=$response->success->message;
                $tracking_id=$response->success->tracking_number;
                return $tracking_id;
            }else{
                return 'Request Failed';
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
        }


    }

    public function trackOrder($orderId){
        $environment=env('APP_ENV');
        $baseurl=$this->baseUrl($environment);
        $headers=[
            'Content-Type'=>'application/json',
            'Accept'        => 'application/json',
            'paperflykey' => config('paperfly.paperflykey')
        ];
        $data=[
            "ReferenceNumber"=>$orderId
        ];
        $content=array(
            'headers'=>$headers,
            'json'=>$data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify'=> false,
        ]);
        try {
            $response =$client->request('POST',$baseurl.'/API-Order-Tracking',$content);
            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                $message=$response->success;
                return $message;
            }else{
                return 'Request Failed';
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
        }


    }

    public function courierInvoice($orderId){
        $environment=env('APP_ENV');
        $baseurl=$this->baseUrl($environment);
        $headers=[
            'Content-Type'=>'application/json',
            'Accept'        => 'application/json',
            'paperflykey' => config('paperfly.paperflykey')
        ];
        $data=[
            "ReferenceNumber"=>$orderId
        ];
        $content=array(
            'headers'=>$headers,
            'json'=>$data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify'=> false,
        ]);
        try {
            $response =$client->request('POST',$baseurl.'/api/v1/invoice-details/',$content);
            dd($response->getStatusCode());
            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                $message=$response->success;
                return $message;
            }else{
                return 'Request Failed';
            }
        } catch (ClientException $e) {

            throw new \Exception($e->getMessage());
        }


    }

    public function CourierOrderCancel($orderId){
        $environment=env('APP_ENV');
        $baseurl=$this->baseUrl($environment);
        $headers=[
            'Content-Type'=>'application/json',
            'Accept'        => 'application/json',
            'paperflykey' => config('paperfly.paperflykey')
        ];
        $data=[
            "order_id"=>$orderId
        ];
        $content=array(
            'headers'=>$headers,
            'json'=>$data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify'=> false,
        ]);
        try {
            $response =$client->request('POST',$baseurl.'/api/v1/cancel-order/',$content);
            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                $message=$response->success;
                return $message;
            }else{
                return 'Request Failed';
            }
        } catch (ClientException $e) {
            // dd($e);

            throw new \Exception($e->getMessage());
        }


    }

    public function baseUrl($environment){
        if ($environment=='local') {
            return 'https://sandbox.paperfly-bd.com';
        } else {
            return 'https://sandbox.paperfly-bd.com';
        }

    }
}