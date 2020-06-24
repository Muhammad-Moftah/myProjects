@extends('site.master')
@section('styles')
<style>
    .ck-editor__editable {
        min-height: 300px !important;
    }
</style>
<script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyAiJwjqodwVVY04ESTFA9REOjqOt1pXOQI'></script>
@endsection
@section('body')
<section class="add-ads">
    <div class="container">
        <div class="row">
            <div class="title2 col-sm-12 py-3 rounded mb-5">
                <h1 class="text-center text-white font-weight-bold m-0">{{trans('lang.edit_advertise')}}</h1>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-xl-10 mx-auto">
                        @include('site.layouts.message')
                        <form id="edit_form" action="{{route('user.ad.edit.post',$ad->id)}}" method="POST" enctype="multipart/form-data" class="form-row">
                            <input type="hidden" id="lat" name="latitude" value="{{$ad->latitude}}" />
                            <input type="hidden" id="lng" name="longitude" value="{{$ad->longitude}}" />
                            {{csrf_field()}}
                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="exampleCompanyName">* {{trans('lang.title')}}</label>
                                <input value="{{$ad->title}}" type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" id="exampleCompanyName" placeholder="{{trans('lang.title')}}">
                                {!! $errors->first('title', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="status">* {{trans('lang.status')}}</label>
                                <select class="form-control {{ $errors->has('offer_type_id') ? 'is-invalid' : ''}}" id="status" name="offer_type_id">
                                    @foreach($offer_type_list as $type)
                                    <option {{$ad->offer_type_id==$type->id?'selected':''}} value="{{$type->id}}">@if(app()->getLocale()=='en') {{$type->title_en}} @else {{$type->title_ar}} @endif</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('offer_type_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="PropertyType">* {{trans('lang.property_type')}}</label>
                                <select class="form-control {{ $errors->has('property_type_id') ? 'is-invalid' : ''}}" id="PropertyType" name="property_type_id">
                                    @foreach($proprty_type_list as $type)
                                    <option {{$ad->property_type_id==$type->id?'selected':''}} value="{{$type->id}}">@if(app()->getLocale()=='en') {{$type->name_en}} @else {{$type->name_ar}} @endif</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('property_type_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="City">* {{trans('lang.city')}}</label>
                                <select class="form-control {{ $errors->has('city_id') ? 'is-invalid' : ''}}" id="City" name="city_id">
                                    @foreach($cities as $city)
                                    <option {{$ad->city_id==$city->id?'selected':''}} value="{{$city->id}}">@if(app()->getLocale()=='en') {{$city->name_en}} @else {{$city->name_ar}} @endif</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('city_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="District">* {{trans('lang.select district')}}</label>
                                <select class="form-control {{ $errors->has('district_id') ? 'is-invalid' : ''}}" id="District" name="district_id">
                                    @foreach($districts as $district)
                                    <option {{$ad->district_id==$district->id?'selected':''}} value="{{$district->id}}">@if(app()->getLocale()=='en') {{$district->name_en}} @else {{$district->name_ar}} @endif</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('district_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="finishingLevel">* {{trans('lang.finishing_level')}}</label>
                                <select class="form-control {{ $errors->has('level_of_finished_id') ? 'is-invalid' : ''}}" id="finishingLevel" name="level_of_finished_id">
                                    @foreach($level_of_finished as $level)
                                    <option {{$ad->level_of_finished_id==$level->id?'selected':''}} value="{{$level->id}}">@if(app()->getLocale()=='en') {{$level->name_en}} @else {{$level->name_ar}} @endif</option>
                                    @endforeach
                                </select>
                                {!! $errors->first('level_of_finished_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                <label for="unitPrice">* {{trans('lang.price')}}</label>
                                <input value="{{$ad->price}}" type="number" name="price" class="form-control mb-3 {{ $errors->has('price') ? 'is-invalid' : ''}}" id="unitPrice" placeholder="{{trans('lang.price')}}">
                                {!! $errors->first('price', '<div class="invalid-feedback">:message</div>') !!}
                                <div class="custom-control custom-radio d-inline">
                                    <input {{$ad->price_negotiable == 1 ?'checked':''}} value="negotiable" type="radio" id="customRadio1" name="price_negotiable" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio1">{{trans('lang.negotiable')}}</label>
                                </div>
                                <div class="custom-control custom-radio d-inline">
                                    <input {{$ad->price_negotiable == 0 ?'checked':''}} value="final" type="radio" id="customRadio2" name="price_negotiable" class="custom-control-input">
                                    <label class="custom-control-label" for="customRadio2">{{trans('lang.final')}}</label>
                                </div>
                            </div>

                            <div class="form-group col-md-6 custom-file wow fadeInUp" data-wow-duration="1s" style="height: 90px;">* {{trans('lang.addimages')}} .png,jpg,jpeg
                                <input type="file" multiple="multiple" name="images[]" class="custom-file-input {{ $errors->has('images.*') ? 'is-invalid' : ''}} {{ $errors->has('images') ? 'is-invalid' : ''}}" id="customFile">
                                {!! $errors->first('images.*', '<div class="invalid-feedback">:message</div>') !!}
                                {!! $errors->first('images', '<div class="invalid-feedback">:message</div>') !!}
                                <label style="margin-left: 15px;width: 90%;top:32px; @if(app()->getLocale()=='en') @else text-align:left; @endif" class="custom-file-label" for="customFile">{{trans('lang.choose_file')}}</label>
                            </div>

                            <div class="form-group wow fadeInUp col-md-12 old-imgs" data-wow-duration="1s">
                                @foreach($ad->images as $image)
                                <div class="overlay">
                                    <a href="{{route('user.delete.image',$image->id)}}"><i class="far fa-times-circle"></i></a>
                                    <img src="{{env('AWS_URL') .$image->image}}" alt="">
                                </div>
                                @endforeach
                            </div>

                            <div class="form-group wow fadeInUp col-md-12" data-wow-duration="1s">
                                <label for="unitDescribe">* {{trans('lang.description')}}</label>
                                <textarea value="{{$ad->description}}" style="resize:none" class="summernote form-control {{ $errors->has('description') ? 'is-invalid' : ''}}" id="unitDescribe" rows="5" name="description">{{$ad->description}}</textarea>
                                {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
                            </div>

                            <div class="form-group wow fadeInUp col-md-12" data-wow-duration="1s">
                                <label for="search_on_map">{{trans('lang.location_on_map')}}</label>
                                <input type="text" class="form-control" id="search_on_map" placeholder="{{trans('lang.location_on_map')}}">
                            </div>

                            <div class="form-group wow fadeInUp col-md-12" data-wow-duration="1s">
                                <label>* {{trans('lang.location_on_map')}}</label>
                                <div id="map" style="width: 100%;height: 500px"></div>
                            </div>

                            <div class="col-12 py-4 mt-5 border-top">
                                <h4>* {{trans('lang.features')}}</h4>
                            </div>

                            <div class="row w-100">
                                <div class="form-group col-md-6 wow fadeInUp" data-wow-duration="1s">
                                    <label for="building year">* {{trans('lang.building_year')}}</label>
                                    <input value="{{$ad->building_year}}" type="text" name="building_year" class="form-control {{ $errors->has('building_year') ? 'is-invalid' : ''}}" id="Buildingyear" aria-describedby="emailHelp" placeholder="{{trans('lang.building_year')}}">
                                    {!! $errors->first('building_year', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                                <div class="form-group col-md-6 wow fadeInUp" data-wow-duration="1s">
                                    <label for="Size">* {{trans('lang.unit_size')}}</label>
                                    <input value="{{$ad->size}}" type="number" name="size" class="form-control {{ $errors->has('size') ? 'is-invalid' : ''}}" id="CSize" placeholder="{{trans('lang.unit_size')}}">
                                    {!! $errors->first('size', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                                <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                    <label for="BedroomsNo">* {{trans('lang.bedrooms_num')}}</label>
                                    <select class="form-control {{ $errors->has('bedrooms_num') ? 'is-invalid' : ''}}" id="BedroomsNo" name="bedrooms_num">
                                        <option {{$ad->bedrooms_num==0?'selected':''}} value="0">0</option>
                                        <option {{$ad->bedrooms_num==1?'selected':''}} value="1">1</option>
                                        <option {{$ad->bedrooms_num==2?'selected':''}} value="2">2</option>
                                        <option {{$ad->bedrooms_num==3?'selected':''}} value="3">3</option>
                                        <option {{$ad->bedrooms_num==4?'selected':''}} value="4">4</option>
                                        <option {{$ad->bedrooms_num==5?'selected':''}} value="5">5</option>
                                        <option {{$ad->bedrooms_num==6?'selected':''}} value="6">6</option>
                                        <option {{$ad->bedrooms_num==7?'selected':''}} value="7">7</option>
                                        <option {{$ad->bedrooms_num==8?'selected':''}} value="8">8</option>
                                    </select>
                                    {!! $errors->first('bedrooms_num', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                                <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                    <label for="bathroomsNo">* {{trans('lang.bathrooms_num')}}</label>
                                    <select class="form-control {{ $errors->has('bathrooms_num') ? 'is-invalid' : ''}}" id="bathroomsNo" name="bathrooms_num">
                                        <option {{$ad->bathrooms_num==0?'selected':''}} value="0">0</option>
                                        <option {{$ad->bathrooms_num==1?'selected':''}} value="1">1</option>
                                        <option {{$ad->bathrooms_num==2?'selected':''}} value="2">2</option>
                                        <option {{$ad->bathrooms_num==3?'selected':''}} value="3">3</option>
                                        <option {{$ad->bathrooms_num==4?'selected':''}} value="4">4</option>
                                        <option {{$ad->bathrooms_num==5?'selected':''}} value="5">5</option>
                                        <option {{$ad->bathrooms_num==6?'selected':''}} value="6">6</option>
                                        <option {{$ad->bathrooms_num==7?'selected':''}} value="7">7</option>
                                        <option {{$ad->bathrooms_num==8?'selected':''}} value="8">8</option>
                                    </select>
                                    {!! $errors->first('bathrooms_num', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                                <div class="form-group wow fadeInUp col-md-12" data-wow-duration="1s">
                                    <label for="ViewUnit">* {{trans('lang.unit_views')}}</label>
                                    <select class="form-control {{ $errors->has('unit_view_id') ? 'is-invalid' : ''}}" id="ViewUnit" name="unit_view_id">
                                        @foreach($unit_view_list as $view)
                                        <option {{$ad->unit_view_id==$view->id?'selected':''}} value="{{$view->id}}">@if(app()->getLocale()=='en') {{$view->name_en}} @else {{$view->name_ar}} @endif</option>
                                        @endforeach
                                    </select>
                                    {!! $errors->first('unit_view_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>

                                <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                    <label>* {{trans('lang.amenities_list')}}</label>
                                    @foreach($amenities as $amenitie)
                                    <div class="custom-control custom-checkbox">
                                        <input {{in_array($amenitie->id,$ad->amenitie_id)?'checked':''}} class="custom-control-input {{ $errors->has('amenities') ? 'is-invalid' : ''}}" name="amenities[]" type="checkbox" id="{{$amenitie->id}}" value="{{$amenitie->id}}">
                                        {!! $errors->first('amenities', '<div class="invalid-feedback">:message</div>') !!}
                                        <label class="custom-control-label mx-4" for="{{$amenitie->id}}">@if(app()->getLocale()=='en') {{$amenitie->name_en}} @else {{$amenitie->name_ar}} @endif</label>
                                    </div>
                                    @endforeach
                                </div>

                                <div class="form-group wow fadeInUp col-md-6" data-wow-duration="1s">
                                    <label>{{trans('lang.contact_way')}}</label>
                                    <div class="custom-control custom-checkbox">
                                        <input {{$ad->able_call=='true'?'checked':''}} type="checkbox" name="able_call" class="custom-control-input {{ $errors->has('able_call') ? 'is-invalid' : ''}}" id="customCheck4">
                                        {!! $errors->first('able_call', '<div class="invalid-feedback">:message</div>') !!}
                                        <label class="custom-control-label mx-4" for="customCheck4">{{trans('lang.recieve_calls')}}</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input {{$ad->able_chat=='true'?'checked':''}} type="checkbox" name="able_chat" class="custom-control-input {{ $errors->has('able_chat') ? 'is-invalid' : ''}}" id="customCheck5">
                                        {!! $errors->first('able_chat', '<div class="invalid-feedback">:message</div>') !!}
                                        <label class="custom-control-label mx-4" for="customCheck5">{{trans('lang.recieve_messages')}}</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input {{$ad->able_email=='true'?'checked':''}} type="checkbox" name="able_email" class="custom-control-input {{ $errors->has('able_email') ? 'is-invalid' : ''}}" id="customCheck6">
                                        {!! $errors->first('able_email', '<div class="invalid-feedback">:message</div>') !!}
                                        <label class="custom-control-label mx-4" for="customCheck6">{{trans('lang.recieve_emails')}}</label>
                                    </div>
                                </div>

                            </div>

                            <input class="btn btn-primary form-control mt-3 wow fadeInUp" data-wow-duration="1s" type="submit" title="{{trans('lang.edit')}}" value="{{trans('lang.edit')}}">
                        </form>

                    </div>
                </div>
            </div>


        </div>
    </div>
</section>

<section class="houses wow fadeInUp" data-wow-duration="1s">
    <img src="{{url('site')}}/images/footer.jpg" alt="">
</section>
@endsection
@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('.summernote'))
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {
            lat: JSON.parse($('#lat').val()),
            lng: JSON.parse($('#lng').val()),
        },
        zoom: 15
    });
    var marker = new google.maps.Marker({
        position: {
            lat: JSON.parse($('#lat').val()),
            lng: JSON.parse($('#lng').val()),
        },
        map: map,
        draggable: true
    });

    var searchBox = new google.maps.places.SearchBox(document.getElementById('search_on_map'));
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);
        }
        map.fitBounds(bounds);
        map.setZoom(15);
    });

    google.maps.event.addListener(marker, 'position_changed', function() {
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    });

    var searchBox = new google.maps.places.SearchBox(document.getElementById('search_on_map'));
    google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();
        var bounds = new google.maps.LatLngBounds();
        var i, place;
        for (i = 0; place = places[i]; i++) {
            bounds.extend(place.geometry.location);
            marker.setPosition(place.geometry.location);
        }
        map.fitBounds(bounds);
        map.setZoom(15);
    });

    google.maps.event.addListener(marker, 'position_changed', function() {
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    });
</script>
<script type="text/javascript">
    $('#City').change(function() {
        var city = $(this).val();
        var url = "{{route('city.districts',['city_id'=>':city','lang'=>app()->getLocale()])}}".replace(":city", city);
        $.ajax({
            url: url,
        }).done(function(response) {
            $('#District').html(response);
        });
    });
</script>
<script>
    $('#edit_form').submit(function() {
        $('#preloader').show();
    });
</script>
@if(Session::has('message'))
<script>
    $('#edited_success').show();
    $('#back_btn').click(() => {
        $('#edited_success').hide();
    });
</script>
@endif
@endsection