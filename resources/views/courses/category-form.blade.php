<h6>New Course Category Form</h6>
<form action="{{ route('publish-category') }}" method="POST">
    @csrf

    <div class="form-group">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" id="category_name" class="form-control">
    </div>

    <div class="form-group">
        <label for="description">Description:</label>
        <textarea name="description" id="description" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Add Category</button>
</form>
