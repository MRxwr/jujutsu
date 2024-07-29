<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "List" ){
        if ( isset(getallheaders()["createidheader"]) ){
            $headerAPI =  getallheaders()["createidheader"];
        }else{
            $error = array("msg"=>"Please set headres");
            echo outputError($error);die();
        }
        if ( $headerAPI != "createIdCreate" ){
            $error = array("msg"=>"headers value is wrong");
            echo outputError($error);die();
        }
        if( $settigns = selectDB2("`title`, `logo`, `enPolicy`, `arPolicy`, `enTerms`, `arTerms`, `version`","settings","`id` = '1'") ){
            echo outputData($settigns);die();
        }else{
            echo outputError(array("msg"=>"No Settings found"));die();
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>