<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
class PaymentController extends Controller
{
    public function payWithJazzCash(Request $request)
    {
            // Get the JazzCash credentials
            $merchantID = env('JAZZCASH_MERCHANT_ID');
            $password = env('JAZZCASH_PASSWORD');
            $integritySalt = env('JAZZCASH_INTEGRITY_SALT');
            $returnUrl = env('JAZZCASH_RETURN_URL');
            $txnRefNo = uniqid(); // Unique transaction reference number

            // Payment details
            $amount = $request->input('amount') * 100; // Multiply by 100 as per JazzCash requirement
            $dateTime = now()->format('YmdHis'); // Current date-time in required format

            // Parameters to send
            $params = [
            'pp_Version' => '1.1',
            'pp_TxnType' => 'MWALLET',
            'pp_Language' => 'EN',
            'pp_MerchantID' => $merchantID,
            'pp_Password' => $password,
            'pp_Amount' => $amount,
            'pp_TxnRefNo' => $txnRefNo,
            'pp_Description' => 'Room Reservation Payment',
            'pp_TxnDateTime' => $dateTime,
            'pp_ReturnURL' => $returnUrl,
        ];

        // Generate the secure hash
        $hashString = $integritySalt . '&' . implode('&', $params);
        $secureHash = hash_hmac('sha256', $hashString, $integritySalt);

        // Add the secure hash to the parameters
        $params['pp_SecureHash'] = $secureHash;

        // Redirect to JazzCash Payment Gateway
        $jazzcashUrl = "https://sandbox.jazzcash.com.pk/CustomerPortal/transactionmanagement/merchantform";
        
        return view('redirect-to-jazzcash', ['url' => $jazzcashUrl, 'params' => $params]);
    }

    public function paymentCallback(Request $request)
    {
        // Capture callback parameters
        $status = $request->input('pp_ResponseCode'); // '000' means success
        $transactionRefNo = $request->input('pp_TxnRefNo');

        if ($status == '000') {
            // Update booking status
            return redirect()->route('success.page')->with('success', 'Payment successful!');
        } else {
            return redirect()->route('error.page')->with('error', 'Payment failed!');
        }
    }
}
