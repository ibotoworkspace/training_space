@extends('layouts.index')
@section('content')
    <div class="row">
        <h3>My Certificate</h3>
        <hr>
        <iframe src="{{ url('certificates/' . $fileName) }}" style="width: 100%; height: 600px;" frameborder="0"></iframe>
    </div>
@endsection
