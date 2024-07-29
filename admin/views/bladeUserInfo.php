<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('profiles',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('profiles',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('profiles',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB("profiles",array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
}

if( isset($_POST["account"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            $_POST["logo"] = uploadImageBanner($_FILES['logo']['tmp_name']);
		}else{
            $_POST["logo"] = "";
        }
		if( insertDB("profiles", $_POST) ){
			header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            $_POST["logo"] = uploadImageBanner($_FILES['logo']['tmp_name']);
		}else{
            $imageurl = selectDB("profiles", "`id` = '{$id}'");
            $_POST["logo"] = $imageurl[0]["logo"];
        }
		if( updateDB("profiles", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=UserInfo&id={$_GET["id"]}");die();
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

			<div class="col-md-4">
			<label><?php echo direction("Platform","المنصة") ?></label>
			<select name="smId" class="form-control">
				<?php
				if( $socialMedia = selectDB("socialMedia","`hidden` = '1' AND `status` = '0' ORDER BY `title` ASC") ){
					for( $i = 0; $i < sizeof($socialMedia); $i++ ){
						echo "<option value='{$socialMedia[$i]["id"]}'>{$socialMedia[$i]["title"]}</option>";
					}
				}
				?>
			</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Text","النص") ?></label>
			<input type="text" name="text" class="form-control">
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Account / Link","الحساب / الرابط") ?></label>
			<input type="text" name="account" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Button Color","لون الزر") ?></label>
			<select name="btnColor" class="form-control">
				<option value="btn btn-outline-light" class='txt-light'>Light - Outline</option>
				<option value="btn btn-outline-primary" class='txt-primary'>Blue - Outline</option>
				<option value="btn btn-outline-secondary" class='txt-secondary'>Gray - Outline</option>
				<option value="btn btn-outline-success" class='txt-success'>Green - Outline</option>
				<option value="btn btn-outline-danger" class='txt-danger'>Red - Outline</option>
				<option value="btn btn-outline-warning" class='txt-warning'>Yellow - Outline</option>
				<option value="btn btn-outline-info" class='txt-info'>Turquoise - Outline</option>
				<option value="btn btn-outline-dark" class='txt-dark'>Dark - Outline</option>
				<option value="btn btn-light" class='txt-light'>Light - Fill</option>
				<option value="btn btn-primary" class='txt-primary'>Blue - Fill</option>
				<option value="btn btn-secondary" class='txt-secondary'>Gray - Fill</option>
				<option value="btn btn-success" class='txt-success'>Green - Fill</option>
				<option value="btn btn-danger" class='txt-danger'>Red - Fill</option>
				<option value="btn btn-warning" class='txt-warning'>Yellow - Fill</option>
				<option value="btn btn-info" class='txt-info'>Turquoise - Fill</option>
				<option value="btn btn-dark" class='txt-dark'>Dark - Fill</option>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Moving ?","متحرك ؟") ?></label>
			<select name="isMoving" class="form-control">
				<option value="1"><?php echo direction("Yes","نعم") ?></option>
				<option value="2" selected><?php echo direction("No","لا") ?></option>
			</select>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Hide Link","أخفي الرابط") ?></label>
			<select name="hidden" class="form-control">
				<option value="1">No</option>
				<option value="2">Yes</option>
			</select>
			</div>	

			<div class="col-md-3">
			<label><?php echo direction("Icon","الايقونه") ?></label>
			<input type="file" name="logo" class="form-control">
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="userId" value="<?php echo $_GET["id"] ?>">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Accounts","قائمة الحسابات") ?></h6>
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
		<th><?php echo direction("Platform","المنصة") ?></th>
		<th><?php echo direction("Text","النص") ?></th>
		<th><?php echo direction("Account","الحساب") ?></th>
		<th><?php echo direction("Moving","متحرك") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $profiles = selectDB("profiles","`status` = '0' AND `userId` = '{$_GET["id"]}' ORDER BY `rank` ASC") ){
		for( $i = 0; $i < sizeof($profiles); $i++ ){
		$counter = $i + 1;
		if ( $profiles[$i]["hidden"] == 2 ){
			$icon = "fa fa-eye";
			$link = "?v={$_GET["v"]}&show={$profiles[$i]["id"]}";
			$hide = direction("Show","إظهار");
		}else{
			$icon = "fa fa-eye-slash";
			$link = "?v={$_GET["v"]}&hide={$profiles[$i]["id"]}";
			$hide = direction("Hide","إخفاء");
		}
		$isMoving = ( $profiles[$i]["isMoving"] == 1 ) ? direction("Yes","نعم"): direction("No","لا");
		if( $socialMedia = selectDB("socialMedia","`id` = '{$profiles[$i]["smId"]}'") ){
			$profileLogo = ( isset($profiles[$i]["logo"]) && !empty($profiles[$i]["logo"]) ) ? "<img src='../logos/{$profiles[$i]["logo"]}' style='height:25px;width:25px'>" : $socialMedia[0]["icon"] ;
			$socialMediaTitle = ( isset($socialMedia[0]["title"]) ) ? "{$profileLogo} - {$socialMedia[0]["title"]}" : "" ;
		}else{
			$socialMediaTitle = ( isset($socialMedia[0]["title"]) ) ? $socialMedia[0]["title"] : "" ;
		}
		?>
		<tr>
		<td>
		<input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter,2,"0",STR_PAD_LEFT) ?>">
		<input name="id[]" class="form-control" type="hidden" value="<?php echo $profiles[$i]["id"] ?>">
		</td>
		<td><?php echo $socialMediaTitle ?></td>
		<td id="text<?php echo $profiles[$i]["id"]?>" ><?php echo $profiles[$i]["text"] ?></td>
		<td id="account<?php echo $profiles[$i]["id"]?>" ><?php echo $profiles[$i]["account"] ?></td>
		<td><?php echo $isMoving ?></td>
		<td class="text-nowrap">
		
		<a id="<?php echo $profiles[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo $link."&id={$profiles[$i]["userId"]}" ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
		</a>
		<a href="<?php echo "?v={$_GET["v"]}&delId={$profiles[$i]["id"]}&id={$profiles[$i]["userId"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
		</a>
		<div style="display:none">
			<label id="hidden<?php echo $profiles[$i]["id"]?>"><?php echo $profiles[$i]["hidden"] ?></label>
			<label id="isMoving<?php echo $profiles[$i]["id"]?>"><?php echo $profiles[$i]["isMoving"] ?></label>
			<label id="smId<?php echo $profiles[$i]["id"]?>"><?php echo $profiles[$i]["smId"] ?></label>
			<label id="logo<?php echo $profiles[$i]["id"]?>"><?php echo $profiles[$i]["logo"] ?></label>
			<label id="btnColor<?php echo $profiles[$i]["id"]?>"><?php echo $profiles[$i]["btnColor"] ?></label>
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
</form>
</div>
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
        $("input[name=update]").val(id);

		$("select[name=isMoving]").val($("#isMoving"+id).html()).focus();
		$("input[name=account]").val($("#account"+id).html());
		$("input[name=text]").val($("#text"+id).html());
		$("select[name=smId]").val($("#smId"+id).html());
		$("select[name=hidden]").val($("#hidden"+id).html());
		$("select[name=btnColor]").val($("#btnColor"+id).html());
	})
</script>