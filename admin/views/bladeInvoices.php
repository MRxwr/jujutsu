<?php 
if( isset($_GET["id"]) && !empty($_GET["id"]) ){
	$id = $_GET["id"];
    $_POST["status"] = $_GET["status"];
    if( updateDB('invoices', $_POST, "`id` = '{$id}'") ){
        header("LOCATION: ?v=Invoices");
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
    </script>
    <?php
    }
}
?>
<div class="row">			

<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Invoices","قائمة الفواتير") ?></h6>
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
		<th><?php echo direction("Date","التاريخ") ?></th>
		<th><?php echo direction("Invoice#","رقم الفاتورة") ?></th>
		<th><?php echo direction("Name","الاسم") ?></th>
		<th><?php echo direction("Session","الكلاس") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("Status","الحالة") ?></th>
		<th><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $Invoices = selectDBNew('invoices',[0],"`id` != ?","`id` DESC") ){
			for( $i = 0; $i < sizeof($Invoices); $i++ ){
				$session = selectDB('sessions',"`id` = '{$Invoices[$i]["sessionId"]}'");
				$student = selectDB('students',"`id` = '{$Invoices[$i]["studentId"]}'");
                if( $Invoices[$i]["status"] == 1 ){
                    $status = direction("Paid","مدفوعة");
                }elseif( $Invoices[$i]["status"] == 2 ){
                    $status = direction("Cancelled","ملغية");
                }else{
                    $status = direction("Pending","قيد الانتظار");
                }
				?>
				<tr>
				<td><?php echo substr($Invoices[$i]["date"],0,10) ?></td>
				<td><a href="?v=InvoiceDetails&id=<?php echo $Invoices[$i]["id"] ?>" target="_blank"><?php echo str_pad($Invoices[$i]["id"], 5, '0', STR_PAD_LEFT) ?></td>
				<td><?php echo $student[0]["fullName"] ?></td>
				<td><?php echo direction("{$session[0]["enTitle"]}",$session[0]["arTitle"]) ?></td>
				<td><?php echo $Invoices[$i]["price"] ?></td>
				<td><?php echo $status ?></td>		
				</td>
                <td class="text-nowrap">
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=0" ?>" style="align-content: center;" class="btn btn-default btn-xs"><?php echo direction("Pending","قيد الانتظار") ?></a>
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=1" ?>" style="align-content: center;" class="btn btn-success btn-xs"><?php echo direction("Paid","مدفوعة") ?></a>
					<a href="<?php echo "?v=Invoices&id={$Invoices[$i]["id"]}&status=2" ?>" style="align-content: center;" class="btn btn-danger btn-xs"><?php echo direction("Cancelled","ملغية") ?></a>
                    <div style="display:none">
                        <label><?php echo $student[0]["mobile"] ?></label>
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