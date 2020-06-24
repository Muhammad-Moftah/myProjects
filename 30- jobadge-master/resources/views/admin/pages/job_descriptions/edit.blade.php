@extends('admin.master')
@section('styles')
<link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />
@endsection
@section('body')
<!-- Horizontal Layout -->
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Edit Job description
                </h2>
            </div>
            <div class="body">
                @include('admin.layouts.errors')
                <form id="form_advanced_validation" method="POST" action="{{route('admin.descriptions.edit.post',$description->id)}}">
                    {{ csrf_field() }}
                    <div class="form-group form-float">
                        <label class="form-label">* description</label>
                        <div class="form-line">
                            <textarea id="description" name="description" value="{{$description->description}}" cols="30" rows="5" class="form-control no-resize" required>{{$description->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <label class="form-label">* requirement</label>
                        <div class="form-line">
                            <textarea id="requirement" name="requirement" value="{{$description->requirement}}" cols="30" rows="5" class="form-control no-resize" required>{{$description->requirement}}</textarea>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <input type="text" value="{{$description->title}}" class="form-control" name="title" maxlenght="200" required>
                            <label class="form-label">* Title</label>
                        </div>
                        <div class="help-info">Max. Char: 200</div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                            <p>
                                <b>* category</b>
                            </p>
                            <select name="category_id" class="form-control show-tick" data-live-search="true" required>
                                @foreach($categories as $category)
                                <option {{ $category->id == $description->category_id? 'selected':''}} value="{{$category->id}}">{{$category->name_en}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-primary waves-effect" type="submit">Edit</button>
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
<script type="text/javascript">
    $(function() {
        CKEDITOR.replace('description');
        CKEDITOR.replace('requirement');
    });
</script>
@endsection