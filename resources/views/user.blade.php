@extends('layouts.index')
@section('content')

@if (Auth::user()->user_role=="Admin")
{{-- <a href="{{ route('course.create') }}">{!! Form::button('Add New Course', ['class' => 'btn btn-secondary', 'id' => 'course_button']) !!}</a> --}}
<a href="{{ route('user.create') }}" class="btn btn-secondary" id="course_button">Add New User</a>

    
<h1 class="my-4">All Users</h1>

<table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Courses</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>

        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->first()->name ?? '' }}</td>
                    <td>{{$user->courses->count()}}</td>
                    <td class="btn-group">
                        <a class="btn btn-success" href = "{{route('user-dashboard', [$user->id])}}">View Dashboard</a>
                        {!! Form::open(['method' =>"delete", 'action' => ['UserController@destroy', $user->id]]) !!}
                            <a class="btn btn-secondary" href = "{{route('user.edit', [$user->id])}}">Edit</a>
                            {{-- <a class="btn btn-danger" href = "{{ route('user.destroy', [$user->id]) }}"> --}}
                                <input class="btn btn-danger  roledlink Admin" type = "submit" value = "Delete">
                            {{-- </a> --}}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach

        </tbody>
      </table>
@else

<h3>You don't have permission to view this link</h3>

@endif

@endsection