
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
                    <input  class="form-control" type="text" name="name_se" value="{{ old('name_se') }}" id="name" >
                    <input  class="form-control" type="text" name="user_id" value="" id="user_id" hidden>
                    @if ($errors->has('name_se'))
                    <span class="text-danger">{{ $errors->first('name_se') }}</span>
                    @endif
                    <div id="error" style="display: none;color: red;font-weight: bold;">Không có trong danh sách</div>
                </div>
                <div class="form-group  col-md-6">
                    <label for="rating">Rating:</label>
                    <input type="number" class="form-control" id="rating"  placeholder="Enter Rating" name="rating" value="{{ old('rating') }}" min="1" max="5">
                    @if ($errors->has('rating'))
                    <span class="text-danger">{{ $errors->first('rating') }}</span>
                    @endif
                </div>
            </div>

            <div class="form-group">
             <label for="post">Post:</label>
             <input  class="form-control" type="text" name="title" value="{{ old('title') }}" id="title" >
             <input  class="form-control" type="text" name="post_id" value="" id="post_id" hidden>
             @if ($errors->has('title'))
             <span class="text-danger">{{ $errors->first('title') }}</span>
             @endif
             <div id="error2" style="display: none;color: red;font-weight: bold;">Không có trong danh sách</div>
         </div>
         <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea class="form-control" rows="5" id="editor1" name="comment" value="" ></textarea>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script type="text/javascript">
    CKEDITOR.replace('editor1');
    var $input1 = $("#name");
    var $input2= $("#title");
    var route1 = "{{route('admin.rating.select')}}";
    $input1.typeahead({
        source:  function (query1, process) {
            return $.get(route1, { query2: query1 }, function (data) {
             if(data.user.length != 0){
                $('#error').hide();
                return process(data.user);
            }
            else{
                $('#error').show();
                return process("");
            }
        });
        },
        displayText: function (item) {
            return item.name;
        },
        afterSelect: function(args){
            $('#user_id').val(args.id);
        }
    });
    $(document).ready(function(){
        $("#name").keyup(function(){
            $('#error').hide();
        });
        $("#title").keyup(function(){
            $('#error2').hide();
        });
        //ckeck lỗi nhập trk khi submit
        $('#add').on('click', function(){
            if($('#error').css('display') == "block" || $('#error2').css('display') == 'block'){
               // console.log($('#error').css('display'));
               alert("Error, vui lòng kiểm tra lại thông tin");
               return false;
           }
       })
    });
    $input2.typeahead({
        source:  function (query2, process) {
            return $.get(route1, { query: query2 }, function (data) {
                if(data.post.length != 0){
                    $('#error2').hide();
                    return process(data.post);
                }
                else{
                    $('#error2').show();
                    return process("");
                }
            });
        },

        displayText: function (item) {
            return item.title;
        },
        afterSelect: function(args){
            $('#title').val(args.title);
            $('#post_id').val(args.id);
        }
    });
</script>

@endpush