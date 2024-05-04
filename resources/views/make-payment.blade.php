@extends('layouts.index')
<style>
    p{
        clear: both !important;
    }
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="jumbotron">
                <h3>Make Payment</h3>
                <p style="padding: 5px;" class="alert alert-warning">After a successful payment, simply fill the form on the right with details of this transaction for approval.</p>

                
                    <h3>Bank Transfer</h3>
                  <div class="row">
                    
                    <p>Send the sum of {{$course->fee}} to our bank account below;</p><br>
                    <p><b>Account Name: </b>Iboto Empire Bank account name <br>
                    <b>Account Number: </b> 0001000100 <br>
                    <b>Bank Name:</b> GTB
                    </p>
                  </div>
                  <hr>
                  <h3>Online Payment (For Nigerian Naira) </h3>
                  <div class="row">
                    <p>Pay the Sum of {{$course->fee}} using the online payment link below; </p>
                    <div class="row">
                        <form action="{{ route('paystack.payment') }}" method="POST" id="paystackpayment">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $course->fee }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="btn btn-success">Pay with Paystack</button>
                        </form>
                    </div>
                   
                  </div>
                  <hr>
                  <h3>Paypal Payment (for US Dollar)</h3>
                  <div class="row">
                    
                    <p>Pay the Sum of {{$course->fee}} using the Paypal payment link below; </p><br>
                    <div class="row">
                        <form action="{{ route('paypal.payment') }}" method="POST" id="paypalpayment">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $course->fee }}">
                            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <button type="submit" class="btn btn-primary">Pay with Paypal</button>
                        </form>
                    </div>
                  </div>
                
            </div>
        </div>
        <div class="col-md-4">
            <h3>Payment Form</h3>
            <hr>
        </div>
    </div>
</div>
@endsection
