<?php 
if( isset($_POST["update"]) && !empty($_POST["update"]) ){
	unset($_POST["update"]);
    if (is_uploaded_file($_FILES['logo']['tmp_name'])) {
        $_POST["logo"] = uploadImageBanner($_FILES['logo']['tmp_name']);
    }
    if( updateDB('settings', $_POST, "`id` = '1'") ){
        header("LOCATION: ?v=Settings");die();
    }else{
    ?>
    <script>
        alert("Could not process your request, Please try again.");
        // refresh page after 2 seconds and go to this location
        setTimeout(function(){window.location.href = '?v=Settings';}, 2000);
    </script>
    <?php
    }
}else{
    $settings = selectDB('settings', "`id` = '1' ");
}
?>
<div class="row">			
<div class="col-sm-12">
<div class="panel panel-default card-view">
<div class="panel-heading">
<div class="pull-left">
	<h6 class="panel-title txt-dark"><?php echo direction("Settings Details","تفاصيل الاعدادات") ?></h6>
</div>
	<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div class="panel-body">
	<form class="" method="POST" action="" enctype="multipart/form-data">
		<div class="row m-0">
            
			<div class="col-md-3">
                <label><?php echo direction("Title","العنوان") ?></label>
                <input type="text" name="title" class="form-control" value="<?php echo $settings[0]["title"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Og Description","تفاصيل الصفحة") ?></label>
                <input type="text" name="OgDescription" class="form-control" value="<?php echo $settings[0]["OgDescription"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Email","البريد الالكتروني") ?></label>
                <input type="text" name="email" class="form-control" value="<?php echo $settings[0]["email"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Cookie","الكوكي") ?></label>
                <input type="text" name="cookie" class="form-control" value="<?php echo $settings[0]["cookie"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Website","الموقع") ?></label>
                <input type="text" name="website" class="form-control" value="<?php echo $settings[0]["website"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Payment API Key","المفتاح الخاص بالدفع") ?></label>
                <input type="text" name="PaymentAPIKey" class="form-control" value="<?php echo $settings[0]["PaymentAPIKey"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Version","الاصدار") ?></label>
                <input type="text" name="version" class="form-control" value="<?php echo $settings[0]["version"] ?>">
			</div>

			<div class="col-md-3">
                <label><?php echo direction("Firebase Key","المفتاح الخاص بالفيربيس") ?></label>
                <input type="text" name="firebaseKey" class="form-control" value="<?php echo $settings[0]["firebaseKey"] ?>">
			</div>

			<div class="col-md-6">
                <label><?php echo direction("Google Analytics","تحليلات جوجل") ?></label>
                <textarea name="google" class="form-control" style="height:300px;width:100%"><?php echo $settings[0]["google"] ?></textarea>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Pixil Analytics","تحليلات بكسيل") ?></label>
                <textarea name="pixil" class="form-control" style="height:300px;width:100%"><?php echo $settings[0]["pixil"] ?></textarea>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Privacy Policy","سياسة الخصوصية") ?></label>
                <textarea name="enPolicy" class="tinymce"><?php echo $settings[0]["enPolicy"] ?></textarea>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Privacy Policy Arabic","سياسة الخصوصية العربية") ?></label>
                <textarea name="arPolicy" class="tinymce"><?php echo $settings[0]["arPolicy"] ?></textarea>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Terms & Conditions","الشروط والاحكام") ?></label>
                <textarea name="enTerms" class="tinymce"><?php echo $settings[0]["enTerms"] ?></textarea>
			</div>

            <div class="col-md-6">
                <label><?php echo direction("Terms & Conditions Arabic","الشروط والاحكام العربية") ?></label>
                <textarea name="arTerms" class="tinymce"><?php echo $settings[0]["arTerms"] ?></textarea>
			</div>

			<div class="col-md-6">
                <label><?php echo direction("Logo","الشعار") ?></label>
                <input type="file" name="logo" class="form-control">
			</div>

			<div class="col-md-6">
                <img src="../logos/<?php echo $settings[0]["logo"] ?>" width="200px" height="200px">
			</div>
            
			<div class="col-md-12" style="margin-top:10px">
			<input type="submit" class="btn btn-primary" value="<?php echo direction("Submit","أرسل") ?>">
			<input type="hidden" name="update" value="1">
			</div>
		</div>
	</form>
</div>
</div>
</div>
</div>

<!-- Tinymce JavaScript -->
<script src="../vendors/bower_components/tinymce/tinymce.min.js"></script>
<!-- Tinymce Wysuhtml5 Init JavaScript -->
<script src="dist/js/tinymce-data.js"></script>