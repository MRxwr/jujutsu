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
        if( $packages = selectDBNew("package",[1,0],"`hidden` = ? AND `status` = ? ","`rank` ASC") ){
            $unsetList = ["status","date","hidden"];
            foreach ($packages as $key => $value) {
                foreach ($unsetList as $key2 => $value2) {
                    unset($packages[$key][$value2]);
                }
            }
            echo outputData($packages);die();
        }else{
            echo outputError(array("msg"=>"No packages found"));die();
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>