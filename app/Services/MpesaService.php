<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $consumerKey = 'QPlUkTEx4LLViKrR1IREk0SRu4YlVlA1';
    private $consumerSecret = 'xvpwoeS55aUys0tY';
    private $BusinessShortCode = '4092475';
    private $Passkey = '8f62a516b3e1e68a7120bb499b078e20d88520af53401d3589e4e7a7e288ed83';
    private $CallBackURL = 'https://starlinkkenya.co.ke/stkpush/callback';
    private $Partb = '4092475';

    public function initiateStkPush($postedPhoneNumber, $postedAmount, $AccountReference, $TransactionDesc)
    {
        date_default_timezone_set('Africa/Nairobi');

        $accessToken = $this->getAccessToken();
        $response = $this->makeStkPushRequest($accessToken, $postedPhoneNumber, $postedAmount, $AccountReference, $TransactionDesc);

        return $this->handleResponse($response);
    }

    private function getAccessToken()
    {
        $client = new Client();
        $response = $client->request('GET', 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials', [
            'headers' => ['Content-Type' => 'application/json; charset=utf8'],
            'auth' => [$this->consumerKey, $this->consumerSecret]
        ]);

        $result = json_decode($response->getBody()->getContents());

        return $result->access_token;
    }

    private function makeStkPushRequest($accessToken, $postedPhoneNumber, $postedAmount, $AccountReference, $TransactionDesc)
    {
        $Timestamp = date('YmdHis');
        $Password = base64_encode($this->BusinessShortCode . $this->Passkey . $Timestamp);

        $client = new Client();
        $response = $client->request('POST', 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $accessToken
            ],
            'json' => [
                'BusinessShortCode' => $this->BusinessShortCode,
                'Password' => $Password,
                'Timestamp' => $Timestamp,
                'TransactionType' => 'CustomerBuyGoodsOnline',
                'Amount' => $postedAmount,
                'PartyA' => $postedPhoneNumber,
                'PartyB' => $this->Partb,
                'PhoneNumber' => $postedPhoneNumber,
                'CallBackURL' => $this->CallBackURL,
                'AccountReference' => $AccountReference,
                'TransactionDesc' => $TransactionDesc
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function handleResponse($response_data)
    {
        if ($response_data !== null) {
            $responseCode = $response_data['ResponseCode'];
            Log::info($response_data);
            return ['ResponseCode' => $responseCode];
        } else {
            return ['error' => 'Failed to decode JSON response.'];
        }
    }
}
