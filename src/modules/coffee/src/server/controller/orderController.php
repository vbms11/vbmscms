<?php

class OrderController {
    
    function confirm ($publicId) {
        Email::sendPrepairedMail("customer.order.confirm");
        $supplyer = DB::get("");
        Email::sendPrepairedMail("supplyer.order.confirm");
        
    }
    
    function decline ($publicId) {
        $publicId = DB::get("order",array());
        Email::sendPrepairedMail("customer.order.decline");
        
    }
}

?>