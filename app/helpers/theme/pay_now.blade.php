@extends('theme.layouts.main')
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
@section('main')


    <!-- Start Checkout Page -->
    <section class="checkout-page py-5" style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="your_order">
                        <h2>Process your payment</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__payment  p-4 rounded">
                                    <div class="checkout__payment__item checkout__payment__item--active">
                                        <h3 class="checkout__payment__title">MPESA Payment</h3>
                                        <div class="checkout__payment__content mb-3">
                                            Enter your phone number to receive an MPESA STK push or Lipa Na MPESA Paybill.
                                        </div>
                                        <div class="checkout__mpesa">
                                
                                     


                                            <div class="row">
    <div class="form-group col-sm-12">
        <label for="phone" class="col-sm-12 control-label">Mpesa No:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="phone" placeholder="Mobile Number (2547XXXXXXXX)" required="">
            <input type="hidden" id="amount" value="{{ (int) $order->total_amount }}">
            <input type="hidden" id="pay_type" value="checkout">
            <input type="hidden" id="account" value="{{ $order->id }}">
        </div>
        <div class="col-sm-4 text-right">
            <button id="makePayment" class="btn btn-primary">Make Payment</button>
            <button id="makePaymentDisabled" style="display:none;" class="btn btn-success" disabled>Processing...</button>
        </div>
    </div>
    <div class="col-sm-12 text-center">
        <p id="dynamic-content3" style="color: #ffffff;"></p>
        <p id="result" style="color:#ffffff;"><strong></strong></p>
    </div>
</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Checkout Page -->


    <script>
 $(document).ready(function(){
 $(document).on('click', '#makePayment', function(e){

                e.preventDefault();

            var phone    = document.getElementById('phone').value;   // it will get id of clicked row
            var amount   = document.getElementById('amount').value;
            var account  = document.getElementById('account').value;
            var pay_type = document.getElementById('pay_type').value;

            $('#dynamic-content3').html('<p align="center" style="color:#ffffff;"><strong>Heads up!</strong> Request sent to your mobile Phone. Proceed by paying from your mobile phone.</p>'); // leave it blank before ajax call
            $('#modal-loader3').show();      // load ajax loader
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();


            $.ajax({
              type: 'get',
              url:"{{ url('bmpesa')}}",
              data: 'phone='+phone+'&amount='+amount+'&account='+account+'&pay_type='+pay_type,
              success: function(data) {

                console.log('File has uploaded');
                console.log(data.success);

                var ajaxCall = function() {
                  $.ajax({
                    type: 'get',
                    url:"{{ url('bconfirm-payment') }}/"+data.transactionId,
                    data: $("#myForm").serialize(),
                    success: function(data) {

                      document.getElementById("result").innerHTML = data.msg;

                      if (data.msg == "The service request is processed successfully."){
               
                      window.location = "{{ route('success_deposit', $order->id) }}";

                      }
                      if(data.msg =="DS timeout user cannot be reached" || data.msg == "The initiator information is invalid." || data.msg =="The balance is insufficient for the transaction."){
                        document.getElementById("result").innerHTML = '<i class="glyphicon glyphicon-info-sign"></i> Something went wrong with your payment, Please try again... and check your phone to input mpesa pin <br> <a href="{{ route("pay_now", $order->id)}}" class="btn btn-info">Try Again</a>';
                        $('#modal-loader3').hide();
                        $('#mpesa').hide();
                      }

                    }
                  });
                }

                setInterval(ajaxCall, 1000);

              }
            });

            
          });



            });


          </script>

@endsection

@section('styles')
    
@endsection
