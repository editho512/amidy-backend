<?php

Namespace App\Interfaces;

Interface PaymentInterface {
    public function Initialize();

    public function SetCharge($charge);

    public function setCustomer($customer);

    public function pay();
}
