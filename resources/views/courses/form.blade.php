<h3>New Course Form</h3>
<hr>
            <div class="form-group">
                {!! Form::label('title', 'Course Title:') !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('thumbnail', 'Course Thumbnail:' ) !!}
                {!! Form::file('thumbnail', array('class' => 'form-control', 'accept'=> 'image/*')) !!}
                @if (isset($course))
                    {!! Html::image('/'.$course->thumbnail, 'Thumbnail', array('style' => 'width: 80%;')) !!}
                @endif
            </div>
            <div class="form-group">
                {!! Form::label('wyswyg', 'Course Description: ') !!}
                {!! Form::textarea('description', null, array('class' => 'form-control','id'=>'wyswyg')) !!}
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    {!! Form::label('category', 'Category:') !!}
                    {!! Form::select('category', $categories->pluck('category_name', 'id'), null, ['class' => 'form-control', 'id' => 'category']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('fee', 'Course Fee:') !!}
                    {!! Form::text('fee', null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('category', 'Course Category:') !!}
                    {!! Form::text('category', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            {!! Form::submit($submitbuttontext, ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}