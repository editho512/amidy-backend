<?php

namespace App\Services;


use Stripe\Token;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Error\Card;
use App\Interfaces\PaymentInterface;
use Illuminate\Database\Eloquent\Model;

class StripePaymentService implements PaymentInterface
{
    private $key;
    private $charge = [];
    private $customer = [];

    public function Initialize()
    {
        $this->key = env('STRIPE_SECRET');
        //  // This is your test secret API key.
        //  Stripe::setApiKey(env('STRIPE_SECRET'));

        //  $token = Token::create(array(
        //      "card" => array(
        //          "number" => "4242424242424242",
        //          "exp_month" => 12,
        //          "exp_year" => 2023,
        //          "cvc" => "123"
        //      )
        //  ));
        //  $payed = Charge::create([
        //      "amount" => 100 * 100,
        //      "currency" => "usd",
        //      "source" => $token->id,
        //      "description" => "Test payment from LaravelTus.com."
        //  ]);



        //dd("strip payment");
    }

    public function SetCharge($charge)
    {
        $this->charge = $charge;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    public function pay()
    {
        // This is your test secret API key.
        Stripe::setApiKey($this->key);

        try {

            $token = Token::create($this->customer);
            $payed = Charge::create(
              $this->charge +
              [ "source" => $token->id ]
            );

            return $payed;

        } catch (Card $e) {
            // handle error
            dd("error visa card");
        }

    }
}
