<?php 
if( isset($_POST["sessionId"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('attendance', $_POST) ){
			header("LOCATION: ?v=ListOfClasses&id={$_POST["studentId"]}");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('attendance', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=ListOfClasses&id={$_POST["studentId"]}");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Sessions","الكلاسات") . " : " . $empUsername ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			    <label><?php echo direction("Session","الكلاس") ?></label>
				<select name="id" class="form-control">
					<?php
						if( $sessions = selectDB('sessions',"`status` = '0' AND `hidden` = '0'") ){
							for( $i = 0; $i < sizeof($sessions); $i++ ){
								echo "<option value='{$sessions[$i]["id"]}'>".direction($sessions[$i]["enTitle"],$sessions[$i]["arTitle"])."</option>";
							}
						}
					?>
				</select>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>

<from method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="trainerId" value="<?php echo $userID ?>">
<input type="hidden" name="sessionId" value="<?php echo $_POST["id"] ?>">

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
<button class="btn btn-primary"><?php echo direction("Submit","أرسل") ?></button>
<div class="table-wrap mt-40">
<div class="table-responsive">
    
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th><?php echo direction("Name","الإسم") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( isset($_POST["id"]) && !empty($_POST["id"]) && $students = selectDBNew('studentMore',[$_POST["id"]],"`sessionId` = ? AND `total` > 0","") ){
			if( $attendance = selectDBNew('attendance',[$userID,$_POST["id"],date("Y-m-d")],"`tainerId` = ? AND `sessionId` = ? AND `date` LIKE '%?%'","") ){
				$attendance = $attendance[0]["attendance"];
				$studentList = $attendance[0]["studentList"];
			}else{
				$attendance = [];
				$studentList = [];
				$checkedAttended = "";
				$checkedAbsent = "";
			}
			for( $i = 0; $i < sizeof($students); $i++ ){
				$counter = $i + 1;
                $student = selectDB('students',"`id` = '{$students[$i]["studentId"]}' ");
				$key = array_search($student[0]["id"], $studentList);
				$checkedAttended = ( $attendance[$key] == 1 ) ? "checked" : "";
				$checkedAbsent = ( $attendance[$key] == 0 ) ? "checked" : "";
				?>
				<tr>
				<td style="text-wrap: wrap;"><?php echo $student[0]["fullName"] ?></td>
				<td class="text-nowrap">
					<input type="hidden" name="studentList[]" value="<?php echo $student[0]["id"] ?>" >
					<input type="radio" name="attendance[]" value="1" <?php echo $checkedAttended ?> >Yes
					<input type="radio" name="attendance[]" value="0" <?php echo $checkedAbsent ?> >No
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
</from>
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