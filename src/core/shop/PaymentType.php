<?php

class PaymentTransaction {

    private $sum;
    private $state;

    const state_open = 1;
    const state_invalid = 2;
    const state_finnished = 3;
    const state_unseccessfull = 4;
    const state_pending = 5;

    function init ($sum) {
        $this->sum = $sum;
        $this->state = self::open;
    }
}

interface PaymentMethod {

    // displays the payment method
    function display ($transaction);

    // validate the input
    function validateInput ($transaction);

    // validates that the payment was successfull or valid
    function validateTransaction ($transaction) ;
}

class PaymentTypePaypall implements PaymentType {

    function display ($transaction) {
        ?>
        <div class="panel">
            When you click the button bellow you will be redirected to paypall
            where you can the login and perform the transaction.
            <button>Continue to paypall</button>
        </div>
        <?php
    }

    function validateInput ($transaction) {
        return true;
    }

    function validateTransaction ($transaction) {

    }
}




?>