<?php

namespace App\Http\Controllers\Front;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payment.create',
            [
                'order' => $order
            ]
        );
    }

    public function createStripePaymentIntent(Order $order)
    {

        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

        // Create a PaymentIntent with amount and currency
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => ceil($order->total),
            'currency' => session('currency_code', config('app.currency')),
            'payment_method_types' => ['card'],
        ]);

//        dd($paymentIntent);

        // TODO:: See Webhook to solve duplicate entry if refresh

        Payment::create([
            'order_id' => $order->id,
            'amount' => $paymentIntent->amount,
            'amount_received' => $paymentIntent->amount_received,
            'service_used' => 'stripe',
            'currency' => session('currency_code', config('app.currency')),
            'status' => PaymentStatus::PENDING,
            'transaction_id' => $paymentIntent->id,
            'transaction_data' => $paymentIntent
        ]);

        return ['clientSecret' => $paymentIntent->client_secret];
    }

    public function completePayment(Request $request, Order $order)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));

            $paymentIntent = $stripe->paymentIntents->retrieve($request->query('payment_intent'), []);
            DB::beginTransaction();
            if ($paymentIntent->status === 'succeeded') {
                $paymentMethod = $stripe->paymentMethods->retrieve($paymentIntent->payment_method);

                Payment::where('transaction_id', $paymentIntent->id)->update([
                    'amount_received' => $paymentIntent->amount_received,
                    'status' => PaymentStatus::COMPLETED,
                    'method_type' => $paymentMethod->card->brand,
                    'transaction_data' => json_encode($paymentIntent),
                ]);
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return to_route('home')->with('payment_success', 'Error Happened');
        }
        return to_route('home')->with('payment_success', 'Payment Happened');
    }
}
