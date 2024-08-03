<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('students',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Students");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('students',array('hidden'=> '0'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Students");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('students',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Students");
	}
}

if( isset($_POST["fullName"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('students', $_POST) ){
			header("LOCATION: ?v=Students");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('students', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Students");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Student Details","تفاصيل الطالب") ?></h6>
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
				<label><?php echo direction("Civil ID","الرقم المدني") ?></label>
				<input type="number" min="0" maxlength="12" step="1" name="civilId" class="form-control" required>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Mobile","الهاتف") ?></label>
				<input type="number" min="0" maxlength="8" step="1" name="mobile" class="form-control" required>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Date of Birth","تاريخ الميلاد") ?></label>
				<input type="date" name="dateOfBirth" class="form-control" value="1990-01-01" required>
			</div>

			<div class="col-md-6">
				<label><?php echo direction("Subscription Fees","الرسوم الاشتراك") ?></label>
				<input type="number" min="0" step="0.1" name="subscription" class="form-control" required>
			</div>

			<div class="col-md-6">
				<label><?php echo direction("Nationality","الجنسية") ?></label>
				<select name="nationalityId" class="form-control">
					<?php
						$nationality = selectDB('cities',"`status` = '0' GROUP BY `CountryName` ORDER BY `CountryName` ASC");
						for( $i = 0; $i < sizeof($nationality); $i++ ){
							echo "<option value='{$nationality[$i]["id"]}'>{$nationality[$i]["CountryName"]}</option>";
						}
					?>
				</select>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Belt","الحزام") ?></label>
				<select name="beltId" class="form-control">
					<?php
						$belts = selectDB('belts',"`status` = '0' AND `hidden` = '0'");
						for( $i = 0; $i < sizeof($belts); $i++ ){
							echo "<option value='{$belts[$i]["id"]}'>".direction($belts[$i]["enTitle"],$belts[$i]["arTitle"])."</option>";
						}
					?>
				</select>
			</div>

			<div class="col-md-6">
				<label><?php echo direction("Strap","الستراب") ?></label>
				<select name="strap" class="form-control">
					<option value='0'>0</option>
					<option value='1'>1</option>
					<option value='2'>2</option>
					<option value='3'>3</option>
					<option value='4'>4</option>
				</select>
			</div>

            <div class="col-md-6">
				<label><?php echo direction("Marital Status","الحالة الإجتماعية") ?></label>
				<select name="maritalStatus" class="form-control">
					<option value='0'><?php echo direction("Single","أعزب") ?></option>
					<option value='1'><?php echo direction("Married","متزوج") ?></option>
				</select>
			</div>

            <div class="col-md-6">
				<label><?php echo direction("Player lives with","يعيش اللاعب مع") ?></label>
				<select name="livesWith" class="form-control">
					<option value='0'><?php echo direction("Both","كلا الوالدين") ?></option>
					<option value='1'><?php echo direction("Mother","الأم") ?></option>
					<option value='2'><?php echo direction("Father","الاب") ?></option>
					<option value='3'><?php echo direction("Alone","وحيدا") ?></option>
				</select>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Did you have a surgery","هل لديك عملية جراحة") ?></label>
				<select name="surgery" class="form-control">
					<option value='0'><?php echo direction("No","لا") ?></option>
					<option value='1'><?php echo direction("Yes","نعم") ?></option>
				</select>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Mention","إذكرها") ?></label>
				<input type="text" name="mentionSurgery" class="form-control">
			</div>

            <div class="col-md-6">
				<label><?php echo direction("Do you have an injury","هل لديك إصابة") ?></label>
				<select name="injury" class="form-control">
					<option value='0'><?php echo direction("No","لا") ?></option>
					<option value='1'><?php echo direction("Yes","نعم") ?></option>
				</select>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Mention","إذكرها") ?></label>
				<input type="text" name="mentionInjury" class="form-control">
			</div>

            <div class="col-md-6">
				<label><?php echo direction("Do you have sickness","هل لديك مرض") ?></label>
				<select name="sickness" class="form-control">
					<option value='0'><?php echo direction("No","لا") ?></option>
					<option value='1'><?php echo direction("Yes","نعم") ?></option>
				</select>
			</div>
            
			<div class="col-md-6">
				<label><?php echo direction("Mention","إذكرها") ?></label>
				<input type="text" name="mentionSickness" class="form-control" >
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
<h6 class="panel-title txt-dark"><?php echo direction("List of Students","قائمة الطلاب") ?></h6>
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
		<th><?php echo direction("More","المزيد") ?></th>
		<th class="text-nowrap"><?php echo direction("الخيارات","Actions") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $students = selectDB('students',"`status` = '0' ") ){
			for( $i = 0; $i < sizeof($students); $i++ ){
				$counter = $i + 1;
				if ( $students[$i]["hidden"] == 2 ){
					$icon = "fa fa-unlock";
					$link = "?v={$_GET["v"]}&show={$students[$i]["id"]}";
					$hide = direction("Unlock","فتح الحساب");
				}else{
					$icon = "fa fa-lock";
					$link = "?v={$_GET["v"]}&hide={$students[$i]["id"]}";
					$hide = direction("Lock","قفل الحساب");
				}
				
				?>
				<tr>
				<td style="text-wrap: wrap;"><?php echo $students[$i]["fullName"] ?></td>
				<td>
					<a id="<?php echo $students[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Sessions","الكلاسات") ?>"><i class="fa fa-list text-inverse m-r-10"></i>
					</a>
					<a id="<?php echo $students[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Invoices","الفواتير") ?>"><i class="fa fa-log text-inverse m-r-10"></i>
					</a>
				</td>
				<td class="text-nowrap">
					<a id="<?php echo $students[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
					</a>
					<a href="<?php echo "?v={$_GET["v"]}&delId={$students[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
					</a>
				<div style="display:none">
					<label id="fullName<?php echo $students[$i]["id"]?>"><?php echo $students[$i]["fullName"] ?></label>
					<label id="mobile<?php echo $students[$i]["id"]?>"><?php echo $students[$i]["mobile"] ?></label>
					<label id="civilId<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["civilId"] ?></label>					
					<label id="dateOfBirth<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["dateOfBirth"] ?></label>					
					<label id="subscription<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["subscription"] ?></label>					
					<label id="nationalityId<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["nationalityId"] ?></label>					
					<label id="beltId<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["beltId"] ?></label>			
					<label id="strap<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["strap"] ?></label>			
					<label id="maritalStatus<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["maritalStatus"] ?></label>			
					<label id="livesWith<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["livesWith"] ?></label>			
					<label id="surgery<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["surgery"] ?></label>			
					<label id="mentionSurgery<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["mentionSurgery"] ?></label>			
					<label id="injury<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["injury"] ?></label>			
					<label id="mentionInjury<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["mentionInjury"] ?></label>			
					<label id="sickness<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["sickness"] ?></label>			
					<label id="mentionSickness<?php echo $students[$i]["id"] ?>" ><?php echo $students[$i]["mentionSickness"] ?></label>			
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

		$("input[name=fullName]").val($("#fullName"+id).html()).focus();
		$("input[name=civilId]").val($("#civilId"+id).html());
		$("input[name=dateOfBirth]").val($("#dateOfBirth"+id).html());
		$("input[name=subscription]").val($("#subscription"+id).html());
		$("input[name=mobile]").val($("#mobile"+id).html());
		$("input[name=mentionSurgery]").val($("#mentionSurgery"+id).html());
		$("input[name=mentionInjury]").val($("#mentionInjury"+id).html());
		$("input[name=mentionSickness]").val($("#mentionSickness"+id).html());
		$("select[name=nationalityId]").val($("#nationalityId"+id).html());
		$("select[name=beltId]").val($("#beltId"+id).html());
		$("select[name=strap]").val($("#strap"+id).html());
		$("select[name=maritalStatus]").val($("#maritalStatus"+id).html());
		$("select[name=livesWith]").val($("#livesWith"+id).html());
		$("select[name=surgery]").val($("#surgery"+id).html());
		$("select[name=injury]").val($("#injury"+id).html());
		$("select[name=sickness]").val($("#sickness"+id).html());
	})
</script>

<!-- new section -->

