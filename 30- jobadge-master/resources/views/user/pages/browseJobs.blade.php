@extends('master')
@section('body')
<div class="container-blog-posts browse-jobs-header">
    <div class="blog-posts-header">
        <div class="container">
            <h1 class="section-title"><span> Browse all available jobs in Egypt </span></h1>
        </div>
    </div>
</div>

<div class="container-post-jobs py-0">
    <div class="container">
        <div class="text-muted mt-5">
            <p class="mb-1"> Firstly and most importantly, we are all about you! We are about making your job
                search experience easier, faster and more effective. </p>
            <p class="mb-1">Our easy-to follow search steps and tips will help you make your job search the best it
                can be. Start searching now and apply to your preferred job! </p>
            <p class="mb-1"> Get Started. Select your search criteria below. </p>
            <p class="mb-1"> You can select as many as you like. The more filters you select, the more refined your
                initial search result will be.</p>
        </div>

        <div class="blog-posts-header">
            <section class="container-search-job p-0 mt-5" style="border-radius: 20px;">
                <div class="search-job">
                    <div class="search-job-form">
                        <form action="{{route('user.browse')}}" method="GET">
                            <div class="row no-gutters">
                                <div class="col-12 col-md-10">
                                    <div class="search-job-form-field first">
                                        <label for="searchJob" class="search-job-form-field-label"><span class="icon icon-search"></span></label>

                                        <input type="text" name="search" id="searchJob" class="search-job-form-field" placeholder="Search for Jobs..." value="@if(request()->has('search')){{ request()->search }}@endif">
                                    </div>
                                </div>
                                <div class="col-12 col-md-2">
                                    <button type="submit" class="search-job-form-button w-100">SEARCH</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            @include('admin.layouts.errors')
        </div>

        <div class="post-jobs-filter">
            <div class="row no-gutters align-items-center">
                <div class="col-8 col-md-10 col-xl-12">

                    <form id="searchForm" action="{{route('user.browse')}}" method="get">
                        <div class="row no-gutters">
                            {{-- {{dd(request('search'))}} --}}
                            @if( request()->has('search') )
                            <input type="hidden" name="search" value="{{ request()->search}}" />
                            @endif

                            {{-- Categories --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select first">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">Category</div>
                                    <div class="select-value">
                                        <select name="category_id" class="select-field">
                                            <option {{request('category_id')==''?'selected':''}} value="">All CATEGORIES
                                            </option>
                                            @foreach($categories as $category)
                                            <option {{request('category_id')==$category->id?'selected':''}} value="{{$category->id}}">{{$category->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Job Level --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">Job level</div>
                                    <div class="select-value">
                                        <select name="joblevel_id" class="select-field">
                                            <option {{request('joblevel_id')==''?'selected':''}} value="">All Job Levels
                                            </option>
                                            @foreach($joblevels as $joblevel)
                                            <option {{request('joblevel_id')==$joblevel->id?'selected':''}} value="{{$joblevel->id}}">{{$joblevel->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- Job Type --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">Job Type</div>
                                    <div class="select-value">
                                        <select name="jobtype_id" class="select-field">
                                            <option {{request('jobtype_id')==''?'selected':''}} value="">All Job Types
                                            </option>
                                            @foreach($jobtypes as $jobtype)
                                            <option {{request('jobtype_id')==$jobtype->id?'selected':''}} value="{{$jobtype->id}}">{{$jobtype->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- Date Posted --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">Date Posted</div>
                                    <div class="select-value">
                                        <select name="post_date" class="select-field">
                                            <option {{request('post_date')==''?'selected':''}} value="">All Dates
                                            </option>
                                            <option {{request('post_date')=='within_24_hours'?'selected':''}} value="within_24_hours">Past 24 Hours</option>
                                            <option {{request('post_date')=='within_1_week'?'selected':''}} value="within_1_week">Past Week</option>
                                            <option {{request('post_date')=='within_1_month'?'selected':''}} value="within_1_month">Past Month</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- Country  --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">Country</div>
                                    <div class="select-value">
                                        <select name="country_id" class="select-field">
                                            <option {{request('country_id')==''?'selected':''}} value="">All Countries
                                            </option>
                                            @foreach($countries as $country)
                                            <option {{request('country_id')==$country->id?'selected':''}} value="{{$country->id}}">{{$country->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- City  --}}
                            <div class="col-12 col-md-2">
                                <div class="post-jobs-filter-select">
                                    <span class="icon icon-down"></span>
                                    <div class="select-title">City</div>
                                    <div class="select-value">
                                        <select name="city_id" class="select-field">
                                            <option {{request('city_id')==''?'selected':''}} value="">All Cities
                                            </option>
                                            @foreach($cities as $city)
                                            <option {{request('city_id')==$city->id?'selected':''}} value="{{$city->id}}">{{$city->name_en}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="post-job-list-view">
            @foreach($jobs as $job)
            <div class="list-view-item">
                <div class="row align-items-center no-gutters">
                    <div class="col-12 col-md-5 col-xl-7">
                        <div class="item-post-job">
                            @if($job->confidential==0)
                            <a href="{{route('user.company.get' , ['slug' => $job->company->slug])}}"><img src="{{$job->company->getCompanyLogo()}}" alt="Careers at  {{$job->company->name}} | Jobadge" class="item-logo"></a>
                            @else
                            <img src="{{$job->company->getCompanyDefaultLogo()}}" alt="Careers at {{$job->company->name}} | Jobadge" class="item-logo">
                            @endif
                            <div class="item-post">
                                <h4 class="post-name"><a href="{{route('user.get.job',$job->slug)}}">{{$job->title}}</a>
                                </h4>
                                @if($job->confidential==0)
                                <a style="display: block; color: #706e52;" href="{{route('user.company.get',$job->company->slug)}}">{{$job->company->name}}</a>
                                @else
                                <span style="display:block; color: #706e52;">Confidential</span>
                                @endif
                                <span class="post-date">{{$job->created_at->diffForHumans()}}</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-md-7 col-xl-5">
                        <div class="row no-gutters">

                            <div class="col-12 col-md-5">
                                <div class="item-position">
                                    <img src="{{ asset('site/images/icon/location.png')}}" class="mx-1" width="15" alt="">
                                    <span class="position-text">
                                        @if($job->city && $job->country)
                                        {{$job->city->name_en}},
                                        {{$job->country->name_en}}
                                        @else
                                        {{$job->company->city->name_en}},
                                        {{$job->company->country->name_en}}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="item-time-type">
                                    <img src="{{ asset('site/images/icon/time.png')}}" class="mx-1" width="18" alt="">
                                    <span class="type-text">{{$job->jobtype->name_en}}</span>
                                </div>
                            </div>

                            <div class="col-12 col-md-3 text-sm-center text-md-right">
                                <a href="{{route('user.get.job',$job->slug)}}" class="button-outline"><span>APPLY</span></a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            @endforeach
        </div>

        @if(count($jobs)==0)
        <div class="row justify-content-center my-4">
            <div class="alert alert-danger" role="alert">
                No Jobs Found for your search
            </div>
        </div>
        @endif
        <div class="row justify-content-center">
            {{ $jobs->appends(getRequestBetweenPages())->render() }}
        </div>

    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('site/js/search.js')}}"></script>
@endsection