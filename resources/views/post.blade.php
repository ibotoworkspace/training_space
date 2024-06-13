@extends('layouts.index')
@section('content')
@php $pagetype = "wyswyg"; @endphp
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <div class="card">
                    <div class="card-body">
                        <h2>{{ $post->title }}</h2>
                        <h5>{{ $post->subtitle }}</h5>
                        <div class="row" style="justify-content: center; align-content: center;">
                            @if ($post->featured!="")                                  
                                <img src="{{ asset($post->featured) }}" alt="{{ $post->title }}" class="img-fluid mb-3">
                            @endif
                        </div>
                        <p>{!! $post->description !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img src="/images/advert.jpg" width="100%" height="auto" alt="ADVERT">
                <hr>
                <h3>Next Step</h3>
                <hr>
                <p>To Enroll Simply</p>
                <ul>
                    <li>Go to the Courses Page</li>
                    <li>Click on the Course</li>
                    <li>Click on Enroll</li>
                </ul>

                <div class="fb-page" 
                data-href="https://www.facebook.com/training4skilldevelopment/"
                data-tabs="timeline" 
                data-width="" 
                data-height="" 
                data-small-header="false" 
                data-adapt-container-width="true" 
                data-hide-cover="false" 
                data-show-facepile="true">
               <blockquote cite="https://www.facebook.com/training4skilldevelopment/" class="fb-xfbml-parse-ignore">
                   <a href="https://www.facebook.com/training4skilldevelopment/">Training 4 Skill Development</a>
               </blockquote>
           </div>
           <div id="fb-root"></div>
           <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v12.0"></script>
       
            </div>
        </div>
    </div></div>

@endsection