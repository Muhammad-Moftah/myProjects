@extends('admin.master')
@section('styles')
<link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('site/css/bootstrap-tagsinput.css')}}">   
@endsection
@section('body')
<!-- Horizontal Layout -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Create Blog
                </h2>
            </div>
            <div class="body">
                @include('admin.layouts.errors')
                <form id="form_advanced_validation" method="POST" action="{{route('admin.blogs.store')}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" value="{{old('title')}}" class="form-control" name="title" maxlenght="200" required>
                            <label class="form-label">* Title</label>
                        </div>
                        <div class="help-info">Max. Char: 200</div>
                    </div>
                    
                    <div class="form-group form-float">
                        <label class="form-label">* Body</label>
                        <div class="form-line">
                            <textarea id="body" name="body" cols="30" rows="5" class="form-control no-resize" required>{{old('body')}}</textarea>
                            {{-- <label class="form-label">* Body</label> --}}
                        </div>
                    </div>


                    <div class="form-group form-float">
                        <label class="form-label">* Image Cover</label>
                        <div class="form-line">

                            <input type="file"  class="form-control" name="image"  required>

                            {{-- <label class="form-label">* Image Cover</label> --}}
                        </div>
                    </div>
                    
        
                    
                    
                    <div class="form-group form-float">
                        <div class="form-line">
                        <input name="tags" id="tags" placeholder="enter tags" value="{{old('tags')}}" data-old="{{old('tags')}}" type="text" value="" data-role="tagsinput" />

                            {{-- <label class="form-label">* tags </label> --}}
                        </div>
                        <div class="help-info"></div>
                    </div>

                  

                    
                   
                    <button class="btn btn-primary waves-effect" type="submit">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- Validation Plugin Js -->
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.js')}}"></script>
<script src="{{asset('assets/js/pages/forms/form-validation.js')}}"></script>
<!-- Ckeditor -->
<script src="{{asset('assets/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('site/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('body');
       
       

        $('#form_advanced_validation').on('keyup keypress', function(e) {    
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });



   
    });
</script>
@endsection