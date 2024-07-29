<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('faq',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=FAQ");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('faq',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=FAQ");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('faq',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=FAQ");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB('faq',array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=FAQ");
}

if( isset($_POST["enQuestion"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('faq', $_POST) ){
			header("LOCATION: ?v=FAQ");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('faq', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=FAQ");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Question Details","تفاصيل السؤال") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Question","السؤال بالانجليزي") ?></label>
			<input type="text" name="enQuestion" class="form-control" required>
			</div>
			
			<div class="col-md-6">
			<label><?php echo direction("Arabic Question","السؤال بالعربي") ?></label>
			<input type="text" name="arQuestion" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Answer","الجواب بالانجليزي") ?></label>
			<input type="text" name="enAnswer" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Answer","الجواب بالعربي") ?></label>
			<input type="text" name="arAnswer" class="form-control" required>
			</div>
			
			<div class="col-md-6" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="hidden" value="2">
			<input type="hidden" name="update" value="0">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>
				
				<!-- Bordered Table -->
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of FAQ","قائمة الأسئلة الشائعة") ?></h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
<button class="btn btn-primary">
<?php echo direction("Submit rank","أرسل الترتيب") ?>
</button>  
<div class="table-wrap mt-40">
<div class="table-responsive">
	<table class="table display responsive product-overview mb-30" id="myTable">
		<thead>
		<tr>
		<th>#</th>
		<th><?php echo direction("Question","السؤال") ?></th>
		<th><?php echo direction("Answer","الجواب") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $FAQ = selectDB("faq","`status` = '0' ORDER BY `rank` ASC") ){
            for( $i = 0; $i < sizeof($FAQ); $i++ ){
            $counter = $i + 1;
            if ( $FAQ[$i]["hidden"] == 2 ){
                $icon = "fa fa-eye";
                $link = "?v={$_GET["v"]}&show={$FAQ[$i]["id"]}";
                $hide = direction("Show","إظهار");
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?v={$_GET["v"]}&hide={$FAQ[$i]["id"]}";
                $hide = direction("Hide","إخفاء");
            }
		?>
		<tr>
		<td>
		    <input name="rank[]" class="form-control" type="number" value="<?php echo $counter ?>">
		    <input name="id[]" class="form-control" type="hidden" value="<?php echo $FAQ[$i]["id"] ?>">
		</td>
		<td><?php echo direction($FAQ[$i]["enQuestion"],$FAQ[$i]["arQuestion"]) ?></td>
		<td><?php echo direction($FAQ[$i]["enAnswer"],$FAQ[$i]["arAnswer"]) ?></td>
		<td class="text-nowrap">
            <a id="<?php echo $FAQ[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo "?v={$_GET["v"]}&delId={$FAQ[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
            </a>
            <div style="display:none"><label id="enQuestion<?php echo $FAQ[$i]["id"]?>"><?php echo $FAQ[$i]["enQuestion"] ?></label></div>
            <div style="display:none"><label id="arQuestion<?php echo $FAQ[$i]["id"]?>"><?php echo $FAQ[$i]["arQuestion"] ?></label></div>
            <div style="display:none"><label id="enAnswer<?php echo $FAQ[$i]["id"]?>"><?php echo $FAQ[$i]["enAnswer"] ?></label></div>
            <div style="display:none"><label id="arAnswer<?php echo $FAQ[$i]["id"]?>"><?php echo $FAQ[$i]["arAnswer"] ?></label></div>
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
<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
		var enQuestion = $("#enQuestion"+id).html();
		var arQuestion = $("#arQuestion"+id).html();
		var enAnswer = $("#enAnswer"+id).html();
		var arAnswer = $("#arAnswer"+id).html();
		$("input[name=enQuestion]").val(enQuestion);
		$("input[name=arQuestion]").val(arQuestion);
		$("input[name=enAnswer]").val(enAnswer);
		$("input[name=arAnswer]").val(arAnswer);
	})
</script>