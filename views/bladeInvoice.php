<?php
if( isset($_GET["requested_order_id"]) && !empty($_GET["requested_order_id"]) && $invoice = selectDBNew("invoices",[$_GET["requested_order_id"]],"`gatewayId` = ?","") ){
    $student = selectDB("students","`id` = {$invoice[0]["studentId"]}");
    $session = selectDB("sessions","`id` = {$invoice[0]["sessionId"]}");
    if( $invoice[0]["status"] == 0 ){
        $status = direction("Pending Payment" ,"قيد الانتظار");
        $styleDisplay = "display: none;";
        $invoiceLink = "";
    }elseif( $invoice[0]["status"] == 1 ){
        $status = "<div class='alert alert-success'>".direction("Paid successfully","مدفوعة بنجاح")."</div>";
        $styleDisplay = "";
        $invoiceLink = "";
    }elseif( $invoice[0]["status"] == 2 ){
        $status = "<div class='alert alert-danger'>".direction("Payment failed","فشل الدفع")."</div>";;
        $styleDisplay = "";
        $invoiceLink = "";
    }
}else{
    ?>
    <script>
        var alert = <?php echo direction("Could not process your request, Please try again.","لم يتم معالجة الطلب، الرجاء المحاولة مرة اخرى."); ?>
        alert(alert);
        window.location = "?v=Home";
    </script>
    <?php
}
?>
<style>
    body {
        background-color: #f0f8ff;
        color: #333;
        font-family: 'Arial', sans-serif;
    }
    .logo {
        max-width: 100px;
        height: auto;
    }
    .container {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        margin-top: 50px;
        margin-bottom: 50px;
    }
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
    }
    .card-title {
        color: #007bff;
        font-weight: bold;
    }
    .btn-primary {
        background-color: #ffa500;
        border-color: #ffa500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover, .btn-primary:focus {
        background-color: #ff8c00;
        border-color: #ff8c00;
        box-shadow: 0 0 10px rgba(255, 165, 0, 0.5);
    }
    .form-check-label a {
        color: #007bff;
    }
    footer {
        background-color: #007bff;
        color: #ffffff;
        padding: 20px 0;
        position: absolute;
        bottom: 0;
        width: 100%;
    }
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }
    }
</style>

<div class="container" style="direction:<?php echo direction("ltr","rtl") ?>">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <img src="logos/<?php echo $settingslogo ?>" alt="Company Logo" class="logo">
        </div>
        <div class="col-md-6 text-md-right">
            <h2 class="text-primary"><?php echo $settingsTitle ?></h2>
        </div>
    </div>

    <div class="card" style="<?php echo direction("","text-align: right;") ?>">
        <div class="card-body">
            <h3 class="card-title mb-4"><?php echo direction("Invoice","فاتورة") ?></h3>
            <div class="row">
                <div class="col-md-6">
                    <p><strong><?php echo direction("Invoice ID","رقم الفاتورة")?>:</strong> <span id="invoiceId"><?php echo $invoice[0]["id"] ?></span></p>
                    <p><strong><?php echo direction("Client Name","اسم العميل")?>:</strong> <span id="clientName"><?php echo $student[0]["fullName"] ?></span></p>
                    <p><strong><?php echo direction("Client Phone","رقم الهاتف")?>:</strong> <span id="clientPhone"><?php echo $student[0]["mobile"] ?></span></p>
                </div>
                <div class="col-md-6">
                    <p><strong><?php echo direction("Session Title","عنوان الجلسة") ?>:</strong> <span id="sessionTitle"><?php echo direction($session[0]["enTitle"],$session[0]["arTitle"]) ?></span></p>
                    <p><strong><?php echo direction("Price","القيمه") ?>:</strong> <span id="price"><?php echo direction("{$invoice[0]["price"]} -/KD","{$invoice[0]["price"]} -/دك") ?></span></p>
                </div>
            </div>

            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="agreeTerms">
                <label class="form-check-label mr-4" for="agreeTerms">
                    <?php echo direction("I agree to the","أوافق على") ?> <a href="#" data-toggle="modal" data-target="#termsModal"><?php echo direction("Terms and Conditions","الشروط والأحكام") ?></a>
                </label>
            </div>

            <?php 
            if ( isset($invoiceLink) && !empty($invoiceLink) ){
                ?>
                <a id="paymentBtn" href="<?php echo $invoiceLink ?>" class="btn btn-primary btn-lg mt-4" ><?php echo direction("Pay Now","ادفع الان") ?></a>
                <?php
            }
            ?>

            <div id="paymentStatus" class="mt-3" style="<?php echo $styleDisplay ?>">
                <?php echo $status ?>
            </div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel"><?php echo direction("Terms and Conditions","الشروط والأحكام") ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your terms and conditions text here -->
                <p><?php echo $termsAndConditionsText ?></p>
            </div>
        </div>
    </div>
</div>

<footer class="text-center">
    <p>&copy; 2024 Your Company Name. All rights reserved.</p>
</footer>