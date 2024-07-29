<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('notification',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Notification");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('notification',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Notification");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('notification',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Notification");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB('notification',array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Notification");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['image']['tmp_name'])) {
            $_POST["image"] = uploadImageBanner($_FILES['image']['tmp_name']);
		}else{
            $_POST["image"] = "";
        }
		if( $users = selectDB2('id','users', "`hidden` = '1' AND `status` = '0' AND `firebaseToken` != ''") ){
            $_POST["listOfUsers"] = json_encode(addSeen($users));
        }else{
            $_POST["listOfUsers"] = json_encode(array());
        }
        if( $users = selectDB2('firebaseToken','users', "`language` = 0 AND `hidden` = '1' AND `status` = '0' AND `firebaseToken` != ''") ){
            $notificationData = array(
                "title" => $_POST["enTitle"],
                "body" => $_POST["enNotification"],
                "image" => $_POST["image"],
            );
            $batchSize = 1000;
            $totalUsers = count($users);
            $numBatches = ceil($totalUsers / $batchSize);
            for ($i = 0; $i < $numBatches; $i++) {
                $startIndex = $i * $batchSize;
                $endIndex = min(($i + 1) * $batchSize - 1, $totalUsers - 1);
                $batchUsers = array_slice($users, $startIndex, $endIndex - $startIndex + 1);
                firebaseNotification($notificationData, transformArray($batchUsers));
            }
        }
        if( $users = selectDB2('firebaseToken','users', "`language` = 1 AND `hidden` = '1' AND `status` = '0' AND `firebaseToken` != ''") ){
            $notificationData = array(
                "title" => $_POST["arTitle"],
                "body" => $_POST["arNotification"],
                "image" => $_POST["image"],
            );
            $batchSize = 1000;
            $totalUsers = count($users);
            $numBatches = ceil($totalUsers / $batchSize);
            for ($i = 0; $i < $numBatches; $i++) {
                $startIndex = $i * $batchSize;
                $endIndex = min(($i + 1) * $batchSize - 1, $totalUsers - 1);
                $batchUsers = array_slice($users, $startIndex, $endIndex - $startIndex + 1);
                firebaseNotification($notificationData, transformArray($batchUsers));
            }
        }
		if( insertDB('notification', $_POST) ){
			header("LOCATION: ?v=Notification");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Notification Details","تفاصيل الاشعار") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
                <label><?php echo direction("English Title","العنوان الانجليزي") ?></label>
                <input type="text" name="enTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
                <input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("English Notification","الاشعار الانجليزي") ?></label>
                <input type="text" name="enNotification" class="form-control" required>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Arabic Notification","الاشعار العربي") ?></label>
                <input type="text" name="arNotification" class="form-control" required>
			</div>
			
			<div class="col-md-6">
                <label><?php echo direction("Image","الصورة") ?></label>
                <input type="file" name="image" class="form-control">
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="hidden" value="1">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Notifications","قائمة الاشعارات") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Notification","الاشعار") ?></th>
		<th><?php echo direction("Image","الصورة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $notification = selectDB('notification',"`status` = '0' AND `hidden` = '1' ORDER BY `id` DESC") ){
            for( $i = 0; $i < sizeof($notification); $i++ ){
                if ( $notification[$i]["hidden"] == 2 ){
                    $icon = "fa fa-eye";
                    $link = "?v={$_GET["v"]}&show={$notification[$i]["id"]}";
                    $hide = direction("Show","إظهار");
                }else{
                    $icon = "fa fa-eye-slash";
                    $link = "?v={$_GET["v"]}&hide={$notification[$i]["id"]}";
                    $hide = direction("Hide","إخفاء");
                }
                ?>
                <tr>
                <td><?php echo $notification[$i]["id"] ?></td>
                <td><?php echo direction($notification[$i]["enTitle"],$notification[$i]["arTitle"]) ?></td>
                <td><?php echo direction($notification[$i]["enNotification"],$notification[$i]["arNotification"]) ?></td>
                <td><img src="../logos/<?php echo $notification[$i]["image"] ?>" style="width:150px;height:150px"></td>
                <td class="text-nowrap">
                    <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i></a>
                    <a href="<?php echo "?v={$_GET["v"]}&delId={$notification[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i></a>
                </td>
                </tr>
                <?php
            }
		}
		?>
		</tbody>
		
	</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>