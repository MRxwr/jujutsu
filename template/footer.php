<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#agreeTerms').change(function() {
                $('#paymentBtn').prop('disabled', !this.checked);
            });

            $('#paymentBtn').click(function() {
                // Simulate payment process
                setTimeout(function() {
                    const success = Math.random() < 0.8; // 80% success rate
                    const $status = $('#paymentStatus');
                    if (success) {
                        $status.html('<div class="alert alert-success">Payment successful!</div>').show();
                    } else {
                        $status.html('<div class="alert alert-danger">Payment failed. Please try again.</div>').show();
                    }
                }, 2000);
            });
        });
    </script>
</body>
</html>

    