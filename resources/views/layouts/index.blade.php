<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <link rel="stylesheet" type= "text/css" href="/css/app.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Iboto Empire | LMS</title>
</head>
<body>
<div class="nav-bar">
    @include('layouts.header')
</div>

<div class = "container" id="pagecontent">
    @if (session('flash_message'))
        <div class="card-body">
            <div class="alert alert-success">
                {{ session('flash_message') }}
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
    
    
            $('#wyswyg').summernote({
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
    
    
    
    </script>
@endif

</body>
</html>