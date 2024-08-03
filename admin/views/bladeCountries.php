<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('cities',array('status'=> '2'),"`CountryName` LIKE '%{$_GET["hide"]}%'") ){
		header("LOCATION: ?v=Countries");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('cities',array('status'=> '0'),"`CountryName` LIKE '%{$_GET["show"]}'%") ){
		header("LOCATION: ?v=Countries");
	}
}
?>		
				<!-- Bordered Table -->
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Countries","قائمة البلدان") ?></h6>
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
		<th><?php echo direction("Country","البلد") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $cities = selectDB('cities',"`id` != '0' GROUP BY `CountryName` ORDER BY `CountryName` ASC") ){
			for( $i = 0; $i < sizeof($cities); $i++ ){
				$counter = $i + 1;
				if ( $cities[$i]["status"] == 2 ){
					$icon = "fa fa-eye";
					$link = "?v={$_GET["v"]}&show={$cities[$i]["CountryName"]}";
					$hide = direction("Show","إظهار");
				}else{
					$icon = "fa fa-eye-slash";
					$link = "?v={$_GET["v"]}&hide={$cities[$i]["CountryName"]}";
					$hide = direction("Hide","إخفاء");
				}
				?>
				<tr>
				<td><?php echo $cities[$i]["CountryName"] ?></td>
				<td class="text-nowrap">
					<a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
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