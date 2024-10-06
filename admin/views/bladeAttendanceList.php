<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Attendances","قائمة جداول الحضور") ?></h6>
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
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $attendance = selectDB('attendance',"`status` = '0' ORDER BY `id` DESC") ){
			for( $i = 0; $i < sizeof($attendance); $i++ ){
				$counter = $i + 1;
				$class = selectDB("sessions","`id` = '{$attendance[$i]["sessionId"]}'");
				$trainer = selectDB("employees","`id` = '{$attendance[$i]["trainerId"]}'");
				?>
				<tr>
				<td><?php echo str_pad($counter, 2, "0", STR_PAD_LEFT) ?></td>
				<td><?php echo $attendance[$i]["date"] ?></td>
				<td><?php echo $trainer ?></td>
				<td><?php echo direction($class[0]["enTitle"],$class[0]["arTitle"]) ?></td>
				<td class="text-nowrap">
					<a href="<?php echo "?v={$_GET["v"]}&delId={$branches[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Show attendance","اظهار الحضور") ?>"><i class="fa fa-plus text-primary"></i>
					</a>	
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