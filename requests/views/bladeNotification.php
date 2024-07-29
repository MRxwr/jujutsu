<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "List" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","") ){
                if( $notification = selectDB2("`id`, `date`, `enTitle`, `enNotification`, `arTitle`, `arNotification`, `image`","notification","`userId` = '{$user[0]["id"]}' OR `userId` = '0' AND `status` = '0' AND `hidden` = '1' ORDER BY `id` DESC")){

                }else{
                    $notification = [];
                }
                echo outputData($notification);die();
            }else{
                echo outputError(array("msg" => "Token Not Found"));die();
            }
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>