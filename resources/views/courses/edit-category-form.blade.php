<h3>Update Course Category Form</h3>
<hr>
<form action="{{ route('update-category') }}" method="POST">
    @csrf
    <input type="hidden" name="category_id" value="{{ $category->id }}">
    <div class="form-group">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" id="category_name" value="{{ $category->category_name }}" class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control">{{ $category->description }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Category</button>
</form>
