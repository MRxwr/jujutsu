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
        if( $socialMedia = selectDBNew("socialMedia",[0],"`status` LIKE ?","`title` ASC") ){
            $unsetList = ["status","date","hidden","rank","link"];
            foreach ($socialMedia as $key => $value) {
                foreach ($unsetList as $key2 => $value2) {
                    unset($socialMedia[$key][$value2]);
                }
            }
            echo outputData($socialMedia);die();
        }else{
            echo outputError(array("msg"=>"No social media found"));die();
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>