<?php 
require_once("admin/includes/config.php");
require_once("admin/includes/functions.php");
require_once("template/header.php");

if( isset($_GET["result"]) && !empty($_GET["result"]) ){
    if( $invoice = selectDBNew("invoices",[$_GET["requested_order_id"]],"`gatewayId` = ?","") ){
        if( $invoice[0]["status"] == 0 ){
            if(  $_GET["result"] == "CAPTURED" ){
                $status = 1;
            }else{
                $status = 2;
            }
            updateDB("invoices",array("status"=>$status,"returnResponse"=>json_encode($_GET)),"`id` = {$invoice[0]["id"]}");
            header("LOCATION: ?v=Invoice?id={$_GET["requested_order_id"]}");die();
        }
    }
}

// get viewed page from pages folder \\
if( isset($_GET["v"]) && searchFile("views","blade{$_GET["v"]}.php") ){
	require_once("views/".searchFile("views","blade{$_GET["v"]}.php"));
}else{
	$_GET["v"] = "Home";
	require_once("views/bladeHome.php");
}

require("template/footer.php");
?>