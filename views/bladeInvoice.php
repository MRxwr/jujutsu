
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

<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <img src="/api/placeholder/100/100" alt="Company Logo" class="logo">
        </div>
        <div class="col-md-6 text-md-right">
            <h2 class="text-primary"><?php echo $settingsTitle ?></h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-4">Invoice</h3>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Invoice ID:</strong> <span id="invoiceId">INV-001</span></p>
                    <p><strong>Client Name:</strong> <span id="clientName">John Doe</span></p>
                    <p><strong>Client Phone:</strong> <span id="clientPhone">+1 123-456-7890</span></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Session Title:</strong> <span id="sessionTitle">Consultation</span></p>
                    <p><strong>Price:</strong> <span id="price">$100.00</span></p>
                </div>
            </div>

            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="agreeTerms">
                <label class="form-check-label" for="agreeTerms">
                    I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a>
                </label>
            </div>

            <button id="paymentBtn" class="btn btn-primary btn-lg mt-4" disabled>Continue to Payment</button>

            <div id="paymentStatus" class="mt-3" style="display: none;"></div>
        </div>
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add your terms and conditions text here -->
                <p>These are the terms and conditions for our service...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<footer class="text-center">
    <p>&copy; 2024 Your Company Name. All rights reserved.</p>
</footer>