<?php

class OrdersModel {
    
    static function getOrderTypes () {
        return Database::queryAsArray("select DISTINCT orderform as ordertype from t_order");
    }
    
    static function getOrder ($orderId) {
        if (Context::isLoggedIn()) {
            $orderId = Database::escape($orderId);
            return Database::queryAsObject("select o.*
                    from t_order o
                    where o.id = '$orderId'");
        } else {
            $order;
            if (isset($_SESSION["orders.tmp"]) && isset($_SESSION["orders.tmp"][$orderId])) {
                $tmpOrder = $_SESSION["orders.tmp"][$orderId];
                // for temp orders order id is the order form id
                $order->orderid = $tmpOrder->orderForm;
                $order->orderform = $tmpOrder->orderForm;
                $order->roleid = $tmpOrder->roleId;
                $order->status = 0;
                $order->distributorid = $tmpOrder->distributorId;
            }
            return $order;
        }
    }
    
    static function getOrdersByUser ($userId, $orderForm = null) {
        if ($userId == null) {
            // name result set from session
            $orders = array();
            if (isset($_SESSION["orders.tmp"])) {
                foreach ($_SESSION["orders.tmp"] as $tmpOrder) {
                    foreach ($tmpOrder->products as $productId => $product) {
                        $order;
                        // for temp orders order id is the order form id
                        $order->id = $productId;
                        $order->orderid = $tmpOrder->orderForm;
                        $order->orderform = $tmpOrder->orderForm;
                        $order->roleid = $tmpOrder->roleId;
                        $order->orderstatus = 0;
                        $order->distributorid = $tmpOrder->distributorId;
                        $order->productid = $productId;
                        $order->quantity = $product->quantity;
                        $order->shipping = $product->shipping;
                        $order->price = $product->price;
                        $order->status = 0;
                        $order->img = $product->img;
                        $orders[Database::escape($productId)] = $order;
                        unset($order);
                    }
                }
                // get translations for product names
                $productIds = implode("','", array_keys($orders));
                $query = "
                    select c.value as titel, p.id as id from t_product p
                    join t_code c on c.code = p.titelcode
                    where p.id in ('$productIds')";
                $productNames = Database::queryAsArray($query);
                foreach ($productNames as $productName) {
                    $orders[$productName->id]->titel = $productName->titel;
                }
            }
            return $orders;
        }
        self::createOrdersFromSession();
        $userId = Database::escape($userId);
        $query = "
                select p.img, p.price, p.shipping, op.*, c.value as titel, o.orderform, o.status as orderstatus, o.objectid, o.id as orderid, o.roleid, o.distributorid
                from t_order_product op
                left join t_order o on op.orderid = o.id
                left join t_product p on p.id = op.productid
                join t_code c on c.code = p.titelcode
                where o.userid = '$userId'";
        if ($orderForm != null) {
            $orderForm = Database::escape($orderForm);
            $query .= " and orderform = '$orderForm' ";
        }
        return Database::queryAsArray($query);
    }
    
    static function getOrdersByDistributor ($userId,$tableId=null) {
        $userId = Database::escape($userId);
        $query = "select op.*, c.value as titel, o.orderform, o.objectid, o.roleid, o.distributorid
            from t_order_product op 
            left join t_order o on op.orderid = o.id
            left join t_product p on p.id = op.productid
            join t_code c on c.code = p.titelcode
            where o.distributorid = '$userId'";
        if ($tableId != null) {
            $tableId = Database::escape($tableId);
            $query .= " and orderform = '$tableId'"; 
        }
        return Database::queryAsArray($query);
    }
    
    static function getOrdersByStatus ($status,$orderForm=null,$userId=null) {
        $status = Database::escape($status);
        $query = "select * 
                  from t_order o 
                  where o.status = '$status' ";
        if ($orderForm != null) {
            $orderForm = Database::escape($orderForm);
            $query .= "and orderform = '$orderForm' ";
        }
        if ($userId != null) { 
            $userId = Database::escape($userId);
            $query .= "and userid = '$userId' ";
        }
        return Database::queryAsArray($query);
    }
    
    static function setOrderStatus ($orderId, $status) {
        $orderId = Database::escape($orderId);
        $status = Database::escape($status);
        Database::query("update t_order set status = '$status' where id = '$orderId'");
    }
    
    static function setOrderProductStatus ($productId, $status) {
        $productId = Database::escape($productId);
        $status = Database::escape($status);
        Database::query("update t_order_product set status = '$status' where id = '$productId'");
    }
    
    static function getOrderAttribs ($orderForm,$userId,$roleId=null,$distributorId=null) {
        $orderForm = Database::escape($orderForm);
        $userId = Database::escape($userId);
        $query = "select * from t_order where orderform = '$orderForm' and userid = '$userId' and status = '0' ";
        if ($roleId != null) {
            $roleId = Database::escape($roleId);
            $query .= " and roleid = '$roleId'";
        }
        if ($distributorId != null) {
            $distributorId = Database::escape($distributorId);
            $query .= " and distributorid = '$distributorId'";
        }
        return Database::queryAsObject($query);
    }

    static function createOrdersFromSession () {
        if (Context::isLoggedIn() && isset($_SESSION["orders.tmp"]) && is_array($_SESSION["orders.tmp"])) {
            foreach ($_SESSION["orders.tmp"] as $orderId => $order) {
                self::createOrder(Context::getUserId(), $order->products, $order->orderForm, $order->roleId, $order->distributorId);
            }
            unset($_SESSION["orders.tmp"]);
        }
    }

    static function getOrderProducts ($orderId) {
        if (Context::isLoggedIn()) {
            //
            self::createOrdersFromSession();
            $orderId = Database::escape($orderId);
            return Database::queryAsArray("
                    select op.*, c.value as titel, p.price
                    from t_order_product op
                    join t_product p on p.id = op.productid
                    join t_code c on c.code = p.titelcode
                    where op.orderid = '$orderId'");
        } else {
            // result set from session
            $orders = array();
            if (isset($_SESSION["orders.tmp"])) {
                $tmpOrder = $_SESSION["orders.tmp"][$orderId];
                foreach ($tmpOrder->products as $productId => $quantity) {
                    $order;
                    // for temp orders order id is the order form id
                    $order->orderid = $tmpOrder->orderForm;
                    $order->orderform = $tmpOrder->orderForm;
                    $order->roleid = $tmpOrder->roleId;
                    $order->orderstatus = 0;
                    $order->distributorid = $tmpOrder->distributorId;
                    $order->productid = $productId;
                    $order->quantity = $quantity->quantity;
                    $order->status = 0;
                    $orders[Database::escape($productId)] = $order;
                    unset($order);
                }
                // get translations for product names
                $productIds = implode("','", array_keys($orders));
                $query = "
                    select c.value as titel, p.id as id from t_product p
                    join t_code c on c.code = p.titelcode
                    where p.id in ('$productIds')";
                $productNames = Database::queryAsArray($query);
                foreach ($productNames as $productName) {
                    $orders[$productName->id]->titel = $productName->titel;
                }
            }
            return $orders;
        }
    }

    static function updateOrder () {
        
    }
    
    static function setObjectId ($orderId,$objectId) {
        $orderId = Database::escape($orderId);
        $objectId = Database::escape($objectId);
        Database::query("
                update t_order set
                objectid = '$objectId' 
                where id = '$orderId'");
    }

    /**
     * save order to database, if user is not logged in save order in session
     *
     * @param <type> $userId
     * @param <type> $productIdsQuantity
     * @param <type> $orderForm
     * @param <type> $roleId
     * @param <type> $distributorId
     * @return <type>
     */
    static function createOrder ($userId,$productIdsQuantity,$orderForm,$roleId,$distributorId=null) {

        $orderId = null;

        if ($userId == null) {
            $orders = isset($_SESSION["orders.tmp"]) && is_array($_SESSION["orders.tmp"]) ? $_SESSION["orders.tmp"] : array();
            if (isset($orders[$orderForm])) {
                foreach ($productIdsQuantity as $id => $value) {
                    if (isset($orders[$orderForm]->products[$id])) {
                        $orders[$orderForm]->products[$id]->quantity += $value->quantity;
                    } else {
                        $orders[$orderForm]->products[$id]->quantity = $value->quantity;
                    }
                }
            } else {
                $order;
                $order->products = $productIdsQuantity;
                $order->orderForm = $orderForm;
                $order->roleId = $roleId;
                $order->distributorId = $distributorId;
                $orders[$orderForm] = $order;
            }
            $_SESSION["orders.tmp"] = $orders;
            
        } else {

            $userId = Database::escape($userId);
            // $orderFormObj = VirtualDataModel::getTable($orderForm);
            // $orderFormId = $orderFormObj->id;
            $orderFormId = $orderForm;
            // echo "$userId - orderForm $orderForm - formId $orderFormId";
            // create order
            $orderObj = OrdersModel::getOrderAttribs($orderFormId,$userId,$roleId,$distributorId);
            $objectId;

            if ($orderObj != null && $orderObj->status == "0") {
                // if the user is adding prodducts to a current order
                $objectId = $orderObj->objectid;
                $orderId = $orderObj->id;
            } else {
                // create new order

                // $objectId = DynamicDataView::createObject($orderForm);
                $roleId = Database::escape($roleId);
                $distributor = "null";
                if ($distributorId != null) {
                    $distributor = "'".Database::escape($distributorId)."'";
                }

                Database::query("insert into t_order (userid,orderdate,orderform,roleid,distributorid) values('$userId',now(),'$orderFormId','$roleId',$distributor)");
                // add order products
                $obj = Database::queryAsObject("select max(id) as orderid from t_order");
                $orderId = $obj->orderid;
            }
            // add products to order
            foreach ($productIdsQuantity as $productId => $quantity) {
                OrdersModel::addProductToOrder($productId,$quantity->quantity,$orderId);
            }
        }
        return $orderId;
    }
    
    static function addProductToOrder ($productId,$quantity,$orderId) {
        if (Context::isLoggedIn()) {
            $productId = Database::escape($productId);
            $quantity = Database::escape($quantity);
            $orderId = Database::escape($orderId);
            Database::query("insert into t_order_product (productid,orderid,quantity) values('$productId','$orderId','$quantity')");
            $productId = Database::queryAsObject("select max(id) as newid from t_order_product");
            return $productId->newid;
        } else {
            $_SESSION["orders.tmp"][$orderId]->products[$productId]->quantity = $quantity;
        }
    }
    
    static function updateQuantitys ($orderId,$quantitys) {
        if (Context::isLoggedIn()) {
            // update quantities in database if logged in
            $orderId = Database::escape($orderId);
            foreach ($quantitys as $key => $value) {
                $key = Database::escape($key);
                $value = Database::escape($value);
                Database::query("update t_order_product set
                        quantity = '$value'
                        where productid = '$key' and orderid = '$orderId'");
            }
        } else {
            // update quantities in session if not logged in
            if (isset($_SESSION["orders.tmp"])) {
                foreach ($quantitys as $key => $value) {
                    if (isset($_SESSION["orders.tmp"][$orderId]->products[$key])) {
                        $_SESSION["orders.tmp"][$orderId]->products[$key]->quantity = $value;
                    }
                }
            }
        }
    }
    
    static function deleteOrder ($orderId) {
        if (Context::isLoggedIn()) {
            $orderId = Database::escape($orderId);
            Database::query("delete from t_order_product where orderid = '$orderId'");
            Database::query("delete from t_order where id = '$orderId'");
        } else {
            if (isset($_SESSION["orders.tmp"]) && isset($_SESSION["orders.tmp"])) {
                unset($_SESSION["orders.tmp"]);
            }
        }
    }
    
    static function addOrderProduct ($orderId,$productId,$quantity) {
        if (Context::isLoggedIn()) {
            $orderId = Database::escape($orderId);
            $productId = Database::escape($productId);
            $quantity = Database::escape($productId);
            Database::query("insert into t_order_product orderid = '$orderId', productid = '$productId', quantity = '$quantity'");
        } else {
            $_SESSION["orders.tmp"][$orderId]->products[$productId]->quantity = $quantity;
        }
    }
    
    static function deleteOrderProduct ($orderId,$productId) {
        if (Context::isLoggedIn()) {
            $orderId = Database::escape($orderId);
            $productId = Database::escape($productId);
            Database::query("delete from t_order_product where orderid = '$orderId' and productid = '$productId'");
        } else {
            // update quantities in session if not logged in
            if (isset($_SESSION["orders.tmp"]) && isset($_SESSION["orders.tmp"][$orderId])) {
                unset($_SESSION["orders.tmp"][$orderId]->products[$productId]);
                if (count($_SESSION["orders.tmp"][$orderId]->products) == 0) {
                    unset($_SESSION["orders.tmp"][$orderId]);
                }
            }
        }
    }

    /**
     * order attributes
     */

    static function addOrderAttribute ($name,$value,$orderId) {
        $name = Database::escape($name);
        $value = Database::escape($value);
        $orderId = Database::escape($orderId);
        Database::query("insert into t_order_attribute (name,value,orderid) values ('$name','$value','$orderId')");
    }

    static function removeOrderAttribute ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_order_attribute where id = '$id'");
    }

    static function getOrderAttributes ($orderId) {
        $orderId = Database::escape($orderId);
        return Database::queryAsArray("select * from t_order_attribute where orderid = '$orderId' order by id asc", "id");
    }


}

?>
