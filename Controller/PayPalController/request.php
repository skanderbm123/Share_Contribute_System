<?php

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    require 'bootstrap.php';
    
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include '.\\PayPal.php';
    $eventID = $_POST['eventID'];
    if (empty($eventID)) {
        throw new Exception('This script should not be called directly, expected post data');
    }

    $paypal = new PayPal();

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');
    
    // Set some example data for the payment.
    $currency = 'CAD';
    $amountPayable = $paypal->getEventFee($eventID);
    $eventInfo = $paypal->getEventInfo($eventID);

    if($eventInfo[0])
        $eventInfo = $eventInfo[0];
    
    $invoiceNumber = uniqid();
    $amount = new Amount();
    $amount->setCurrency($currency)
        ->setTotal($amountPayable);
    $transaction = new Transaction();
    $transaction->setAmount($amount)
        ->setDescription($eventInfo["name"])
        ->setInvoiceNumber($invoiceNumber);
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl($paypalConfig['return_url'])
        ->setCancelUrl($paypalConfig['cancel_url']);
    $payment = new Payment();
    $payment->setIntent('sale')
        ->setPayer($payer)
        ->setTransactions([$transaction])
        ->setRedirectUrls($redirectUrls);
    try {
        $payment->create($apiContext);
    } catch (Exception $e) {
        throw new Exception('Unable to create link for payment');
    }
    $link = $payment->getApprovalLink();
    $_SESSION['eventID'] = $eventID;
    header("Location: ${link}");
    exit(1);
} else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    header('Location: ' . '..\..\index.php');
}
?>