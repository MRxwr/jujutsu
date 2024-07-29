<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "Submit" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","");
        }
        
        if( isset($_POST["package"]) && !empty($_POST["package"]) ){
            $package = selectDBNew("package",[$_POST["package"]],"`id` = ?","");
            $price = ( $package[0]["discountType"] == 2 ? $package[0]["price"] - ($package[0]["price"] * $package[0]["discount"] / 100) : $package[0]["price"] - $package[0]["discount"]);
        }else{
            echo outputError(array("msg" => "Package Not Set"));die();
        }
        $data = array(
            "orderId" => getOrderId(),
            "price" => $price,
            "title" => $package[0]["enTitle"],
            "description" => $package[0]["enTitle"],
            "userId" => $user[0]["id"],
            "name" => $user[0]["fullName"],
            "email" => $user[0]["email"],
            "mobile" => $user[0]["phone"],
            "returnURL" => "{$settingsWebsite}/requests/payment.php",
            "cancelURL" => "{$settingsWebsite}/requests/payment.php",
        );
        $insertData = array(
            "gatewayId" => $data["orderId"],
            "userId" => $data["userId"],
            "packageId" => $package[0]["id"],
            "period" => $package[0]["period"],
            "price" => $package[0]["price"],
            "discount" => $package[0]["discount"],
            "discountType" => $package[0]["discountType"],
            "finalPrice" => $price,
            "gatewayPayload" => json_encode($data)
        );
        if( $pay = submitUpayment($data) ){
            $insertData["link"] = $pay["data"]["link"];
            if( insertDB("orders",$insertData) ){
                echo outputData($pay);die();
            }else{
                echo outputError(array("msg" => "Order Not Inserted"));die();
            }
        }else{
            echo outputError(array("msg" => "Payment Not Submitted"));die();
        }
    }elseif( $_GET["action"] == "List" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","") ){
                if( $orders = selectDB("orders","`userId` = '{$user[0]["id"]}' ORDER BY `id` DESC")){
                    $unsetList = ["hidden", "userId", "gatewayPayload", "gatewayResponse", "link"];
                    foreach ($orders as $key => $value) {
                        foreach ($unsetList as $key2 => $value2) {
                            unset($orders[$key][$value2]);
                        }
                    }
                    // for gatewayResponse and gatewayPayload json_decode
                    /*
                    foreach ($orders as $key => $value) {
                        $orders[$key]["gatewayResponse"] = json_decode($orders[$key]["gatewayResponse"],true);
                        $orders[$key]["gatewayPayload"] = json_decode($orders[$key]["gatewayPayload"],true);
                    }
                    */
                    // add package details
                    foreach ($orders as $key => $value) {
                        $orders[$key]["package"] = selectDB("package","`id` = '{$orders[$key]["packageId"]}'")[0];
                        //unset hidden, status, date and rank from package array
                        unset($orders[$key]["package"]["hidden"], $orders[$key]["package"]["status"], $orders[$key]["package"]["date"], $orders[$key]["package"]["rank"]);
                    }
                    echo outputData($orders);die();
                }else{
                    echo outputError(array("msg" => "Orders Not Found"));die();
                }
            }else{
                echo outputError(array("msg" => "Token Not Found"));die();
            }
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>