@extends('admin.layouts.app')

@section('title',trans("lang.CompanyPackages")." - ".trans("lang.".end($breadcrumb)))

@section('content')

<!-- Page-Title -->
@section('breadcrumb')
@foreach ($breadcrumb as $bread)
@if ($loop->remaining == 1)
<li><a href="{{ url("company_package/$route") }}">@lang("lang.$bread")</a></li>
@elseif($loop->last)
<li class="active">@lang("lang.$bread")</li>
@else
<li>@lang("lang.$bread")</li>
@endif
@endforeach
@stop
<!-- PAGE CONTENT WRAPPER -->

<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title pull-left"><b><i class="icon-list head-icon"></i>{!!Lang::get("lang.$bread")!!}</b></h4>
            <br>
            <div class="clearfix"></div>
            <div class="col-md-12">
                {!! Form::open(['method' => 'get']) !!}
                <div class="form-group col-md-3">
                    {!! Form::label('search', 'Search') !!}
                    <div class="form-line">
                        <input type="text" value="{{request()->search}}" class="form-control" name="search" placeholder="search">
                    </div>
                </div>
                <div class="btn-group col-md-2">

                    {!! Form::submit("Search", ['class' => 'btn btn-success btn-block', 'style'=>'margin-top: 25px;']) !!}
                </div>

                {!! Form::close() !!}
            </div>
            <div class="m-separator m-separator--dashed d-xl-none"></div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @foreach ($columns as $column)
                        <th>{{ trans("lang.$column") }}</th>
                        @endforeach
                        <td>@lang('lang.name')</td>
                        <th>@lang('lang.Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @include("$base_view.$path.loop_package")
                </tbody>
            </table>
            {{ $rows->appends(getRequestBetweenPages())->render("pagination::bootstrap-4") }}

        </div>
    </div>
</div>
@stop