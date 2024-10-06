<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("Class Notes","ملاحظات الكلاسات") ?></h6>
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
		<th>#</th>
		<th><?php echo direction("Date","التاريخ") ?></th>
        <th><?php echo direction("Trainer","المدرب") ?></th>
        <th><?php echo direction("Class","الكلاس") ?></th>
		<th><?php echo direction("Note","الملاحظة") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $notes = selectDB('class_notes',"`status` = '0' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($notes); $i++ ){
				$counter = $i + 1;
                $class = selectDB('sessions',"`id` = '{$notes[$i]['sessionId']}'");
                $trainer = selectDB('employees',"`id` = '{$notes[$i]['trainerId']}'");
                ?>
				<tr>
				<td><?php echo str_pad($counter,2,"0",STR_PAD_LEFT) ?></td>
				<td><?php echo $notes[$i]["date"] ?></td>
                <td><?php echo $trainer[0]["fullName"] ?></td>
                <td><?php echo direction($class[0]["enTitle"],$class[0]["arTitle"]) ?></td>
				<td><?php echo $notes[$i]["note"] ?></td>
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