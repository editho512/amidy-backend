<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

class PaymentService
{
    protected $paymentMethod;

    public function __construct(int $type)
    {
        if($type === 1) $this->paymentMethod = new StripePaymentService();

        $this->paymentMethod->Initialize();

    }


    public function SetCharge($charge){
        $this->paymentMethod->SetCharge($charge);
    }

    public function setCustomer($customer){
        $this->paymentMethod->setCustomer($customer);
    }

    public function pay(){
        return $this->paymentMethod->pay();
    }

}
