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
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Session Details","تفاصيل الكلاس") ?></h6>
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
						if( $sessions = selectDB('sessions',"`status` = '0' AND `hidden` = '0'") ){
							for( $i = 0; $i < sizeof($sessions); $i++ ){
								echo "<option value='{$sessions[$i]["id"]}'>".direction($sessions[$i]["enTitle"],$sessions[$i]["arTitle"])."</option>";
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Student Sessions","قائمة كلاسات الطالب") ?></h6>
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
		<th><?php echo direction("Session","الكلاس") ?></th>
		<th><?php echo direction("Total Sessions","مجموع الكلاسات") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $sessions = selectDBNew('studentMore',[0],"`status` = ?","`id` DESC") ){
			for( $i = 0; $i < sizeof($sessions); $i++ ){
				$session = selectDB('sessions',"`id` = '{$sessions[$i]["sessionId"]}'");
				?>
				<tr>
				<td><?php echo direction($session[0]["enTitle"],$session[0]["arTitle"]) ?></td>
				<td><?php echo $sessions[$i]["total"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $sessions[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
				<div style="display:none">
                    <label id="sessionId<?php echo $sessions[$i]["id"]?>"><?php echo $sessions[$i]["sessionId"] ?></label>
                    <label id="total<?php echo $sessions[$i]["id"]?>"><?php echo $sessions[$i]["total"] ?></label>
                    <label id="studentId<?php echo $sessions[$i]["id"]?>"><?php echo $sessions[$i]["studentId"] ?></label>
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
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
        $("input[name=update]").val(id);
        $("input[type=submit]").html("<?php echo direction("Update","حدث") ?>");

        $("select[name=sessionId]").val($("#sessionId"+id).html()).focus();
		$("input[name=total]").val($("#total"+id).html());
		$("input[name=studentId]").val($("#studentId"+id).html());
	})
</script>