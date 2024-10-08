<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('employees',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Trainers");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('employees',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Trainers");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('employees',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Trainers");
	}
}

if( isset($_POST["fullName"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		$_POST["password"] = sha1($_POST["password"]);
		if( insertDB('employees', $_POST) ){
			header("LOCATION: ?v=Trainers");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( !empty($_POST["password"]) ){
			$_POST["password"] = sha1($_POST["password"]);
		}else{
			$password = selectDB('employees',"`id` = '{$id}'");
			$_POST["password"] = $password[0]["password"];
		}
		if( updateDB('employees', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Trainers");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Trainer Details","تفاصيل المدرب") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("Name","الإسم") ?></label>
			<input type="text" name="fullName" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Email","البريد الإلكتروني") ?></label>
			<input type="text" name="email" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Password","كلمة المرور") ?></label>
			<input type="text" name="password" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Mobile","الهاتف") ?></label>
			<input type="number" min="0" maxlength="8" name="phone" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Branch","الفرع") ?></label>
			<select name="shopId" class="form-control">
				<?php
				if( $branch = selectDB("branches","`status` = '0' AND `hidden` = '0'") ){
					for( $i = 0; $i < sizeof($branch); $i++ ){
						$branchTitle = direction($branch[$i]["enTitle"],$branch[$i]["arTitle"]);
						echo "<option value='{$branch[$i]["id"]}'>{$branchTitle}</option>";
					}
				}
				?>
			</select>
			</div>
			
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="0">
			<input type="hidden" name="empType" value="5">
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Trainers","قائمة المدربين") ?></h6>
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
		<th><?php echo direction("Name","الإسم") ?></th>
		<th><?php echo direction("Email","الإيميل") ?></th>
		<th><?php echo direction("Mobile","الهاتف") ?></th>
		<th><?php echo direction("Shop","المحل") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $trainers = selectDB('employees',"`status` = '0' AND `empType` = '5'") ){
			for( $i = 0; $i < sizeof($trainers); $i++ ){
				if ( $trainers[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?v={$_GET["v"]}&show={$trainers[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?v={$_GET["v"]}&hide={$trainers[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}
				
				if( $branch = selectDB("branches","`id` = '{$trainers[$i]["shopId"]}'") ){
					$branch = direction($branch[0]["enTitle"],$branch[0]["arTitle"]);
				}else{
					$branch = "";
				}
				
				?>
				<tr>
				<td id="name<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["fullName"] ?></td>
				<td id="email<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["email"] ?></td>
				<td id="mobile<?php echo $trainers[$i]["id"]?>" ><?php echo $trainers[$i]["phone"] ?></td>
				<td><?php echo $branch ?></td>
				<td class="text-nowrap">
                    <a id="<?php echo $trainers[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
                    </a>
                    <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
                    </a>
                    <a href="<?php echo "?v={$_GET["v"]}&delId={$trainers[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
                    </a>
				<div style="display:none"><label id="shop<?php echo $trainers[$i]["id"]?>"><?php echo $trainers[$i]["shopId"] ?></label></div>		
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
		var email = $("#email"+id).html();
		var name = $("#name"+id).html();
		var mobile = $("#mobile"+id).html();
		var shop = $("#shop"+id).html();
		$("input[name=password]").prop("required",false);
		$("input[name=email]").val(email);
		$("input[name=phone]").val(mobile);
		$("input[name=update]").val(id);
		$("input[name=fullName]").val(name);
		$("input[name=fullName]").focus();
		$("select[name=shopId]").val(shop);
	})
</script>