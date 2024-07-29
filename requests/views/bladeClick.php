<?php
if( isset($_COOKIE["CID"]) && !empty($_COOKIE["CID"]) && $_COOKIE["CID"] == $_POST["CSCRT"] ){
    $profile = selectDBNew("profiles",[$_POST["profileId"]],"`id` = ?","");
    $socialMedia = selectDB("socialMedia","`id` = '{$profile[0]["smId"]}'");
    $url = ( isset($profile[0]["link"]) && !empty($profile[0]["link"]) ) ? $profile[0]["link"] : "{$socialMedia[0]["link"]}{$profile[0]["account"]}" ;
    $link = str_replace(" ","",$url);
    if ( $click = selectDBNew("clicks",[$_POST["profileId"],$_POST["CSCRT"]],"`profileId` = ? AND `secret` = ?","") ){
        echo $link;die();
    }else{
        $account = selectDBNew("users",[$_POST["account"]],"`url` LIKE ?","");
        $dataInsert = array(
            "profileId" => $_POST["profileId"],
            "userId" => $account[0]["id"],
            "referer" => $_POST["referrer"],
            "remoteAddress" => $_SERVER["REMOTE_ADDR"],
            "userAgent" => $_SERVER["HTTP_USER_AGENT"],
            "secret" => $_POST["CSCRT"]
        );
        if ( insertDB("clicks",$dataInsert) ){
            echo $link;die();
        }
    }
}else{
    $profile = selectDBNew("profiles",[$_POST["profileId"]],"`id` = ?","");
    $socialMedia = selectDB("socialMedia","`id` = '{$profile[0]["smId"]}'");
    $url = ( isset($profile[0]["link"]) && !empty($profile[0]["link"]) ) ? $profile[0]["link"] : "{$socialMedia[0]["link"]}{$profile[0]["account"]}" ;
    $link = str_replace(" ","",$url);
    echo $link;die();
}
?>