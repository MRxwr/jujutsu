<?php 
if( isset($_GET["hide"]) && !empty($_GET["hide"]) ){
	if( updateDB('package',array('hidden'=> '2'),"`id` = '{$_GET["hide"]}'") ){
		header("LOCATION: ?v=Package");
	}
}

if( isset($_GET["show"]) && !empty($_GET["show"]) ){
	if( updateDB('package',array('hidden'=> '1'),"`id` = '{$_GET["show"]}'") ){
		header("LOCATION: ?v=Package");
	}
}

if( isset($_GET["delId"]) && !empty($_GET["delId"]) ){
	if( updateDB('package',array('status'=> '1'),"`id` = '{$_GET["delId"]}'") ){
		header("LOCATION: ?v=Package");
	}
}

if( isset($_POST["updateRank"]) ){
	for( $i = 0; $i < sizeof($_POST["rank"]); $i++){
		updateDB('package',array("rank"=>$_POST["rank"][$i]),"`id` = '{$_POST["id"][$i]}'");
	}
	header("LOCATION: ?v=Package");
}

if( isset($_POST["enTitle"]) ){
	$id = $_POST["update"];
	unset($_POST["update"]);
	if ( $id == 0 ){
		if( insertDB('package', $_POST) ){
			header("LOCATION: ?v=Package");
		}else{
		?>
		<script>
			alert("Could not process your request, Please try again.");
		</script>
		<?php
		}
	}else{
		if( updateDB('package', $_POST, "`id` = '{$id}'") ){
			header("LOCATION: ?v=Package");
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
	<h6 class="panel-title txt-dark"><?php echo direction("Link Details","تفاصيل الرابط") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
			<div class="col-md-6">
			<label><?php echo direction("English Title","العنوان الإنجليزي") ?></label>
			<input type="text" name="enTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Title","العنوان العربي") ?></label>
			<input type="text" name="arTitle" class="form-control" required>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("English Details","التفاصيل بالعربي") ?></label>
			<textarea name="enDetails" id="enDetails" class="tinymce"></textarea>
			</div>

            <div class="col-md-6">
			<label><?php echo direction("Arabic Details","التفاصيل بالعربي") ?></label>
			<textarea name="arDetails" id="arDetails" class="tinymce"></textarea>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Period","المدة") ?></label>
			<input type="number" step="1" min="0" name="period" class="form-control" required>
			</div>

			<div class="col-md-3">
			<label><?php echo direction("Price","السعر") ?></label>
			<input type="number" step="0.01" min="0" name="price" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Discount","خصم") ?></label>
			<input type="number" min="0" step="0.01" name="discount" class="form-control" required>
			</div>
			
			<div class="col-md-3">
			<label><?php echo direction("Discount Type","نوع الخصم") ?></label>
			<select name="discountType" class="form-control">
				<option value="1"><?php echo direction("Fixed","ثابت") ?></option>
				<option value="2"><?php echo direction("Percentage","نسبة مئوية") ?></option>
			</select>
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
<form method="post" action="">
<input name="updateRank" type="hidden" value="1">
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark"><?php echo direction("List of Links","قائمة الروابط") ?></h6>
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
		<th><?php echo direction("English Title","العنوان بالإنجليزي") ?></th>
		<th><?php echo direction("Arabic Title","العنوان بالعربي") ?></th>
		<th><?php echo direction("Period","المدة") ?></th>
		<th><?php echo direction("Price","السعر") ?></th>
		<th><?php echo direction("Discount","خصم") ?></th>
		<th class="text-nowrap"><?php echo direction("Actions","الخيارات") ?></th>
		</tr>
		</thead>
		
		<tbody>
		<?php 
		if( $banners = selectDB('package',"`status` = '0' ORDER BY `rank` ASC") ){
            for( $i = 0; $i < sizeof($banners); $i++ ){
            $counter = $i + 1;
            if ( $banners[$i]["hidden"] == 2 ){
                $icon = "fa fa-eye";
                $link = "?v={$_GET["v"]}&show={$banners[$i]["id"]}";
                $hide = direction("Show","إظهار");
            }else{
                $icon = "fa fa-eye-slash";
                $link = "?v={$_GET["v"]}&hide={$banners[$i]["id"]}";
                $hide = direction("Hide","إخفاء");
            }
            $discountType = $banners[$i]["discountType"] == 1 ? "KWD" : "%";
		?>
            <tr>
            <td>
            <input name="rank[]" class="form-control" type="number" value="<?php echo str_pad($counter,2,"0",STR_PAD_LEFT) ?>">
            <input name="id[]" class="form-control" type="hidden" value="<?php echo $banners[$i]["id"] ?>">
            </td>
            <td id="enTitle<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["enTitle"] ?></td>
            <td id="arTitle<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["arTitle"] ?></td>
            <td id="period<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["period"] ?></td>
            <td id="price<?php echo $banners[$i]["id"]?>" ><?php echo $banners[$i]["price"] ?></td>
            <td><?php echo $banners[$i]["discount"] . $discountType ?></td>
            <td class="text-nowrap">
            
            <a id="<?php echo $banners[$i]["id"] ?>" class="mr-25 edit" data-toggle="tooltip" data-original-title="<?php echo direction("Edit","تعديل") ?>"> <i class="fa fa-pencil text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo $link ?>" class="mr-25" data-toggle="tooltip" data-original-title="<?php echo $hide ?>"> <i class="<?php echo $icon ?> text-inverse m-r-10"></i>
            </a>
            <a href="<?php echo "?v={$_GET["v"]}&delId={$banners[$i]["id"]}" ?>" data-toggle="tooltip" data-original-title="<?php echo direction("Delete","حذف") ?>"><i class="fa fa-close text-danger"></i>
            </a>
            <div style="display:none"><label id="en_Details<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["enDetails"] ?></label></div>
            <div style="display:none"><label id="ar_Details<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["arDetails"] ?></label></div>
            <div style="display:none"><label id="discountType<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["discountType"] ?></label></div>
            <div style="display:none"><label id="discount<?php echo $banners[$i]["id"]?>"><?php echo $banners[$i]["discount"] ?></label></div>
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

<!-- Tinymce JavaScript -->
<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
<!-- Tinymce Wysuhtml5 Init JavaScript -->
<script src="dist/js/tinymce-data.js"></script>

<script>
	$(document).on("click",".edit", function(){
		var id = $(this).attr("id");
        $("input[name=update]").val(id);
		var enTitle = $("#enTitle"+id).html();
		var arTitle = $("#arTitle"+id).html();
        var enDetails = $("#en_Details"+id).html();
        var arDetails = $("#ar_Details"+id).html();
        var discountType = $("#discountType"+id).html();
        var discount = $("#discount"+id).html();
        var price = $("#price"+id).html();
        var period = $("#period"+id).html();
		$("input[name=enTitle]").val(enTitle).focus();
		$("input[name=arTitle]").val(arTitle);
        tinymce.get('enDetails').setContent(enDetails);
        tinymce.get('arDetails').setContent(arDetails);
        $("select[name=discountType]").val(discountType);
        $("input[name=discount]").val(discount);
        $("input[name=price]").val(price);
        $("input[name=period]").val(period);
	})
</script>