<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('branches',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Branches");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('branches',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Branches");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('branches',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Branches");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB('branches',array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Branches");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('branches', $_POST) ){
			header("LOCATION: ?v=Branches");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('branches', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Branches");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Branch Details","تفاصيل الفرع") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Branches","قائمة الفروع") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("English Title","العنوان الإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان العربي") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $branches = selectDB('branches',"`status` = '0' ORDER BY `rank` ASC") ){
			for( $i = 0; $i < sizeof($branches); $i++ ){
				$counter = $i + 1;
				if ( $branches[$i]["hidden"] == 2 ){
					$icon = "fa fa-eye";
					$link = "?v={$_GET["v"]}&show={$branches[$i]["id"]}";
					$hide = direction("Show","إظهار");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?v={$_GET["v"]}&hide={$branches[$i]["id"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td>
				<input name="rank[]" class="form-control" type="number" value="<?php echo $counter ?>">
				<input name="id[]" class="form-control" type="hidden" value="<?php echo $branches[$i]["id"] ?>">
				</td>
				<td id="enTitle<?php echo $branches[$i]["id"]?>" ><?php echo $branches[$i]["enTitle"] ?></td>
				<td id="arTitle<?php echo $branches[$i]["id"]?>" ><?php echo $branches[$i]["arTitle"] ?></td>
				<td class="text-nowrap">
					<a id="<?php echo $branches[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$branches[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
					</a>
				<div style="display:none"><label id="hidden<?php echo $branches[$i]["id"]?>"><?php echo $branches[$i]["hidden"] ?></label></div>		
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
</form>
</div>
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
		var hidden = $("#hidden"+id).html();
		$("input[name=enTitle]").val(enTitle);
		$("input[name=update]").val(id);
		$("input[name=arTitle]").val(arTitle);
		$("select[name=hidden]").val(hidden);
	})
</script>