<?php
require_once("admin/includes/config.php");
require_once("admin/includes/functions.php");
if( isset($_GET["result"]) && !empty($_GET["result"]) ){
    var_dump($returnResponse = checkUpayment($_GET["track_id"]));;
    if( isset($_GET["track_id"]) && !empty($_GET["track_id"]) && $returnResponse = checkUpayment($_GET["track_id"]) ){
        if( $invoice = selectDBNew("invoices",[$_GET["requested_order_id"]],"`gatewayId` = ?","") ){
            updateDB("invoices",array("returnResponse"=>$returnResponse),"`id` = {$invoice[0]["id"]}");
            $returnResponse = json_decode($returnResponse,true);
            $status = ($returnResponse["data"]["transaction"]["result"] == "CAPTURED") ? 1 : 2 ;
            updateDB("invoices",array("status"=>$status),"`id` = {$invoice[0]["id"]}");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" >

<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    
    <title>BASIC JJ</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/245c9398b0.js"></script>
</head>

<body>

    <div class="row">
        <div class="col">
            BASIC JJ
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>