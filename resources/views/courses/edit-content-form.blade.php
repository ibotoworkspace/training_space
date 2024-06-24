<h3>Edit Course Content</h3>
<hr>
<form action="{{ route('save-update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{$content->id}}">
    <input type="hidden" name="old_file_path" value="{{$content->file_path}}">
    <div class="form-group">
        <label for="course_id">Course Name:</label>
        <select name="course_id" id="course_id" class="form-control">
            <!-- Populate options dynamically from database -->
            <option value="{{ $content->course_id ?? "" }}" selected>{{ $content->course->title ?? "" }}</option>

            @foreach($courses as $course)
                <option value="{{ $content->id }}">{{ $content->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="material_title">Title/Topic:</label>
        <input type="text" name="material_title" id="material_title" class="form-control" value="{{$content->material_title}}">
    </div>

    <div class="form-group">
        <label for="wyswyg">Description:</label>
        <textarea name="description" id="wyswyg" class="form-control">{!!$content->description!!}</textarea>
    </div>

    <div class="row">

        <div class="form-group col-md-6">
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control">
                <!-- Populate options dynamically from database -->
                <option value="{{ $content->category_id }}" selected>{{ $content->Category->category_name ?? "" }}</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="ordering">Ordering:</label>
            <input type="number" name="ordering" id="ordering" class="form-control" value="{{$content->ordering}}">
        </div>

        <div class="form-group col-md-3">
            <label for="material_type">Material Type:</label>
            <select name="material_type" id="material_type" class="form-control">
                <option value="{{$content->material_type}}" selected>{{$content->material_type}}</option>
                <option value="pdf">PDF</option>
                <option value="word">Microsoft Word</option>
                <option value="text">Text</option>
                <option value="url">URL</option>
            </select>
        </div>
    </div>

    <div class="row">

        <div class="form-group col-md-3">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" value="{{$content->start_date}}" class="form-control">
        </div>

        <div class="form-group col-md-3">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{$content->start_date}}">
        </div>

        <div class="form-group col-md-3">
            <label for="file_path">Upload File:</label>
            <input type="file" name="file_path" id="file_path" class="form-control-file">
        </div>

        <div class="form-group col-md-3">
            <label for="user_id">Author:</label>
            <select name="user_id" id="user_id" class="form-control">
                <!-- Populate options dynamically from database -->
                <option value="{{$content->user_id}}" selected>{{$content->Author->name ?? ""}}</option>
                @foreach($students->where('user_role','Author') as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary float-right">Update</button>
</form>