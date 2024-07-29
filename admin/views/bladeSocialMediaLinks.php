<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('socialMedia',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=SocialMediaLinks");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('socialMedia',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=SocialMediaLinks");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('socialMedia',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=SocialMediaLinks");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("socialMedia",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=SocialMediaLinks");
}

if( isset($_POST["title"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB("socialMedia", $_POST) ){
			header("LOCATION: ?v=SocialMediaLinks");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB("socialMedia", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=SocialMediaLinks");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Link Details","تفاصيل الرابط") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Title","العنوان") ?></label>
			<input type="text" name="title" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Link","رابط") ?></label>
			<input type="text" name="link" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Icon","الصورة الرمزية") ?></label>
			<input type="text" name="icon" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Hide Link","أخفي الرابط") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Links","قائمة الروابط") ?></h6>
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
		<th><?php echo direction("Title","العنوان") ?></th>
		<th><?php echo direction("Link","الرابط") ?></th>
		<th><?php echo direction("Icon","الصورة") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $banners = selectDB("socialMedia","`status` = '0' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($banners); $i++ ){
		$counter = $i + 1;
		if ( $banners[$i]["hidden"] == 2 ){
			$icon = "fa fa-eye";
			$link = "?v={$_GET["v"]}&show={$banners[$i]["id"]}";
			$hide = direction("Show","إظهار");
		}else{
			$icon = "fa fa-eye-slash";
			$link = "?v={$_GET["v"]}&hide={$banners[$i]["id"]}";
			$hide = direction("Hide","إخفاء");
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter,2,"0",STR_PAD_LEFT) ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $banners[$i]["id"] ?>">
		</td>
		<td id="title<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["title"] ?></td>
		<td id="link<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["link"] ?></td>
		<td><?php echo $banners[$i]["icon"] ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $banners[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo "?v={$_GET["v"]}&delId={$banners[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
		</a>
		<div style="display:none"><label id="hidden<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["hidden"] ?></label></div>
		<div style="display:none"><label id="iconText<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["icon"] ?></label></div>		
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
        $("input[name=update]").val(id);
		var link = $("#link"+id).html();
		var title = $("#title"+id).html();
		var iconeText = $("#iconText"+id).html();
		$("input[name=link]").val(link);
		$("input[name=title]").val(title).focus();
		$("input[name=icon]").val(iconeText);
	})
</script>