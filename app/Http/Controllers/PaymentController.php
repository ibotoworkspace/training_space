<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Paystack Integration
use Yabacon\Paystack;
use Yabacon\Paystack\MetadataBuilder;

// Paypal Integration
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

use Illuminate\Support\Facades\Config;
use App\payments;
use Auth;

class PaymentController extends Controller
{
    
    public function payWithPaystack(Request $request)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY');
        $paystack = new Paystack($secretKey);

        // Validate the request
        $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        // Set the callback URL based on the environment
        $callbackUrl = env('APP_URL') . '/paystack/callback';

        // Initialize Paystack transaction
        $transaction = $paystack->transaction->initialize([
            'amount' => $request->amount * 100, // Amount in kobo
            'email' => auth()->user()->email,
            'callback_url' => $callbackUrl, // Specify the callback URL
            'callback_method' => "POS                                                                                                                                                                                                                        T", // Specify the callback method
            'metadata' => [
                'user_id' => auth()->id(),
                'course_id'=>$request->course_id,
            ]
        ]);
        // Redirect user to Paystack payment page
        return redirect()->to($transaction->data->authorization_url);
    }

    public function handlePaymentCallback(Request $request)
    {
        //dd($request);
        // Process the payment response and save payment details to database
        $transactionReference = $request->input('reference');
        $paymentStatus = $request->input('trxref');

        // Retrieve user_id from metadata
        $metadata = $request->input('metadata');
        $userId = isset($metadata['user_id']) ? $metadata['user_id'] : null;
        $amount = isset($metadata['amount']) ? $metadata['amount'] : null;
        $course_id = isset($metadata['course_id']) ? $metadata['course_id'] : null;
        // Save payment details to database
        payments::create([
            'reference_no' => $transactionReference,
            'payment_status' => $paymentStatus,
            'user_id' => $userId,
            'amount' => $amount,
            'payment_method' => 'Paystack', // Assuming you want to track payment method
            'payment_status'=>'Paid',
            'course_id'=>$course_id
        ]);

        // Return a response indicating the payment status
        if ($paymentStatus === 'success') {
            return redirect()->back()->with('success', 'Payment successful!');
        } else {
            return redirect()->route('home')->with('error', 'Payment failed. Please try again.');
        }
    }

    public function createPaypalPayment(Request $request)
    {
        // Retrieve PayPal client ID and secret from configuration
        // $clientId = config('paypal.client_id');
        // $secret = config('paypal.secret');
        $clientId =env('PAYPAL_CLIENT_ID');
        $secret =env('PAYPAL_SECRET');

        // Retrieve amount, user ID, and email from the request
        $amount = $request->input('amount');
        $userId = $request->input('user_id');
        $email = $request->input('email');
        $course_id = $request->input('course_id');        
        try {
            $environment = new ProductionEnvironment($clientId, $secret);
            $client = new PayPalHttpClient($environment);

            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $amount // Amount to be paid
                    ]
                ]],
                "application_context" => [
                    "cancel_url" => route('paypal.cancel'),
                    "return_url" => route('paypal.confirm')
                ]
            ];

            $response = $client->execute($request);
            $orderId = $response->result->id;
            // dd($response);
            // Store payment details in the database
            payments::create([
                'user_id' => $userId,
                'amount' => $amount,
                'payment_method' => 'Paypal', // Assuming you want to track payment method
                'reference_no' => $orderId, // Store PayPal order ID for reference
                'payment_status'=>'Ordered',
                'course_id'=>$course_id
            ]);

            
            // Redirect user to PayPal payment page
            return redirect($response->result->links[1]->href); // Redirect to approval_url

        } catch (\Exception $e) {
            
            // Handle errors
            \Session::flash('flash_message', 'There was an error making payment.'.$e->getMessage());
            return back()->withError($e->getMessage())->withInput()->with(['flash_message'=>'Error making payment :'.$e->getMessage()]);
        }
    }

    public function confirmPaypalPayment(Request $request)
    {
        // Retrieve PayPal client ID and secret from configuration
        $clientId =env('PAYPAL_CLIENT_ID');
        $secret =env('PAYPAL_SECRET');
        try {
            $environment = new ProductionEnvironment($clientId, $secret);
            $client = new PayPalHttpClient($environment);

            $orderID = $request->input('orderID'); // Get the PayPal Order ID from the request

            $request = new OrdersCaptureRequest($orderID);
            $request->prefer('return=representation');

            $response = $client->execute($request);

            // Retrieve payment status, reference number, user ID, and amount from the PayPal response
            $status = $response->result->status;
            $referenceNumber = $response->result->id; // PayPal Order ID
            $userId = $request->input('user_id'); // Assuming user_id is passed as a parameter
            $email = $request->input('email'); // Assuming email is passed as a parameter
            $amount = $response->result->purchase_units[0]->amount->value; // Assuming only one purchase unit

            // Store payment details in the database
            $payment = payments::where('reference_no',$orderID)->first();
            $payment->payment_status = $status;
            $payment->save();
            // Return a response indicating the payment status
            // return response()->json(['status' => 'success', 'message' => 'Payment confirmed.', 'orderID' => $orderID]);
            \Session::flash('flash_message', 'Payment was successful.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            // Handle any errors
            // return response()->json(['error' => $e->getMessage()], 500);
            return redirect()->route('paypal.cancel');
        }
    }

    public function cancelPaypalPayment()
    {
        \Session::flash('flash_message', 'Payment was cancelled.');
        return redirect()->route('home');
    }

    public function savePayment(Request $request){

         // Validate the form data
         $validatedData = $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|string',
            'currency' => 'required|string',
            'user_id' => 'required|integer',
            'course_id' => 'required|integer',
            'payment_status' => 'required|string',
            'reference_no' => 'required|string',
            'created_at' => 'required|date',
        ]);

        // Create a new payment record
        payments::create($validatedData);

        \Session::flash('flash_message', 'Your payment data has been submitted to the Admin. You will be able to access the course contents after approval. Thank you.');
        return redirect()->route('home');

    }
}
