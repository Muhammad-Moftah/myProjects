@extends('admin.layouts.app')

@section('title',trans("lang.$module_name")." - ".trans("lang.".end($breadcrumb)))

@section('content')

    <!-- Page-Title -->
    @section('breadcrumb')
        @foreach ($breadcrumb as $bread)
            @if ($loop->last)
                <li class="active">@lang("lang.$bread")</li>
            @else   
                <li><a href="{{ url(ADMIN_PATH."/$route") }}">@lang("lang.$bread")</a></li>
            @endif
        @endforeach
    @stop
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"> {!!Lang::get("lang.$bread")!!} </h3>
                    </div>
                    {!! Form:: open(['method'=>'POST','route' => "$route.store", 'files'=>true,'class' => 'ajax-form-request']) !!}
                        @include ("$base_view.$path.form",['submitButton' => Lang::get('lang.create')])
                    {!! Form::close() !!}         
                </div>
            </div>
            <!-- END PAGE CONTENT WRAPPER -->                                                
        </div>            
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->

@stop