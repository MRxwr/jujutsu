<?php 
if( isset($_POST["sessionId"]) ){
	unset($_POST["myTable_length"]);
	$_POST["studentList"] = json_encode($_POST["studentList"]);
	$_POST["attendance"] = json_encode($_POST["attendance"]);
	if ( $session = selectDBNew('attendance',[$userID,$_POST["sessionId"],date("Y-m-d")],"`trainerId` = ? AND `sessionId` = ? AND DATE(`date`) = ?","") ){
		if( updateDB('attendance', $_POST, "`id` = '{$session[0]["id"]}'") ){
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
			<div class="col-md-6 pb-5">
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
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Show","اعرض") ?>">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>

<form method="POST" action="" enctype="multipart/form-data">
<input type="hidden" name="trainerId" value="<?php echo $userID ?>">
<input type="hidden" name="sessionId" value="<?php echo ( isset($_POST["id"]) && !empty($_POST["id"]) ) ? $_POST["id"] : "" ?>">

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
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( isset($_POST["id"]) && !empty($_POST["id"]) && $students = selectDBNew('studentMore',[$_POST["id"]],"`sessionId` = ? AND `total` > 0","") ){
			if( $attendances = selectDBNew('attendance',[$userID,$_POST["id"],date("Y-m-d")],"`trainerId` = ? AND `sessionId` = ? AND DATE(`date`) = ?","") ){
				$attendance = json_decode($attendances[0]["attendance"],true);
				$studentList = json_decode($attendances[0]["studentList"],true);
			}else{
				$attendance = [];
				$studentList = [];
				$checkedAttended = "";
				$checkedAbsent = "";
			}
			for( $i = 0; $i < sizeof($students); $i++ ){
				$notes = "";
				$counter = $i + 1;
                $student = selectDBNew('students',[$students[$i]["studentId"]],"`id` = ?","");
				if ( ($key = array_search($student[0]["id"], $studentList)) !== false ) {
					$checkedAttended = ( $attendance[$key] == 1 ) ? "checked" : "";
					$checkedAbsent = ( $attendance[$key] == 0 ) ? "checked" : "";
				}else{
					$checkedAttended = "";
					$checkedAbsent = "";
				}
				$notes .= ($student[0]["hidden"] == 2 ) ? " - " . direction("Suspended","إيقاف") : "";
				$notes .= (!empty($student[0]["mentionInjury"])) ? " - {$student[0]["mentionSurgery"]}" : "";
				$notes .= (!empty($student[0]["mentionInjury"])) ? " - {$student[0]["mentionInjury"]}" : "";
				$notes .= (!empty($student[0]["mentionSickness"])) ? " - {$student[0]["mentionSickness"]}" : "";
				?>
				<tr>
				<td style="text-wrap: wrap;"><?php echo $student[0]["fullName"] . $notes ?></td>
				<td class="text-nowrap">
					<input type="hidden" name="studentList[]" value="<?php echo $student[0]["id"] ?>" >
					<input type="radio" name="attendance[]" value="1" <?php echo $checkedAttended ?> >Yes
					<input type="radio" name="attendance[]" value="0" <?php echo $checkedAbsent ?> >No
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
<div class="row pt-5 pb-5 text-center">
	<div class="col-md-6 pb-5"><input type="text" name="note" class="form-control" placeholder="<?php echo direction("Notes","ملاحظات") ?>"></div>
	<div class="col-md-6"><button class="btn btn-primary" style="width: 100%;"><?php echo direction("Submit","أرسل") ?></button></div>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</form>
</div>