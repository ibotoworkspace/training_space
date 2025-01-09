@extends('layouts.index')
@section('content')
<style>
    table{
        font-size: 0.8em;
    }
</style>
@if (Auth::check() && (Auth::user()->role->first()->name == 'Instructor' or Auth::user()->role->first()->name == "Admin"))
    @php $pagetype = "report"; @endphp
    <div class="container mt-5">
        <div class="row">
            <a href="{{url('content-form')}}" class="btn btn-primary">New Course Content</a>
        </div>
        <h3>Course Contents | All Course Contents</h3>
       <div class="col-md-12">
            @if($contents->isEmpty())
            <p>No Course contents available at the moment.</p>
        @else
            <table class="table table-striped table-responsive" style="width: 100%" id="products">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Title</th>
                        <th>Course</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Read By</th>
                        <th>Author</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $cont)
                        <tr>
                            <td>{{ $cont->id }}</td>
                            <td>{{ $cont->material_title ?? "" }}</td>
                            <td>{{ $cont->Course ? $cont->Course->title : "" }}</td>
                            <td>{{ $cont->material_type ?? "" ?? '' }}</td>
                            <td>{{ $cont->Category ? $cont->Category->category_name : '' }}</td>
                            <td>{{$cont->userCourse ? $cont->userCourse->count() : 0}}</td>
                            <td>{{ $cont->Author ? $cont->Author->name : "" }}</td>
                           
                            <td class="btn-group">
                                <a href="{{route('course-content',[$cont->id])}}" class="btn btn-primary btn-xs">View</a>
                                @if (Auth::user()->role->first()->name == 'Instructor' || Auth::user()->role->first()->name == "Admin")
                                    <a href="{{route('edit-content',$cont->id)}}" class="btn btn-secondary btn-xs">Edit</a>
                                    <a href="{{url('delete-content/'.$cont->id)}}" class="btn btn-danger  roledlink Admin" onclick="confirm('Are you sure want to delete this content?')">Delete</a>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
       </div>
    </div>
@else
<div class="alert alert-warning  alert-dismissible fade show" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <strong>You don't ave permission to visit this page</strong> 
</div>

<script>
  $(".alert").alert();
</script>
@endif


@endsection