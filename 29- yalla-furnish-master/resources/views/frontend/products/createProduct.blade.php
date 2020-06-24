@extends('frontend.master')
@section('styles')
<link rel="stylesheet" href="{{asset('assets/site/css/addProduct.css?rand=1234')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet"> 
@endsection
@section('search')
@include('frontend.search_layouts.search')
@endsection
@section('body')
<div class="container">
    <section class="add-product my-5 shadow bg-white p-3 rounded">
        <div class="float-right">
            <a href="{{route('user.my.dashboardOffers' , request()->segment(3))}}" class="btn btn-success">Back To Offers</a>
            <a href="{{route('user.my.dashboardProducts' , request()->segment(3))}}" class="btn btn-success">Back To Products</a>
        </div>
        <form id="create-product" class="create-product-form" method="POST" action="{{route('user.product.create.post',$showroom->id)}}" enctype="multipart/form-data">
            @csrf
            <h3>Add Product / Offer</h3>
            <div class="alert alert-success" role="alert"> </div>
            <div class="alert bg-red errors">  </div>
            <div class="row">
                <div class="col-md-6 border-right"> 

                    <div class="form-group">
                        <label class="{{ $errors->has('images') || $errors->has('images.*') ? 'text-danger' : ''}}" for="">
                            * Upload up to 5 Photos
                        </label>
                        <label for="uploadimgs" class="float-right">
                            <div class="btn upload-btn">Upload</div>
                        </label>
                        <div>
                            <input type="file" name="images[]" multiple="multiple" class="d-none" id="uploadimgs" placeholder="images">
                            {!! $errors->first('images', '<div class="text-danger small">:message</div>') !!}
                            {!! $errors->first('images.*', '<div class="text-danger small">:message</div>') !!}
                        </div>
                        <small class="text-muted d-block pb-2">Supported files: JPG, JPEG, PNG</small>
                    </div>

                    <div class="images-preview"></div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('price') ? 'text-danger' : ''}}">Price:</h5>
                        <div>
                            <input value="{{old('price')}}" id="price" type="text" style="width:150px" name="price" class="form-control form-control-sm" id="exampleInputLastName" placeholder="EGP">
                            {!! $errors->first('price', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>
  
                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('categories') || $errors->has('categories.*') ? 'text-danger' : ''}}">
                            * Product Category :
                        </h5>
                        <div class="text-right">
                            <select id="categories" name="categories[]" class="form-control selectpicker" multiple data-hide-disabled="true" data-size="5">
                                @foreach($categories as $category)
                                <option @if(old('categories')!==null) {{in_array($category->id,old('categories'))?'selected':''}} @endif value="{{$category->id}}">{{$category->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('branches', '<div class="text-danger small">:message</div>') !!}
                            {!! $errors->first('branches.*', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div> 

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('style_id') ? 'text-danger' : ''}}">* Product Style:</h5>
                        <div>
                            <select id="style" name="style_id" class="form-control-sm form-control p-0">
                                <option disabled selected>Select your style</option>
                                @foreach($styles as $style)
                                <option {{old('style_id')==$style->id?'selected':''}} value="{{$style->id}}">{{$style->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('style_id', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('color_id') ? 'text-danger' : ''}}">* Product Color:</h5>
                        <div>
                            <select id="color" name="color_id" class="form-control-sm p-0">
                                <option disabled selected>Select your color</option>
                                @foreach($colors as $color)
                                <option {{old('color_id')==$color->id?'selected':''}} value="{{$color->id}}">{{$color->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('color_id', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('material_id') ? 'text-danger' : ''}}">* Frame Material:</h5>
                        <div>
                            <select id="material" name="material_id" class="form-control-sm p-0">
                                <option disabled selected>frame material</option>
                                @foreach($materials as $material)
                                <option {{old('material_id')==$material->id?'selected':''}} value="{{$material->id}}">{{$material->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('material_id', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('upholstery_id') ? 'text-danger' : ''}}">* Upholstery Material:</h5>
                        <div>
                            <select id="upholstery" name="upholstery_id" class="form-control-sm p-0">
                                <option disabled selected>upholstery material</option>
                                @foreach($upholsteries as $upholstery)
                                <option {{old('upholstery_id')==$upholstery->id?'selected':''}} value="{{$upholstery->id}}">{{$upholstery->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('upholstery_id', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="{{ $errors->has('name_en') ? 'text-danger' : ''}}">* English Name:</h5>
                        <div>
                            <input value="{{old('name_en')}}" type="text" name="name_en" class="form-control" id="english_name" placeholder="Enter your English Name">
                            {!! $errors->first('name_en', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="{{ $errors->has('name_ar') ? 'text-danger' : ''}}">* Arabic Name:</h5>
                        <div>
                            <input value="{{old('name_ar')}}" type="text" name="name_ar" class="form-control" id="arabic_name" placeholder="Enter your arabic name">
                            {!! $errors->first('name_ar', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="{{ $errors->has('description_en') ? 'text-danger' : ''}}">* English Description:</h5>
                        <div>
                            <textarea rows="2" value="{{old('description_en')}}" name="description_en" class="form-control textFormat" id="english_description" placeholder="English description">{!! old('description_en') !!}</textarea>
                            {!! $errors->first('description_en', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <h5 class="{{ $errors->has('description_ar') ? 'text-danger' : ''}}">* Arabic Description:</h5>
                        <div>
                            <textarea rows="2" value="{{old('description_ar')}}" name="description_ar" class="form-control textFormat" id="arabic_description" placeholder="Arabic description">{!! old('description_ar') !!}</textarea>
                            {!! $errors->first('description_ar', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h5 class="{{ $errors->has('others') ? 'text-danger' : ''}}">Additional Details (optional):</h5>
                        <div>
                            <textarea rows="2" value="{{old('others')}}" name="others" class="form-control textFormate" id="others" placeholder="other details">{!! old('others') !!}</textarea>
                            {!! $errors->first('others', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('branches') || $errors->has('branches.*') ? 'text-danger' : ''}}">* Product Avaliable in:</h5>
                        <div class="text-right">
                            <select id="branches" name="branches[]" class="form-control selectpicker" multiple data-hide-disabled="true" data-size="5">
                                @foreach($showroom->branches as $branch)
                                <option @if(old('branches')!==null) {{in_array($branch->id,old('branches'))?'selected':''}} @endif value="{{$branch->id}}">
                                @if($branch->title)
                                {{$branch->title}}
                                @else
                                {{$branch->address_en}}
                                @endif
                                </option>
                                @endforeach
                            </select>
                            {!! $errors->first('branches', '<div class="text-danger small">:message</div>') !!}
                            {!! $errors->first('branches.*', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('guarantee') ? 'text-danger' : ''}}">Guarantee:</h5>
                        <div>
                            <input value="{{old('guarantee')}}" type="text" name="guarantee" class="form-control" id="guarantee" placeholder="months">
                            {!! $errors->first('guarantee', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('width') || $errors->has('height') || $errors->has('depth') ? 'text-danger' : ''}}">Size:</h5>
                        <div>
                            <input value="{{old('width')}}" name="width" id="width" class="form-control d-inline-block" type="text" style="width:70px; text-align:center" placeholder="Height">
                            <input value="{{old('height')}}" name="height" id="height" class="form-control d-inline-block" type="text" style="width:70px; text-align:center" placeholder="Width">
                            <input value="{{old('depth')}}" name="depth" id="depth" class="form-control d-inline-block" type="text" style="width:70px; text-align:center" placeholder="Depth">
                            <span class="badge badge-dark">in cm</span>
                            {!! $errors->first('width', '<div class="text-danger small">:message</div>') !!}
                            {!! $errors->first('height', '<div class="text-danger small">:message</div>') !!}
                            {!! $errors->first('depth', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5 class="{{ $errors->has('country_id') ? 'text-danger' : ''}}">* Made in:</h5>
                        <div>
                            <select id="country" name="country_id" class="form-control-sm form-control p-0">
                                <option disabled selected>Select Country</option>
                                @foreach($countries as $country)
                                <option {{old('country_id')==$country->id?'selected':''}} value="{{$country->id}}">{{$country->name_en}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('country_id', '<div class="text-danger small">:message</div>') !!}
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox py-3">
                        <input type="checkbox" class="custom-control-input" id="has_offer" name="has_offer">
                        <label class="custom-control-label" for="has_offer">Add this Product to Offer</label>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5>Discount Percentage:</h5>
                        <div class="input-group-sm mb-3 d-flex ">
                            <input type="text" name="discount" id="discount" class="form-control" style="width:60px">
                            <div class="input-group-append">
                                <span class="input-group-text" style="border-radius: 0px 5px 5px 0px;">%</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-flex justify-content-between">
                        <h5>Valid Until:</h5>
                        <div>
                            <input type="text" name="date" id="datepicker" class="form-control" data-enable-time=true>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 text-center">
                    <div class="submit-product"> 
                        <input type="submit" class="btn" value="Submit Product">
                    </div>
                </div>

            </div> 
        </form>
    </section>
</div> 
@endsection
@section('scripts')
<script src="{{asset('assets/site/js/addProduct.js?rand=123')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>  

<script>
     $(document).ready(function() {
        $('.textFormat').summernote({
            height: 100,
            toolbar: false,
            popover: {
            image: [],
            link: [],
            air: []
            }
        });  
     });
    var tomorrow = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate() + 1); 
    $("#datepicker").flatpickr({
        minDate: tomorrow
    });
</script>
@endsection