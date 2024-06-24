<h3>Publish Quiz for a Course</h3>
<hr>
                    <form method="POST" action="{{ route('update-quiz') }}">
                        @csrf
                        <input type="hidden" name="quiz_id" value="{{$quiz->id}}">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="course_id">Select Course</label>
                                <select id="course_id" class="form-control" name="course_id">
                                    <option  value="{{$quiz->course_id ?? ""}}" selected>{{$quiz->course->title ?? ""}}</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Quiz Title</label>
                                    <input id="title" type="text" class="form-control" name="title"  value="{{$quiz->title}}" required autofocus>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input id="subtitle" type="text" class="form-control" name="subtitle" value="{{$quiz->subtitle}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="wyswyg">Description</label>
                            <textarea  id="wyswyg" class="form-control" name="description" rows="3">{!!$quiz->description!!}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" class="form-control" name="category_id">
                                        <option  value="{{$quiz->category_id}}" selected>{{$quiz->Category->category_name}}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="author">Instroduction</label>
                                    <select id="author" class="form-control" name="author">
                                        <option  value="{{$quiz->author}}" selected>{{$quiz->Author->name}}</option>
                                        @foreach($students as $author)
                                            <option value="{{ $author->id }}">{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="duration">Duration (In Minutes)</label>
                                    <input id="duration" type="text" class="form-control" name="duration" value="{{$quiz->duration}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input id="start_date" type="date" class="form-control" name="start_date" value="{{$quiz->start_date}}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input id="end_date" type="date" class="form-control" name="end_date" value="{{$quiz->end_date}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="allowed_attempts">Allowed Attempts</label>
                                    <input id="allowed_attempts" type="number" class="form-control" name="allowed_attempts"  value="{{$quiz->allowed_attempts}}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" class="form-control" name="status">
                                        <option value="{{$quiz->status}}" selected>{{$quiz->status}}</option>
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" class="form-control" name="remarks" rows="3">{!!$quiz->remarks!!}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Quiz</button>
              
                    </form>