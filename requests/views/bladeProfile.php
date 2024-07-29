<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "List" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","") ){
                if( $profiles = selectDB("profiles","`userId` = '{$user[0]["id"]}' AND `status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){

                }else{
                    $profiles = [];
                }
                echo outputData($profiles);die();
            }else{
                echo outputError(array("msg" => "Token Not Found"));die();
            }
        }
    }elseif( $_GET["action"] == "Add" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","");
            $_POST["userId"] = $user[0]["id"];
            if( insertDB("profiles",$_POST) ){
                echo outputData(array("msg" => "Profile Added Successfully"));die();
            }else{
                echo outputError(array("msg" => "Failed To Add Profile"));die();
            }
        }
    }elseif( $_GET["action"] == "Edit" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( !isset($_POST["id"]) || empty($_POST["id"]) ){
                echo outputError(array("msg" => "Profile Id Required"));die();
            }
            $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","");
            $_POST["userId"] = $user[0]["id"];
            if( updateDB("profiles",$_POST,"`id` = '{$_POST["id"]}'") ){
                echo outputData(array("msg" => "Profile Updated Successfully"));die();
            }else{
                echo outputError(array("msg" => "Failed To Update Profile"));die();
            }
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>