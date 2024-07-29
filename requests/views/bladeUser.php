<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "Login" ){
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
        if( !isset($_POST["email"]) || empty($_POST["email"]) ){
            echo outputError(array("msg" => "Email Required"));die();
        }else{
            if( $user = selectDBNew("users",[$_POST["email"]],"`email` LIKE ?","") ){
            }else{
                echo outputError(array("msg" => "Email Not Found"));die();
            }
        }
        if( !isset($_POST["password"]) || empty($_POST["password"]) ){
            echo outputError(array("msg" => "Password Required"));die();
        }
        if( $user = selectDBNew("users",[$_POST["email"],sha1($_POST["password"])],"`email` LIKE ? AND `password` LIKE ?","") ){
            if( $user[0]["hidden"] == 2 ){
                echo outputError(array("msg" => "Account Suspended, Please Contact Administrator"));die();
            }
            if( $user[0]["status"] == 1 ){
                echo outputError(array("msg" => "Email Not Found"));die();
            }
            $token = password_hash(generateRandomString(), PASSWORD_BCRYPT);
            updateDB("users",array("keepMeAlive"=>$token),"`id` = '{$user[0]["id"]}'","");
            echo outputData(array("token" => $token));die();
        }else{
            echo outputError(array("msg" => "Wrong Password"));die();
        }
    }elseif( $_GET["action"] == "Forget" ){
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
        if( !isset($_POST["email"]) || empty($_POST["email"]) ){
            echo outputError(array("msg" => "Email Required"));die();
        }else{
            if( $user = selectDBNew("users",[$_POST["email"]],"`email` LIKE ?","") ){
                $newPass = generateRandomString();
                updateDB("users",array("password"=>sha1($newPass)),"`id` = '{$user[0]["id"]}'","");
                $data = array(
                    "email" => $user[0]["email"],
                    "password" => $newPass
                );
                forgetPass($data);
                echo outputData(array("msg" => "Password Sent To Your Email"));die();
            }else{
                echo outputError(array("msg" => "Email Not Found"));die();
            }
        }
    }elseif( $_GET["action"] == "Profile" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","") ){
                $unsetList = ["password","date","keepMeAlive","status","hidden","id"];
                foreach ($unsetList as $key => $value) {
                    unset($user[0][$value]);
                }
                echo outputData($user[0]);die();
            }else{
                echo outputError(array("msg" => "Token Not Found"));die();
            }
        }
    }elseif( $_GET["action"] == "EditProfile" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
                $_POST["logo"] = uploadImageBanner($_FILES['logo']['tmp_name']);
            }else{
                unset($_POST["logo"]);
            }
            if (is_uploaded_file($_FILES['bgImage']['tmp_name'])) {
                $_POST["bgImage"] = uploadImageBanner($_FILES['bgImage']['tmp_name']);
            }else{
                unset($_POST["bgImage"]);
            }
            if( updateDB("users",$_POST,"`keepMeAlive` LIKE '{$token}'") ){
                $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","");
                $unsetList = ["password","date","keepMeAlive","status","hidden","id"];
                foreach ($unsetList as $key => $value) {
                    unset($user[0][$value]);
                }
                echo outputData($user[0]);die();
            }else{
                echo outputError(array("msg" => "Failed To Update Profile"));die();
            }
        }
    }elseif( $_GET["action"] == "Logout" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            updateDB("users",array("keepMeAlive"=>0),"`keepMeAlive` = '{$token}'","");
            echo outputData(array("msg" => "Logged Out Successfully"));die();
        }
    }elseif( $_GET["action"] == "Delete" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","");
            $updateData = array(
                "keepMeAlive" => 0,
                "hidden"=> 2,
                "email" => "Deleted-{$user[0]["email"]}",
            );
            updateDB("users",$updateData,"`keepMeAlive` = '{$token}'","");
            echo outputData(array("msg" => "Account Deleted Successfully"));die();
        }
    }elseif( $_GET["action"] == "ChangePassword"){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( !isset($_POST["password"]) || empty($_POST["password"]) ){
                echo outputError(array("msg" => "Password Required"));die();
            }else{
                updateDB("users",array("password"=>sha1($_POST["password"])),"`keepMeAlive` = '{$token}'","");
                echo outputData(array("msg" => "Password Changed Successfully"));die();
            }
        }
    }elseif( $_GET["action"] == "Register" ){
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
        if( !isset($_POST["email"]) || empty($_POST["email"]) ){
            echo outputError(array("msg" => "Email Required"));die();
        }else{
            if( $user = selectDBNew("users",[$_POST["email"]],"`email` LIKE ?","") ){
                echo outputError(array("msg" => "Email Already Exist"));die();
            }
        }
        if( !isset($_POST["password"]) || empty($_POST["password"]) ){
            echo outputError(array("msg" => "Password Required"));die();
        }
        if( !isset($_POST["fullName"]) || empty($_POST["fullName"]) ){
            echo outputError(array("msg" => "Page name Required"));die();
        }
        if( !isset($_POST["phone"]) || empty($_POST["phone"]) ){
            echo outputError(array("msg" => "Phone number Required"));die();
        }
        if( !isset($_POST["url"]) || empty($_POST["url"]) ){
            echo outputError(array("msg" => "Page URL Required"));die();
        }elseif( $url = selectDBNew("users",[$_POST["url"]],"`url` LIKE ?","") ){
            echo outputError(array("msg" => "Page URL Already Exist"));die();
        }
        $_POST["status"] = 1;
        if( insertDB("users",$_POST) ){
            $user = selectDBNew("users",[$_POST["email"]],"`email` LIKE ?","");
            $token = password_hash(generateRandomString(), PASSWORD_BCRYPT);
            updateDB("users",array("keepMeAlive"=>$token),"`id` = '{$user[0]["id"]}'","");
            echo outputData(array("msg" => "Registered Successfully","token" => $token));die();
        }else{
            echo outputError(array("msg" => "Failed To Register"));die();
        }
    }else{
        echo outputError(array("msg" => "Action Not Found"));die();
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>