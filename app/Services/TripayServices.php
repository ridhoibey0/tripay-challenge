<?php
namespace App\Services;
class TripayServices
{
    public function getPaymentsChannel()
    {
        $apiKey = config('tripay.api_key');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => 'https://tripay.co.id/api-sandbox/merchant/payment-channel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        return $response ? $response : $error;
    }
    public function createTransaction($method, $product)
    {
        $apiKey = config('tripay.api_key');
        $privateKey = config('tripay.private_key');
        $merchantCode = config('tripay.merchant_code');
        $merchantRef = 'RI-' . time();
        $data = [
            'method' => $method,
            'merchant_ref' => $merchantRef,
            'amount' => $product->price,
            'customer_name' => 'Ridho Azkia Azhar',
            'customer_email' => 'ridhoazkiaa@gmail.com',
            'customer_phone' => '087802337554',
            'order_items' => [
                [
                    'sku' => $product->sku,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => 1
                ],
            ],

            'expired_time' => time() + 24 * 60 * 60, // 24 jam
            'signature' => hash_hmac('sha256', $merchantCode. $merchantRef . $product->price, $privateKey),
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_URL => 'https://tripay.co.id/api-sandbox/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);


        return $response ? $response : $error;
    }
}
