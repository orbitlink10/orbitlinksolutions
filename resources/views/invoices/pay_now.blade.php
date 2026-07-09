<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <style>
        .checkout-page {
            margin-top: 100px;
        }
        .checkout__payment {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }
        .checkout__payment__title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        .payment-summary {
            margin-bottom: 1.5rem;
            font-size: 1rem;
            line-height: 1.5;
        }
        .payment-summary strong {
            font-size: 1.1rem;
        }
        #dynamic-content3, #result {
            font-size: 1rem;
            font-weight: bold;
        }
        .btn-primary, .btn-success {
            font-size: 1rem;
            padding: 0.5rem 1.5rem;
        }
        .back-to-invoice {
            margin-top: 20px;
            text-align: center;
        }
        .back-to-invoice a {
            font-size: 1rem;
            text-decoration: none;
            color: #027333;
            font-weight: bold;
        }
        .back-to-invoice a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Start Checkout Page -->
    <section class="checkout-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="your_order">
                        <h2 class="text-center">Process Your Payment</h2>
                        <div class="checkout__payment p-4 rounded">
                            <h3 class="checkout__payment__title text-center">MPESA Payment</h3>
                            <p class="payment-summary text-center">
                                <strong>Amount:</strong> KES 
                                {{ number_format($order->items->reduce(function ($carry, $item) {
                                    return $carry + $item->amount;
                                }, 0), 2) }}<br>
                                <strong>Pay To:</strong> {{ get_option('site_name') }}
                            </p>
                            <p class="text-center">
                                Enter your phone number to receive an MPESA STK push or Lipa Na MPESA Paybill.
                            </p>
                            <form id="mpesa-payment-form">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Mpesa Number</label>
                                    <input type="text" class="form-control" id="phone" placeholder="2547XXXXXXXX" required>
                                    <!-- Dynamically calculated amount -->
                                    <input type="hidden" id="amount" value="{{ (int) $order->items->reduce(function ($carry, $item) {
                                        return $carry + $item->amount;
                                    }, 0) }}">
                                    <input type="hidden" id="pay_type" value="checkout">
                                    <input type="hidden" id="account" value="{{ $order->id }}">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button id="makePayment" type="button" class="btn btn-primary">Make Payment</button>
                                    <button id="makePaymentDisabled" type="button" class="btn btn-success" disabled style="display:none;">Processing...</button>
                                </div>
                            </form>
                            <div id="dynamic-content3" class="mt-3 text-center"></div>
                            <div id="result" class="mt-3 text-center"></div>
                        </div>
                        <div class="back-to-invoice">
                            <p><a href="{{ route('invoices.open', $order->slug) }}">Back to Invoice</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Page -->

    <script>
        $(document).ready(function () {
            $('#makePayment').on('click', function (e) {
                e.preventDefault();

                let phone = $('#phone').val();
                let amount = $('#amount').val();
                let account = $('#account').val();
                let pay_type = $('#pay_type').val();

                $('#dynamic-content3').html('<p class="text-info">Request sent to your phone. Please proceed with payment.</p>');
                $('#makePayment').hide();
                $('#makePaymentDisabled').show();

                $.ajax({
                    type: 'GET',
                    url: "{{ url('bmpesa') }}",
                    data: { phone, amount, account, pay_type },
                    success: function (data) {
                        let checkStatus = function () {
                            $.ajax({
                                type: 'GET',
                                url: "{{ url('bconfirm-payment') }}/" + data.transactionId,
                                success: function (statusData) {
                                    $('#result').html(`<strong>${statusData.msg}</strong>`);

                                    if (statusData.msg === "The service request is processed successfully.") {
                                        window.location.href = "{{ route('success_deposit', $order->id) }}";
                                    } else if (["DS timeout user cannot be reached", "The initiator information is invalid.", "The balance is insufficient for the transaction."].includes(statusData.msg)) {
                                        $('#result').html(`
                                            <p class="text-danger">Payment failed. Please try again.</p>
                                            <a href="{{ route('pay_now', $order->id) }}" class="btn btn-info">Try Again</a>
                                        `);
                                        $('#makePaymentDisabled').hide();
                                        $('#makePayment').show();
                                    }
                                },
                            });
                        };
                        setInterval(checkStatus, 1000);
                    },
                });
            });
        });
    </script>
</body>
</html>
