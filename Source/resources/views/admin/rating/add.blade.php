
<div class="modal-header">
    <h1 class="modal-title">Thêm user</h1>
    <button type="button" class="close" data-dismiss="modal">×</button>
</div>

<!-- Modal body -->
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <form method="POST" action="{{route('admin.rating.add')}}">
                {{csrf_field()}}
                <div class="form-row">
                    <div class="form-group  col-md-6">
                        <label for="username">Reviewers:</label>
                        <select class="custom-select" name="user_id">
                            <option disabled="">Reviewer</option>
                            {{--  <option value="1">uuu</option>
                             <option value="2">vvv</option>
                             <option value="3">fff</option> --}}
                             @if($user)
                             @foreach ($user as $record)
                             <option value="{{$record->id}}">{{$record->name}}</option>
                             @endforeach
                             @endif
                         </select>
                     </div>
                     <div class="form-group  col-md-6">
                        <label for="fullname">Rating:</label>
                        <input type="text" class="form-control" id="rating"  placeholder="Enter Rating" name="rating" autofocus required>
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
                <textarea class="form-control" rows="5" id="comment" name="comment"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Add</button>

            </div>
        </form>
    </div>
</div>
</div>

<!-- Modal footer -->

