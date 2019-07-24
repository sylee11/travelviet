
<div class="modal-header">
    <h1 class="modal-title">Add rating</h1>
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <!-- Modal body -->
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{route('admin.rating.add')}}" id="form_add">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Reviewers:</label>
                        <select class="custom-select" name="user_id">
                            <option disabled="">Reviewer</option>
                            @if($user)
                            @foreach ($user as $record)
                            <option value="{{$record->id}}">{{$record->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group  col-md-6">
                        <label for="rating">Rating:</label>
                        <input type="text" class="form-control" id="rating"  placeholder="Enter Rating" name="rating" autofocus required>
                        @if ($errors->has('rating'))
                        <span class="text-danger">{{ $errors->first('rating') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                   <label for="post">Post:</label>
                   <select class="custom-select" name="post_id">
                    <option disabled="">Post</option>
                    @if($post)
                    @foreach ($post as $record)
                    <option value="{{$record->id}}">{{$record->title}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" id="editor1" name="comment" required></textarea>
                @if ($errors->has('comment'))
                <span class="text-danger">{{ $errors->first('comment') }}</span>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" id="add">Add</button>

            </div>
        </form>
    </div>
</div>
</div>

<!-- Modal footer -->

@push('scripts')
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{asset('ckeditor/adapters/jquery.js') }}"></script>
<script type="text/javascript">CKEDITOR.replace('editor1');</script>

@endpush