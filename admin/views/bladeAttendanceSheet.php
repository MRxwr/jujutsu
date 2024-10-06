<?php 
if( $class = selectDBNew("sessions",[$_GET["sessionId"]],"`id` = ?","") ){

}else{
    header("LOCATION: ?v=AttendanceList");die();
}

?>
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Students","قائمة الطلاب") . " : " . date("Y-m-d") . " - " . direction($class[0]["enTitle"],$class[0]["arTitle"])?></h6>
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
		if( isset($_GET["id"]) && !empty($_GET["id"]) && $students = selectDBNew('studentMore',[$_GET["id"]],"`sessionId` = ? AND `total` > 0","") ){
			if( $attendances = selectDBNew('attendance',[$_GET["id"]],"`id` = ?","") ){
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
               if ( $student = selectDBNew('students',[$students[$i]["studentId"]],"`id` = ? AND `hidden` = 0 AND `status` = 0","") ){
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
		}
		?>
		</tbody>
		
	</table>
    
</div>
</div>
</div>
<div class="clearfix"></div>
</div>
</div>
</div>
</div>