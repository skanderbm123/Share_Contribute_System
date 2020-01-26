<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '..\..\Controller\PayPalController\bootstrap.php';
include '..\..\Controller\PayPalController\PayPal.php';

if (empty($_GET['paymentId']) || empty($_GET['PayerID']) || empty($_SESSION['usernameId'])) {
    header('location:payment-cancelled.php');
}
$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $apiContext);
$execution = new PaymentExecution();
$execution->setPayerId($_GET['PayerID']);
try {
    // Take the payment
    $payment->execute($execution, $apiContext);
    try {
        $paypal = new PayPal();
        $payment = Payment::get($paymentId, $apiContext);
        $response = $paypal->insertPaidEvent($_SESSION['usernameId'], $_SESSION['eventID'], $payment->transactions[0]->amount->total, $payment->getId(), 
            $payment->getState(), $payment->transactions[0]->invoice_number);
        if ($response && $payment->getState() === 'approved') {
            // Payment successfully added, redirect to the payment complete page.
            header('location:payment-successful.php');
            exit(1);
        } else {
            header('location:payment-cancelled.php');
        }
    } catch (Exception $e) {
        echo "Failed to retrieve payment from paypal";
        // Failed to retrieve payment from PayPal
    }
} catch (Exception $e) {
    // Failed to take payment
    echo "Failed to take payment from paypal";
}