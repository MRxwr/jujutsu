<?php 
if( isset($_POST["sessionId"]) ){
	unset($_POST["myTable_length"]);
	$_POST["studentList"] = json_encode($_POST["studentList"]);
	$_POST["attendance"] = json_encode($_POST["attendance"]);
	if ( $seesion = selectDBNew('attendance',[$userID,$_POST["sessionId"],date("Y-m-d")],"`trainerId` = ? AND `sessionId` = ? AND `date` LIKE CONCAT('%',?,'%')","") ){
		if( updateDB('attendance', $_POST, "`id` = '{$seesion[0]["id"]}'") ){
			header("LOCATION: ?v=ListOfClasses");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( insertDB('attendance', $_POST) ){
			header("LOCATION: ?v=ListOfClasses");
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

<form method="POST" action="" enctype="multipart/form-data">
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
			if( $attendance = selectDB('attendance',"`trainerId` = '{$userID}' AND `sessionId` = '{$_POST["id"]}' AND `date` LIKE '%".date("Y-m-d")."%'") ){
				$attendance = json_decode($attendance[0]["attendance"],true);
				$studentList = json_decode($attendance[0]["studentList"],true);
			}else{
				$attendance = [];
				$studentList = [];
				$checkedAttended = "";
				$checkedAbsent = "";
			}
			for( $i = 0; $i < sizeof($students); $i++ ){
				$counter = $i + 1;
                $student = selectDBNew('students',[$students[$i]["studentId"]],"`id` = ?","");
				if ( $key = array_search($student[0]["id"], $studentList) ){
					$checkedAttended = ( $attendance[$key] == 1 ) ? "checked" : "";
					$checkedAbsent = ( $attendance[$key] == 0 ) ? "checked" : "";
				}else{
					$checkedAttended = "";
					$checkedAbsent = "";
				}
				
				?>
				<tr>
				<td style="text-wrap: wrap;"><?php echo $student[0]["fullName"] ?></td>
				<td class="text-nowrap">
					<input type="hidden" name="studentList[]" value="<?php echo $student[0]["id"] ?>" >
					<input type="radio" name="attendance[]" value="1" <?php echo $checkedAttended ?> >Yes
					<input type="radio" name="attendance[]" value="0" <?php echo $checkedAbsent ?> >No
				<div style="display:none">  
					<label id="fullName<?php echo $student[0]["id"]?>"><?php echo $student[0]["fullName"] ?></label>
					<label id="mobile<?php echo $student[0]["id"]?>"><?php echo $student[0]["mobile"] ?></label>
					<label id="civilId<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["civilId"] ?></label>					
					<label id="dateOfBirth<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["dateOfBirth"] ?></label>					
					<label id="subscription<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["subscription"] ?></label>					
					<label id="nationalityId<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["nationalityId"] ?></label>					
					<label id="beltId<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["beltId"] ?></label>			
					<label id="strap<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["strap"] ?></label>			
					<label id="maritalStatus<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["maritalStatus"] ?></label>			
					<label id="livesWith<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["livesWith"] ?></label>			
					<label id="surgery<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["surgery"] ?></label>			
					<label id="mentionSurgery<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["mentionSurgery"] ?></label>			
					<label id="injury<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["injury"] ?></label>			
					<label id="mentionInjury<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["mentionInjury"] ?></label>			
					<label id="sickness<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["sickness"] ?></label>			
					<label id="mentionSickness<?php echo $student[0]["id"] ?>" ><?php echo $student[0]["mentionSickness"] ?></label>			
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