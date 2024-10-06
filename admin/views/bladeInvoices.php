<?php 
if( isset($_GET["id"]) && !empty($_GET["id"]) ){
	$id = $_GET["id"];
    $_POST["status"] = $_GET["status"];
    if( updateDB('invoices', $_POST, "`id` = '{$id}'") ){
        header("LOCATION: ?v=Invoices");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
}

if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('invoices',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Invoices");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('invoices',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Invoices");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('invoices',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Invoices");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB('invoices',array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Invoices");
}

if( isset($_POST["student"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	$student = selectDB('students',"`id` = '{$_POST["studentId"]}'");
	$session = selectDB('sessions',"`id` = '{$_POST["sessionId"]}'");
	$settings = selectDB('settings',"`id` != '0'");
	$dataInsert = array(
		"title" => "New Invoice issued for {$student[0]["fullName"]} On ".date('Y-m-d'),
		"description" => "Invoice issued for {$session[0]["enTitle"]}",
		"price" => "{$_POST["price"]}",
		"orderId" => date('Y-m-d').time(),
		"name" => "{$student[0]["fullName"]}",
		"email" =>"{$settings[0]["email"]}",
		"mobile" => "{$_POST["mobile"]}",
		"returnURL" => "{$settings[0]["website"]}",
		"cancelURL" => "{$settings[0]["website"]}"
	);
	$response = submitUpayment($dataInsert);
	$_POST["gatewayBody"] = json_encode($dataInsert);
	$_POST["gatewayResponse"] = $response;
	$_POST["gatewayId"] = $dataInsert["orderId"];
	if ( $id == 0 ){
		if( insertDB('invoices', $_POST) ){
			header("LOCATION: ?v=Invoices");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('invoices', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Invoices");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Invoice Details","تفاصيل الفاتورة") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-3">
			<label><?php echo direction("Studen","المتدرب") ?></label>
			<select name="studentId" class="form-control" required>
				<?php
				if( $students = selectDB('students',"`status` = '0' ") ){
					for( $i = 0; $i < sizeof($students); $i++){
						echo '<option value="'.$students[$i]["id"].'">'.$students[$i]["fullName"].'</option>';
					}
				}
				?>
			</select>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Class","الصف") ?></label>
			<select name="sessionId" class="form-control" required>
				<?php
				if( $sessions = selectDB('sessions',"`status` = '0' ") ){
					for( $i = 0; $i < sizeof($sessions); $i++){
						echo '<option value="'.$sessions[$i]["id"].'">'.direction($sessions[$i]["enTitle"],$sessions[$i]["arTitle"]).'</option>';
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" step="any" name="mobile" class="form-control" placeholder="96512345678" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Price","السعر") ?></label>
			<input type="number" step="any" min="1" name="price" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Generate Link","إنشاء رابط") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>


<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Invoices","قائمة الفواتير") ?></h6>
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
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Name","الاسم") ?></th>
		<th><?php echo direction("Session","الكلاس") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $Invoices = selectDBNew('invoices',[0],"`id` != ?","`id` DESC") ){
			for( $i = 0; $i < sizeof($Invoices); $i++ ){
				$session = selectDB('sessions',"`id` = '{$Invoices[$i]["sessionId"]}'");
				$student = selectDB('students',"`id` = '{$Invoices[$i]["studentId"]}'");
                if( $Invoices[$i]["status"] == 1 ){
                    $status = direction("Paid","مدفوعة");
                }elseif( $Invoices[$i]["status"] == 2 ){
                    $status = direction("Cancelled","ملغية");
                }else{
                    $status = direction("Pending","قيد الانتظار");
                }
				?>
				<tr>
				<td><a href="?v=InvoiceDetails&id=<?php echo $Invoices[$i]["id"] ?>" target="_blank"><?php echo str_pad($Invoices[$i]["id"], 4, '0', STR_PAD_LEFT) ?></td>
                <td><?php echo substr($Invoices[$i]["date"],0,10) ?></td>
				<td><?php echo $student[0]["fullName"] ?></td>
				<td><?php echo direction("{$session[0]["enTitle"]}",$session[0]["arTitle"]) ?></td>
				<td><?php echo $Invoices[$i]["price"] ?></td>
				<td><?php echo $status ?></td>		
				</td>
                <td class="text-nowrap">
					<a href='<?php echo "https://wa.me/{$Invoices[$i]["mobile"]}" ?>' target="_blank" style="align-content: center;" class="btn btn-info btn-xs"><?php echo direction("Send Link","إرسال الرابط") ?></a>
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=0" ?>" style="align-content: center;" class="btn btn-default btn-xs"><?php echo direction("Pending","قيد الانتظار") ?></a>
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=1" ?>" style="align-content: center;" class="btn btn-success btn-xs"><?php echo direction("Paid","مدفوعة") ?></a>
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=2" ?>" style="align-content: center;" class="btn btn-danger btn-xs"><?php echo direction("Cancelled","ملغية") ?></a>
                    <div style="display:none">
                        <label><?php echo $student[0]["mobile"] ?></label>
                    </div>	
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