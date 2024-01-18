<?php

namespace App\Http\Controllers\Front;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeWebhookController extends Controller
{
    public function webhook(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        }

//        Log::info('Evenet' , [$event->data->object->id]);

        try {
            $paymentIntent = $event->data->object;

            switch ($event->type) {

                case 'payment_intent.created':

                    Payment::where('transaction_id', $paymentIntent->id)
                        ->update([
                            'status' => PaymentStatus::PENDING,
                        ]);

                    break;

                case 'payment_intent.succeeded':

                    Payment::where('transaction_id', $paymentIntent->id)
                        ->update([
                            'status' => PaymentStatus::COMPLETED,
                        ]);
                    break;

                case 'payment_intent.canceled':
                    Payment::where('transaction_id', $paymentIntent->id)
                        ->update([
                            'status' => PaymentStatus::CANCELLED,
                        ]);
                    break;

                // ... handle other event types
                default:
                    Payment::where('transaction_id', $paymentIntent->id)
                        ->update([
                            'status' => PaymentStatus::FAILED
                        ]);
            }
        }catch (\Exception $exception){
            http_response_code(400);
            exit();
        }
    }
}
