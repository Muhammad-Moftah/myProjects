@extends('site.master')
@section('body')

<section class="latest-prop py-5">
    <div class="container mt-5">
        <div class="title">
            <h1 class="removeafterborder text-center">@if(isset($pageTitle)) {{$pageTitle}} @endif</h1>
            @if(app()->getLocale()=='ar')
            <h2 class="text-center">شقق معروضة للبيع نقدا وبالتقسيط في القاهرة و الاسكندرية و الجيزة</h2>
            <p> شوف وقارن بين اكثر من 1500 شقة معروضة للبيع في مصر - اختار الشقة المناسبة لك من حيث السعر والمساحة والمنطقة وتواصل مع المعلن مباشرة الآن </p>
            @endif
        </div>
        @if(isset($cities))
        @include('site.layouts.mini_search')
        @endif
        <div class="row py-0">
            @if(count($ads)>0)
            @foreach($ads as $ad)
            <div class="col-md-4 my-3 wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                <div class="card">
                    <span class="sale bg-danger">@if(app()->getLocale()=='en') {{$ad->offer_type->title_en}} @else {{$ad->offer_type->title_ar}} @endif</span>
                    @if(count($ad->images)>0)
                    <a title="{{$ad->title}}" href="{{route('user.ad.get',['id'=>$ad->id,'lang'=>app()->getLocale(),'ad_name'=>str_replace('+','-',urlencode(str_replace('/','',$ad->title)))])}}">
                        <img class="card-img-top" src="{{env('AWS_URL') .$ad->images[0]['image']}}" alt="{{$ad->title}}">
                    </a>
                    @endif
                    <div class="card-body">
                        <a title="{{$ad->title}}" href="{{route('user.ad.get',['id'=>$ad->id,'lang'=>app()->getLocale(),'ad_name'=>str_replace('+','-',urlencode(str_replace('/','',$ad->title)))])}}">
                            <p class="text-secondary text-center m-0">{{$ad->title}}</p>
                        </a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><i class="fas fa-map-marker-alt"></i> @if(app()->getLocale()=='en') {{$ad->city->name_en}} @else {{$ad->city->name_ar}} @endif</small>
                        <button data-href="{{route('user.add.compare',$ad->id)}}" class="btn btn-success" {{$ad->checkIfInCompare()?'disabled':''}} title="Add to compare"> <i class="fas fa-table"></i></button>
                        <a href="{{route('user.favourite',['id'=>$ad->id,'lang'=>app()->getLocale()])}}" class="{{$ad->isFavourite()?'fas':'far'}} fa-star fa-transparent fav-button float-right mx-1" title="Add to favorite"></a>
                        <small class="text-muted float-right"><span class="text-success font-weight-bold"> {{$ad->price}} </span> @if(app()->getLocale()=='en') {{$ad->country->currency_en}} @else {{$ad->country->currency_ar}} @endif</small>
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <p>{{trans('lang.no ads')}}</p>
            @endif
        </div>
        <div style="text-align:center;">
            {{ $ads->appends(getRequestBetweenPages())->render("pagination::bootstrap-4") }}
        </div>
    </div>
</section>
@endsection
