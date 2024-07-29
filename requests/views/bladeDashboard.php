<?php
if( isset($_GET["action"]) && !empty($_GET["action"]) ){
    if( $_GET["action"] == "List" ){
        $token = checkAuth();
        if( empty($token) ){
            echo outputError(array("msg" => "Token Required"));die();
        }else{
            if( $user = selectDBNew("users",[$token],"`keepMeAlive` LIKE ?","") ){
                if( $profiles = selectDB2("`id`, `smId`","profiles","`userId` = '{$user[0]["id"]}' AND `status` = '0' AND `hidden` = '1' ORDER BY `rank` ASC")){
                    for( $i = 0; $i < sizeof($profiles); $i++ ){
                        $socialMedia = selectDB2("`title`, `icon`","socialMedia","`id` = '{$profiles[$i]["smId"]}'");
                        $response["profiles"][$i]["socialMedia"] = $socialMedia[0];
                        // Get clicks per day
                        if( $clicksPerDay = selectDB("clicks", "DATE(`date`) = CURDATE() AND `profileId` = '{$profiles[$i]["id"]}' AND `userId` = '{$user[0]["id"]}'") ){
                            $clicksPerDayCount = count($clicksPerDay);
                            $response["profiles"][$i]["clicksPerDay"] = $clicksPerDayCount;
                        }else{
                            $response["profiles"][$i]["clicksPerDay"] = 0;
                        }

                        // Get clicks per week
                        if( $clicksPerWeek = selectDB("clicks", "WEEK(`date`) = WEEK(CURDATE()) AND `profileId` = '{$profiles[$i]["id"]}' AND `userId` = '{$user[0]["id"]}'") ){
                            $clicksPerWeekCount = count($clicksPerWeek);
                            $response["profiles"][$i]["clicksPerWeek"] = $clicksPerWeekCount;
                        }else{
                            $response["profiles"][$i]["clicksPerWeek"] = 0;
                        }

                        // Get clicks per month
                        if( $clicksPerMonth = selectDB("clicks", "MONTH(`date`) = MONTH(CURDATE()) AND `profileId` = '{$profiles[$i]["id"]}' AND `userId` = '{$user[0]["id"]}'") ){
                            $clicksPerMonthCount = count($clicksPerMonth);
                            $response["profiles"][$i]["clicksPerMonth"] = $clicksPerMonthCount;
                        }else{
                            $response["profiles"][$i]["clicksPerMonth"] = 0;
                        }

                        // Get clicks per year
                        if( $clicksPerYear = selectDB("clicks", "YEAR(`date`) = YEAR(CURDATE()) AND `profileId` = '{$profiles[$i]["id"]}' AND `userId` = '{$user[0]["id"]}'") ){
                            $clicksPerYearCount = count($clicksPerYear);
                            $response["profiles"][$i]["clicksPerYear"] = $clicksPerYearCount;
                        }else{
                            $response["profiles"][$i]["clicksPerYear"] = 0;
                        }
                    } 
                    if( $clicksPerDay = selectDB("clicks", "DATE(`date`) = CURDATE() AND `profileId` = '0' AND `userId` = '{$user[0]["id"]}'") ){
                        $clicksPerDayCount = count($clicksPerDay);
                        $response["views"]["viewsPerDay"] = $clicksPerDayCount;
                    }else{
                        $response["views"]["viewsPerDay"] = 0;
                    }

                    // Get clicks per week
                    if( $clicksPerWeek = selectDB("clicks", "WEEK(`date`) = WEEK(CURDATE()) AND `profileId` = '0' AND `userId` = '{$user[0]["id"]}'") ){
                        $clicksPerWeekCount = count($clicksPerWeek);
                        $response["views"]["viewsPerWeek"] = $clicksPerWeekCount;
                    }else{
                        $response["views"]["viewsPerWeek"] = 0;
                    }

                    // Get clicks per month
                    if( $clicksPerMonth = selectDB("clicks", "MONTH(`date`) = MONTH(CURDATE()) AND `profileId` = '0' AND `userId` = '{$user[0]["id"]}'") ){
                        $clicksPerMonthCount = count($clicksPerMonth);
                        $response["views"]["viewsPerMonth"] = $clicksPerMonthCount;
                    }else{
                        $response["views"]["viewsPerMonth"] = 0;
                    }

                    // Get clicks per year
                    if( $clicksPerYear = selectDB("clicks", "YEAR(`date`) = YEAR(CURDATE()) AND `profileId` = '0' AND `userId` = '{$user[0]["id"]}'") ){
                        $clicksPerYearCount = count($clicksPerYear);
                        $response["views"]["viewsPerYear"] = $clicksPerYearCount;
                    }else{
                        $response["views"]["viewsPerYear"] = 0;
                    }
                    $userInfo = selectDB2("`fullName`, `logo`","users", "`id` = '{$user[0]["id"]}'");
                    $response["userInfo"] = $userInfo[0];
                }else{
                    $response = [];
                }
                echo outputData($response);die();
            }else{
                echo outputError(array("msg" => "Token Not Found"));die();
            }
        }
    }
}else{
    echo outputError(array("msg" => "Action Not Set"));die();
}
?>