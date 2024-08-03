<?php 
if( isset($_POST["sessionId"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('studentMore', $_POST) ){
			header("LOCATION: ?v=StudentMore&id={$_POST["studentId"]}");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('studentMore', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=StudentMore&id={$_POST["studentId"]}");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}
}
if( isset($_GET["id"]) && !empty($_GET["id"]) && $student = selectDBNew("students",[$_GET["id"]],"`id` = ?","") ){
}else{
    header("LOCATION: ?v=Students");
}
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Session Details","تفاصيل الكلاس") . " : " . $student[0]["fullName"]?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			    <label><?php echo direction("Session","الكلاس") ?></label>
				<select name="sessionId" class="form-control">
					<?php
						if( $Invoices = selectDB('sessions',"`status` = '0' AND `hidden` = '0'") ){
							for( $i = 0; $i < sizeof($Invoices); $i++ ){
								echo "<option value='{$Invoices[$i]["id"]}'>".direction($Invoices[$i]["enTitle"],$Invoices[$i]["arTitle"])."</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class="col-md-6">
			    <label><?php echo direction("Total Sessions","مجموع الكلاسات") ?></label>
			    <input type="number" step="1" min="0" name="total" class="form-control" value="12" required>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="studentId" value="<?php echo $_GET["id"] ?>">
            <input type="hidden" name="update" value="0">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Student Sessions","قائمة كلاسات الطالب") . " : " . $student[0]["fullName"] ?></h6>
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
		<th><?php echo direction("Session","الكلاس") ?></th>
		<th><?php echo direction("Total Sessions","مجموع الكلاسات") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $Invoices = selectDBNew('studentMore',[0],"`status` = ?","`id` ASC") ){
			for( $i = 0; $i < sizeof($Invoices); $i++ ){
				$session = selectDB('sessions',"`id` = '{$Invoices[$i]["sessionId"]}'");
				?>
				<tr>
				<td><?php echo str_pad(($y = $i + 1), 1, '0', STR_PAD_LEFT) ?></td>
				<td><?php echo direction($session[0]["enTitle"],$session[0]["arTitle"]) ?></td>
				<td><?php echo $Invoices[$i]["total"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $Invoices[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
				<div style="display:none">
                    <label id="sessionId<?php echo $Invoices[$i]["id"]?>"><?php echo $Invoices[$i]["sessionId"] ?></label>
                    <label id="total<?php echo $Invoices[$i]["id"]?>"><?php echo $Invoices[$i]["total"] ?></label>
                    <label id="studentId<?php echo $Invoices[$i]["id"]?>"><?php echo $Invoices[$i]["studentId"] ?></label>
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


<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Student Invoices","قائمة فواتير الطالب ") . " : " . $student[0]["fullName"] ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body"> 
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable1">
		<thead>
		<tr>
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Invoice#","رقم الفاتورة") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $Invoices = selectDBNew('invoices',[$_GET["id"]],"`studentId` = ?","`id` DESC") ){
			for( $i = 0; $i < sizeof($Invoices); $i++ ){
				$Invocie = selectDB('invoices',"`id` = '{$Invoices[$i]["id"]}'");
                // status 1 = paid, 2 = cancelled, 0 = pending
                if( $Invoices[$i]["status"] == 1 ){
                    $status = direction("Paid","مدفوعة");
                }elseif( $Invoices[$i]["status"] == 2 ){
                    $status = direction("Cancelled","ملغية");
                }else{
                    $status = direction("Pending","قيد الانتظار");
                }
				?>
				<tr>
				<td><?php echo $Invoices[$i]["date"] ?></td>
				<td><a href="?v=InvoiceDetails&id=<?php echo $Invoices[$i]["id"] ?>" target="_blank"><?php echo $Invoices[$i]["id"] ?></td>
				<td><?php echo $Invoices[$i]["price"] ?></td>
				<td><?php echo $status ?></td>		
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
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
        $("input[name=update]").val(id);
        $("input[type=submit]").val("<?php echo direction("Update","حدث") ?>");

        $("select[name=sessionId]").val($("#sessionId"+id).html()).focus();
		$("input[name=total]").val($("#total"+id).html());
		$("input[name=studentId]").val($("#studentId"+id).html());
	})
</script>