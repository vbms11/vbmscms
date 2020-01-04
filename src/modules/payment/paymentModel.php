<?php

class PaymentModel {
    
    static function getPaymentOffers () {
        return Database::queryAsArray("select * from t_payment_offer");
    }
    
    static function insertOffer ($name, $description, $amount, $frequency) {
        $name = Database::escape($name);
        $description = Database::escape($description);
        $amount = Database::escape($amount);
        $frequency = Database::escape($frequency);
        return Database::queryAsArray("insert into t_payment_offer (name,description,amount,frequency) values ('$name','$description','$amount','$frequency')");
    }
    
    static function updatePaymentOffer ($id, $name, $description, $amount, $frequency) {
        $id = Database::escape($id);
        $name = Database::escape($name);
        $description = Database::escape($description);
        $amount = Database::escape($amount);
        $frequency = Database::escape($frequency);
        Database::query("update t_payment_offer set name = '$name', description = '$description', amount = '$amount', frequency = '$frequency' where id = '$id'");
    }
    
    static function deletePaymentOffer ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_payment_offer where id = '$id'");
    }
    
    
    // payment offer
    // payment role
    
    static function getPaymentRoleByPaymentOfferId ($paymentOfferId) {
        $paymentOfferId = Database::escape($paymentOfferId);
        return Database::queryAsArray("select * from t_payment_role where paymentofferid = '$paymentOfferId'");
    }
    
    static function setPaymentOfferPaymentRoles ($paymentOfferId, $roleIds) {
        $paymentOfferId = Database::escape($paymentOfferId);
        Database::query("delete from t_payment_role where paymentofferid = '$paymentOfferId'");
        foreach ($roleIds as $roleId) {
            $roleId = Database::escape($roleId);
            Database::queryAsArray("insert into t_payment_offer (paymentofferid,customroleid) values ('$paymentOfferId','$roleId')");
        }
    }
    
    // payment transfer
    static function getPaymentTransfers () {
        
    }
     
}