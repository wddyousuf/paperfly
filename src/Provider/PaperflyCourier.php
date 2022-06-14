<?php

namespace Wddyousuf\Paperfly\Provider;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Wddyousuf\Paperfly\Exception\ParameterException;

class PaperflyCourier
{
    /**
     * @throws GuzzleException
     * @throws ParameterException
     * @throws Exception
     */
    public function sendRequest(array $orderInformation = [])
    {

        if (count($orderInformation) == 0) {
            throw new ParameterException('Send request array parameter missing');
        }

        $environment = env('APP_ENV');
        $baseurl = $this->baseUrl($environment);
        $data = [
            "merOrderRef" => $orderInformation['OrderNo'],
            "pickMerchantName" => $orderInformation['MerchantName'],
            "pickMerchantAddress" => $orderInformation['MerchantAddress'],
            "pickMerchantThana" => $orderInformation['MerchantThana'],
            "pickMerchantDistrict" => $orderInformation['MerchantDistrict'],
            "pickupMerchantPhone" => $orderInformation['MerchantPhone'],
            "productSizeWeight" => $orderInformation['SizeWeight'],
            "productBrief" => $orderInformation['productDetails'],
            "packagePrice" => $orderInformation['packagePrice'],
            "deliveryOption" => $orderInformation['deliveryType'],
            "custname" => $orderInformation['CustomerName'],
            "custaddress" => $orderInformation['CustomerAddress'],
            "customerThana" => $orderInformation['CustomerThana'],
            "customerDistrict" => $orderInformation['CustomerDistrict'],
            "custPhone" => $orderInformation['CustomerPhone']
        ];

        $content = array(
            'headers' => $this->getHeader(),
            'json' => $data
        );

        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify' => false,
        ]);
        try {
            $response = $client->request('POST', $baseurl . '/OrderPlacement', $content);
            if ($response->getStatusCode() == 200) {
                $responseBody = $response->getBody();
                $response = json_decode($responseBody->getContents());
                $response->success->message;
                return $response->success->tracking_number;
            } else {
                return 'Request Failed';
            }
        } catch (ClientException $e) {
            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param $orderId
     * @return string
     * @throws GuzzleException
     */
    public function trackOrder($orderId)
    {
        $environment = $this->getEnv();
        $baseurl = $this->baseUrl($environment);
        $headers = $this->getHeader();
        $data = [
            "ReferenceNumber" => $orderId
        ];
        $content = array(
            'headers' => $headers,
            'json' => $data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify' => false,
        ]);
        try {
            $response = $client->request('POST', $baseurl . '/API-Order-Tracking', $content);
            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                $message = $response->success;
                return $message;
            } else {
                return 'Request Failed';
            }
        } catch (ClientException $e) {
            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param $orderId
     * @return string
     * @throws GuzzleException
     * @throws Exception
     */
    public function courierInvoice($orderId)
    {
        $environment = $this->getEnv();
        $baseurl = $this->baseUrl($environment);

        $data = [
            "ReferenceNumber" => $orderId
        ];
        $content = array(
            'headers' => $this->getHeader(),
            'json' => $data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify' => false,
        ]);
        try {
            $response = $client->request('POST', $baseurl . '/api/v1/invoice-details/', $content);

            if ($response->getStatusCode() == 200) {
                $x = $response->getBody();
                $response = json_decode($x->getContents());
                return $response->success;
            } else {
                return 'Request Failed';
            }
        } catch (ClientException $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param $orderId
     * @return string
     * @throws GuzzleException
     * @throws Exception
     */
    public function CourierOrderCancel($orderId)
    {
        $environment = $this->getEnv();
        $baseurl = $this->baseUrl($environment);

        $data = [
            "order_id" => $orderId
        ];
        $content = array(
            'headers' => $this->getHeader(),
            'json' => $data
        );
        $client = new Client([
            'auth' => [config('paperfly.username'), config('paperfly.password')],
            'verify' => false,
        ]);
        try {
            $response = $client->request('POST', $baseurl . '/api/v1/cancel-order/', $content);
            if ($response->getStatusCode() == 200) {
                $responseBody = $response->getBody();
                $response = json_decode($responseBody->getContents());
                return $response->success;
            } else {
                return 'Request Failed';
            }
        } catch (ClientException $e) {

            throw new Exception($e->getMessage());
        }


    }

    /**
     * @param $environment
     * @return string
     */
    public function baseUrl($environment)
    {
        if ($environment == 'local') {
            return 'https://sandbox.paperfly-bd.com';
        } else {
            return 'https://sandbox.paperfly-bd.com';
        }

    }

    /**
     * @return mixed
     */
    private function getEnv()
    {
        return env('APP_ENV');
    }

    /**
     * @return array
     */
    private function getHeader(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'paperflykey' => config('paperfly.paperflykey')
        ];
    }
}
