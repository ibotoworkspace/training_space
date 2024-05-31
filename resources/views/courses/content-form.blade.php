<h3>Publish Course Contents</h3>

<hr>
<form action="{{ route('publish-content') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="course_id">Course Name:</label>
        <select name="course_id" id="course_id" class="form-control">
            <!-- Populate options dynamically from database -->
            @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="material_title">Title/Topic:</label>
        <input type="text" name="material_title" id="material_title" class="form-control">
    </div>

    <div class="form-group">
        <label for="wyswyg">Description:</label>
        <textarea name="description" id="wyswyg" class="form-control"></textarea>
    </div>

    <div class="row">

        <div class="form-group col-md-6">
            <label for="category_id">Category:</label>
            <select name="category_id" id="category_id" class="form-control">
                <!-- Populate options dynamically from database -->
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="ordering">Ordering:</label>
            <input type="number" name="ordering" id="ordering" class="form-control">
        </div>

        <div class="form-group col-md-3">
            <label for="material_type">Material Type:</label>
            <select name="material_type" id="material_type" class="form-control">
                <option value="pdf">PDF</option>
                <option value="word">Microsoft Word</option>
                <option value="text">Text</option>
                <option value="url">URL</option>
            </select>
        </div>
    </div>

    <div class="row">

        <div class="form-group col-md-4">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control">
        </div>

        <div class="form-group col-md-4">
            <label for="file_path">Upload File:</label>
            <input type="file" name="file_path" id="file_path" class="form-control-file">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-6">
            <label for="user_id">Select Students (Optional):</label>
            <select name="user_id" id="user_id" class="form-control">
                <!-- Populate options dynamically from database -->
                <option value="" selected>For All Selected Category</option>
                @foreach($students->where('user_role','Student') as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="user_id">Author:</label>
            <select name="user_id" id="user_id" class="form-control">
                <!-- Populate options dynamically from database -->
                <option value="{{Auth::user()->id}}" selected>{{Auth::user()->name}}</option>
                @foreach($students->where('user_role','Author') as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Publish</button>
</form>