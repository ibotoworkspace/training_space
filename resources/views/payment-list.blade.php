@extends('layouts.index')
@section('content')

@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
@php $pagetype = "report"; @endphp
    <div class="container mt-5">
        <h3>Payments</h3>
        <table class="table table-striped table-responsive" id="products">
            <thead>
            <tr>
                <th>Student Name</th>
                <th>Amount</th>
                <th>Currency</th>
                <th>Payment Method</th>
                <th>Course Title</th>
                <th>Status</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            
            @foreach ($payments as $pa)
                <tr>
                    <td>{{$pa->Payee->name}}</td>
                    <td>{{$pa->amount}}</td>
                    <td>{{$pa->currency}}</td>
                    <td>{{$pa->payment_method}}</td>
                    <td>{{$pa->Course->title}}</td>
                    <td>{{$pa->status}}</td>
                    <td>{{$pa->reference_no}}</td>
                    <td>{{$pa->created_at}}</td>
                    <td><a href="{{url('dashboard')}}" class="btn btn-primary  roledlink Admin">Approve</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif


@endsection