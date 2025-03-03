<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AKCybex\JazzCash\JazzCash;

class PaymentController extends Controller
{
    /**
     * Pay with JazzCash
     */
    public function payWithJazzCash(Request $request)
    {
        // JazzCash API credentials
        $merchantId = env('JAZZCASH_MERCHANT_ID', ''); // Replace with your JazzCash Merchant ID
        $password = env('JAZZCASH_PASSWORD', ''); // Replace with your JazzCash password
        $integritySalt = env('JAZZCASH_SALT', ''); // Replace with your JazzCash integrity salt

        // Prepare transaction data
        $txnRefNo = uniqid(); // Unique transaction reference
        $amount = $request->amount * 100; // Amount in Paisa
        $postData = [
            'pp_Version'          => '1.1',
            'pp_TxnType'          => 'MWALLET',
            'pp_Language'         => 'EN',
            'pp_MerchantID'       => $merchantId,
            'pp_SubMerchantID'    => '',
            'pp_Password'         => $password,
            'pp_BankID'           => '',
            'pp_ProductID'        => '',
            'pp_TxnRefNo'         => $txnRefNo,
            'pp_Amount'           => $amount,
            'pp_TxnCurrency'      => 'PKR',
            'pp_TxnDateTime'      => now()->format('YmdHis'),
            'pp_BillReference'    => 'billRef',
            'pp_Description'      => 'Room Reservation Payment',
            'pp_TxnExpiryDateTime'=> now()->addMinutes(30)->format('YmdHis'),
            'pp_ReturnURL'        => route('payment.response'),
            'pp_SecureHash'       => '',
            'ppmpf_1'             => '1',
            'ppmpf_2'             => '2',
            'ppmpf_3'             => '3',
            'ppmpf_4'             => '4',
            'ppmpf_5'             => '5',
        ];

        // Generate secure hash
        ksort($postData);
        $hashString = $integritySalt;
        foreach ($postData as $key => $value) {
            if (!empty($value)) {
                $hashString .= '&' . $value;
            }
        }
        $postData['pp_SecureHash'] = hash_hmac('sha256', $hashString, $integritySalt);

        // Redirect to JazzCash payment page
        $jazzcashUrl = 'https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform/';
        return view('redirect-to-jazzcash', ['url' => $jazzcashUrl, 'postData' => $postData]);
    }


    /**
     * Handle JazzCash Payment Response
     */
    public function jazzcashResponse(Request $request)
    {
        // Your JazzCash Integrity Salt
        $integritySalt = env('JAZZCASH_SALT', ''); // Replace with your actual integrity salt

        // Get all response data except pp_SecureHash
        $responseData = $request->all();
        $secureHash = $responseData['pp_SecureHash'] ?? '';
        unset($responseData['pp_SecureHash']);

        // Sort data by key
        ksort($responseData);

        // Generate the hash string
        $hashString = $integritySalt;
        foreach ($responseData as $key => $value) {
            if (!empty($value)) {
                $hashString .= '&' . $value;
            }
        }

        // Calculate hash
        $calculatedHash = hash_hmac('sha256', $hashString, $integritySalt);

        // Validate the hash
        if ($calculatedHash === $secureHash && $responseData['pp_ResponseCode'] === '000') {
            // Payment succeeded
            return view('payment-success', ['message' => 'Payment Successful!']);
        }

        // Payment failed or hash mismatch
        return view('payment-failed', ['message' => $responseData['pp_ResponseMessage'] ?? 'Payment Failed!']);
    }

}
