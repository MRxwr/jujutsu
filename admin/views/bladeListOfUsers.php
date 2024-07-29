<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('users',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=ListOfUsers");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('users',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=ListOfUsers");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('users',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=ListOfUsers");
	}
}

if( isset($_POST["fullName"]) ){
	$id = $_POST["update"];
	$_POST["url"] = strtolower($_POST["url"]);
	unset($_POST["update"]);
	if ( $id == 0 ){
		if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
            $_POST["logo"] = uploadImageBanner($_FILES['logo']['tmp_name']);
		}else{
            $_POST["logo"] = "";
        }
		if (is_uploaded_file($_FILES['bgImage']['tmp_name'])) {
            $_POST["bgImage"] = uploadImageBanner($_FILES['bgImage']['tmp_name']);
		}else{
            $_POST["bgImage"] = "";
        }
		$_POST["password"] = sha1($_POST["password"]);
		if( insertDB("users", $_POST) ){
			header("LOCATION: ?v=ListOfUsers");
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
            $imageurl = selectDB("users", "`id` = '{$id}'");
            $_POST["logo"] = $imageurl[0]["logo"];
        }
		if (is_uploaded_file($_FILES['bgImage']['tmp_name'])) {
            $_POST["bgImage"] = uploadImageBanner($_FILES['bgImage']['tmp_name']);
		}else{
            $imageurl = selectDB("users", "`id` = '{$id}'");
            $_POST["bgImage"] = $imageurl[0]["bgImage"];
        }
		if( !empty($_POST["password"]) ){
			$_POST["password"] = sha1($_POST["password"]);
		}else{
			$password = selectDB("users","`id` = '{$id}'");
			$_POST["password"] = $password[0]["password"];
		}
		if( updateDB("users", $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=ListOfUsers");
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
<style>
	.secionHeader{
		margin: 15px;
		padding: 10px;
		background-color: #f2f2f2;
	}
</style>
<div class="row">		
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("User Details","تفاصيل العضو") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-12 secionHeader text-center"><h6 class="panel-title txt-dark"><?php echo direction("User Credintials","بيانات العضو") ?></h6></div>
			<div class="col-md-3">
			<label><?php echo direction("Name","الإسم") ?></label>
			<input type="text" name="fullName" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Password","كلمة المرور") ?></label>
			<input type="text" name="password" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" min="0" maxlength="8" name="phone" class="form-control" required>
			</div>

			<div class="col-md-12 secionHeader text-center"><h6 class="panel-title txt-dark"><?php echo direction("Profile Page","الصفحة الأساسية") ?></h6></div>

			<div class="col-md-4">
			<label><?php echo direction("URL","الرابط") ?> -> https://createid.link/example</label>
			<input type="text" name="url" class="form-control" placeholder="example" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Subtitle","العنوان الفرعي") ?></label>
			<input type="text" name="details" class="form-control" required>
			</div>
			
			<div class="col-md-4">
			<label><?php echo direction("Logo","الشعار") ?></label>
			<input type="file" name="logo" class="form-control">
			</div>

			<div class="col-md-12 secionHeader text-center"><h6 class="panel-title txt-dark"><?php echo direction("Theme","الشكل") ?></h6></div>

			<div class="col-md-12">
			<label><?php echo direction("Background type","نوع الخلفية") ?></label>
			<select name="bgType" class="form-control" required>
				<?php 
				$bgTypesValue = [1,2,3];
				$bgTypes = [direction("Four Colors Moving","أربع ألوان متحركه"),direction("Single Color","لون واحد"),direction("Image","صورة")];
				for( $i = 0; $i < sizeof($bgTypesValue); $i++){
					echo "<option value='{$bgTypesValue[$i]}'>{$bgTypes[$i]}</option>";
				}
				?>
			</select>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Color 1","اللون الأول") ?></label>
			<input type="color" name="fourColors1" class="form-control">
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Color 2","اللون الثاني") ?></label>
			<input type="color" name="fourColors2" class="form-control">
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Color 3","اللون الثالث") ?></label>
			<input type="color" name="fourColors3" class="form-control">
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Color 4","اللون الرابع") ?></label>
			<input type="color" name="fourColors4" class="form-control">
			</div>

			<div class="col-md-12">
			<label><?php echo direction("Single Color","لون واحد") ?></label>
			<input type="color" name="singleColor" class="form-control">
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Size","الحجم") ?></label>
			<select name="bgSize" class="form-control">
				<option>cover</option>
				<option>inherit</option>
				<option>contain</option>
			</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Repeat","تكرار") ?></label>
			<select name="bgRepeat" class="form-control">
				<option>repeat</option>
				<option>no-repeat</option>
			</select>
			</div>

			<div class="col-md-4">
			<label><?php echo direction("Background","الخلفية") ?></label>
			<input type="file" name="bgImage" class="form-control">
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
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Users","قائمة المستخدمين") ?></h6>
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
		<th><?php echo direction("Logo","الشعار") ?></th>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Email","الإيميل") ?></th>
		<th><?php echo direction("URL","الرابط") ?></th>
		<th><?php echo direction("Subtitle","العنوان الفرعي") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $users = selectDB("users","`status` = '0'") ){
			for( $i = 0; $i < sizeof($users); $i++ ){
				$counter = $i + 1;
				if ( $users[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?v={$_GET["v"]}&show={$users[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?v={$_GET["v"]}&hide={$users[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}
				
				?>
				<tr>
				<td><img src="../logos/<?php echo $users[$i]["logo"] ?>" style="height:100px;width:100px;"></td>
				<td id="name<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["fullName"] ?></td>
				<td id="mobile<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["phone"] ?></td>
				<td id="email<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["email"] ?></td>
				<td id="url<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["url"] ?></td>
				<td id="details<?php echo $users[$i]["id"]?>" ><?php echo $users[$i]["details"] ?></td>
				<td class="text-nowrap">
				
				<a href="?v=UserInfo&id=<?php echo $users[$i]["id"] ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo direction("More","المزيد") ?>"> <i class="fa fa-plus text-inverse m-r-10"></i>
				</a>

				<a id="<?php echo $users[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
				</a>
				<a href="<?php echo "?v={$_GET["v"]}&delId={$users[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
				</a>
				<div style="display:none">
					<label id="logo<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["logo"] ?></label>
					<label id="bgImage<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["bgImage"] ?></label>
					<label id="singleColor<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["singleColor"] ?></label>
					<label id="fourColors1<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["fourColors1"] ?></label>
					<label id="fourColors2<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["fourColors2"] ?></label>
					<label id="fourColors3<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["fourColors3"] ?></label>
					<label id="fourColors4<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["fourColors4"] ?></label>
					<label id="bgType<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["bgType"] ?></label>
					<label id="bgSize<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["bgSize"] ?></label>
					<label id="bgRepeat<?php echo $users[$i]["id"]?>"><?php echo $users[$i]["bgRepeat"] ?></label>
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
		$("input[name=fullName]").focus();
		$("input[name=email]").val($("#email"+id).html());
		$("input[name=phone]").val($("#mobile"+id).html());
		$("input[name=fullName]").val($("#name"+id).html());
		$("input[name=url]").val($("#url"+id).html());
		$("input[name=details]").val($("#details"+id).html());
		$("input[name=singleColor]").val($("#singleColor"+id).html());
		$("input[name=fourColors1]").val($("#fourColors1"+id).html());
		$("input[name=fourColors2]").val($("#fourColors2"+id).html());
		$("input[name=fourColors3]").val($("#fourColors3"+id).html());
		$("input[name=fourColors4]").val($("#fourColors4"+id).html());
		$("select[name=bgType]").val($("#bgType"+id).html());
		$("select[name=bgSize]").val($("#bgSize"+id).html());
		$("select[name=bgRepeat]").val($("#bgRepeat"+id).html());
		$("input[name=password]").prop("required",false);
		$("input[name=logo]").prop("required",false);
		$("input[name=bgImage]").prop("required",false);
	})
</script>