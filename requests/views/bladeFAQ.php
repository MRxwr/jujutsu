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
        if( $FAQ = selectDBNew("faq",[0,1],"`status` = ? AND `hidden` = ?","`rank` ASC") ){
            $unsetList = ["status","date","hidden","rank"];
            foreach ($FAQ as $key => $value) {
                foreach ($unsetList as $key2 => $value2) {
                    unset($FAQ[$key][$value2]);
                }
            }
            echo outputData($FAQ);die();
        }else{
            echo outputError(array("msg"=>"No social media found"));die();
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>