@extends('layouts.appbar')
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
@section('content')
<div class="content-wrapper p-4">
    <!-- Start Checkout Page -->
    <section class="checkout-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h2 class="text-center mb-4">Process Your Payment</h2>
                            <p class="text-muted text-center mb-4">
                                Complete your payment securely via MPESA. Enter your phone number to receive a payment request.
                            </p>
                            <form id="mpesaPaymentForm">
                                <div class="mb-4">
                                    <label for="phone" class="form-label">MPESA Mobile Number</label>
                                    <input type="text" class="form-control" id="phone" placeholder="2547XXXXXXXX" required>
                                    <input type="hidden" id="amount" value="{{ (int) $order->total_amount }}">
                                    <input type="hidden" id="pay_type" value="checkout">
                                    <input type="hidden" id="account" value="{{ $order->id }}">
                                </div>
                                <div class="text-center">
                                    <button id="makePayment" class="btn btn-primary w-100">Make Payment</button>
                                    <button id="makePaymentDisabled" style="display:none;" class="btn btn-success w-100" disabled>Processing...</button>
                                </div>
                            </form>
                            <div class="mt-4 text-center">
                                <p id="dynamic-content3" style="color: #000000;"></p>
                                <p id="result" style="color:#000000;"><strong></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Page -->
</div>

<script>
    $(document).ready(function () {
        $(document).on('click', '#makePayment', function (e) {
            e.preventDefault();

            var phone = $('#phone').val();
            var amount = $('#amount').val();
            var account = $('#account').val();
            var pay_type = $('#pay_type').val();

            $('#dynamic-content3').html('<p class="text-center text-dark"><strong>Heads up!</strong> Request sent to your phone. Please proceed with the payment.</p>');
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();

            $.ajax({
                type: 'get',
                url: "{{ url('bmpesa') }}",
                data: { phone: phone, amount: amount, account: account, pay_type: pay_type },
                success: function (data) {
                    console.log(data.success);

                    var ajaxCall = function () {
                        $.ajax({
                            type: 'get',
                            url: "{{ url('bconfirm-payment') }}/" + data.transactionId,
                            success: function (response) {
                                $('#result').html(response.msg);

                                if (response.msg === "The service request is processed successfully.") {
                                    window.location = "{{ route('success_deposit', $order->id) }}";
                                } else if (response.msg === "DS timeout user cannot be reached" || 
                                           response.msg === "The initiator information is invalid." || 
                                           response.msg === "The balance is insufficient for the transaction.") {
                                    $('#result').html('<strong>Payment failed:</strong> Please try again. <a href="{{ route("pay_now", $order->id)}}" class="btn btn-info btn-sm mt-2">Retry Payment</a>');
                                    $('#makePaymentDisabled').hide();
                                    $('#makePayment').show();
                                }
                            }
                        });
                    };

                    setInterval(ajaxCall, 1000);
                }
            });
        });
    });
</script>
@endsection

@section('styles')
<style>
    .checkout-page {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 10px;
    }

    .btn-primary {
        background-color: #0275d8;
        border-color: #0275d8;
    }

    .btn-primary:hover {
        background-color: #025aa5;
        border-color: #025aa5;
    }
</style>
@endsection
