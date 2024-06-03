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
                    
                    <p>Send the sum of {{$course->fee}} to our bank account below;</p><br>
                    <p><b>Account Name: </b>Jacob Oroks<br>
                    <b>Account Number: </b> 205 703 6013 <br>
                    <b>Bank Name:</b> <br>
                    </p>
                  
                  <hr>
                  {{-- <h3>Online Payment (For Nigerian Naira) </h3>
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
                  <hr> --}}
                  <h3>Paypal Payment (for US Dollar)</h3>
                  
                    
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
        <div class="col-md-4">
            <h3>Payment Form</h3>
            <hr>
            <form action="{{ route('save-payment') }}" method="POST">
                @csrf
        
                <!-- Payment Method -->
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="online_payment">Online Payment</option>
                    </select>
                </div>
        
                <!-- Currency -->
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select name="currency" id="currency" class="form-control" required>
                        <option value="USD">USD</option>
                        <option value="NGN">NGN</option>
                    </select>
                </div>
                <input type="hidden" name="amount" value="{{ old('amount', $course->fee) }}">
                <!-- User ID (hidden) -->
                <input type="hidden" name="user_id" value="{{ old('user_id', Auth::id()) }}">
        
                <!-- Course ID (hidden) -->
                <input type="hidden" name="course_id" value="{{ old('course_id', $course->id) }}">
        
                <!-- Payment Status (hidden) -->
                <input type="hidden" name="payment_status" value="{{ old('payment_status', 'Pending') }}">
                
                <!-- Created At -->
                <div class="form-group">
                    <label for="created_at">Date of Payment</label>
                    <input type="date" class="form-control" name="created_at" id="created_at" value="{{ old('created_at', date('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label for="reference_no">Ref (Transfer Ref, Teller No, etc) </label>
                    <input type="text" class="form-control" name="reference_no" value="{{ old('reference_no', '') }}">

                </div>
        
                <!-- Submit Button -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
