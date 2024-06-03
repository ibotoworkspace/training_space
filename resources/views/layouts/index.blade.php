<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link rel="stylesheet" type= "text/css" href="{{ asset('/css/app.css')}}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iboto Empire | LMS</title>

    <style>
        body{
            background-image: url('{{ asset('images/bg.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;

        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5); /* White overlay with 50% opacity */
            z-index: -1;
            min-height: 100%;
        }

        #pagecontent{
            background-color: white;
            opacity: 0.9;
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .row{
            padding: 10px;
        }
        .container{            
            width: 100% !important;
        }
    </style>
</head>
<body>
<div class="nav-bar">
    @include('layouts.header')
</div>

<div class = "container" id="pagecontent">
    @if (session('flash_message'))
        <div class="card-body">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                {!! session('flash_message') !!}
            </div>
        </div>
    @endif
    @yield('content')
</div>

<div class="footer">
    @include('layouts.footer')
</div>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

@if (isset($pagetype) && $pagetype == "wyswyg")
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(function() {
    
    
            $('#wyswyg, .wyswyg').summernote({
                height: 300, // Set the height of the editor
    
                toolbar: [
                    ['style', ['undo','redo','style']], // Style dropdown (e.g., paragraph, code)
                    ['font', ['bold', 'italic', 'underline', 'clear','strikethrough', 'superscript', 'subscript']], // Font style (bold, italic, underline)
                    ['fontname', ['fontname']], // Font family
                    ['fontsize', ['fontsize']], // Font size
                    ['fontsizeunit', ['fontsizeunit']], // Font size
                    ['color', ['forecolor', 'backcolor']], // Text color and background color
                    ['para', ['ul', 'ol', 'paragraph']], // Lists (unordered, ordered), paragraph formatting
                    ['height', ['height']], // Line height
                    ['table', ['table']], // Insert table
                    ['insert', ['link', 'picture', 'video', 'hr']], // Insert links, images, videos, horizontal rule
                    ['view', ['fullscreen', 'codeview','help']], // Fullscreen mode, code view, help
                ],
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['para', ['ul', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']]
                    ]
                }
            });
            
        });

        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.copy-url');
            images.forEach(image => {
                image.addEventListener('click', function() {
                    const url = this.getAttribute('data-url');
                    const input = document.createElement('input');
                    input.value = url;
                    document.body.appendChild(input);
                    input.select();
                    document.execCommand('copy');
                    document.body.removeChild(input);
                    alert('URL copied to clipboard: ' + url);
                });
            });
        });
    </script>
@endif

</body>
</html>