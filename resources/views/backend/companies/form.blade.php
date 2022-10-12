@extends('backend/layout')
@section('content')
<section class="content-header">
    <h1>Company</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{ $company->page_title }}</li>
    </ol>
</section>
<!-- Main content -->
<section id="main-content" class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">{{ $company->page_title }}</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{ Form::open(array('route' => $company->form_action, 'method' => 'POST', 'files' => true, 'id' => 'company-form')) }}
                    {{ Form::hidden('id', $company->id, array('id' => 'company_id')) }}
                    <div id="form-name" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Name</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('name', $company->name, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num, maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('name', $company->name, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num, maxSize[255]]')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-email" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Email</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::email('email',  $company->email, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::email('email', $company->email, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num')) }}
                            @endif
                        </div>
                    </div>
                    <div id="form-postcode" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Postcode</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-content">
                            <!-- <form action=""></form> -->
                            @if($company->page_type == 'create')
                            <!-- add, pakai route add -->
                            <!-- {{ Form::open(array('route' => 'admin.company.add', 'method' => 'get', 'id' => 'postcodeSelection')) }} -->
                            {{ Form::text('postcode', $company->postcode, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'postcodeInput', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::open(array('route' => $company->form_action, 'method' => 'get', 'id' => 'postcodeSelection')) }}
                            {{ Form::text('postcode', $company->postcode, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'postcodeInput')) }}
                            @endif
                        </div>
                        <div class="col-xs-2 col-sm-2 col-md-1 col-lg-1 col-content">
                            <button name="search" form="postcodeSelection" id="search-button" class="btn btn-primary">Search</button>
                        </div>
                        <!-- {{ Form::close() }} -->
                    </div>

                    <div id="form-prefecture" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Prefecture</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::select('prefecture_id', $prefecture_id, null, array('class' => 'form-control validate[required, int]', 'id' => 'prefectureSelect', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::select('prefecture_id', $prefecture_id, $company->prefecture_id, array('class' => 'form-control validate[required, int]', 'id' => 'prefectureSelectEdit')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-city" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">City</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            <!-- setelah apply search ada beberapa input field yg tidak kebaca -->
                            <!-- {{ Form::text('city', ($search ? $search->city : '$company->city'), array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'cityInput', 'data-prompt-position' => 'bottomLeft:0,11')) }} -->
                            {{ Form::text('city', $company->city, array('class' => 'form-control validate[required, regex[/^[\w-]*$/],alpha_num', 'id' => 'cityInput', 'data-prompt-position' => 'bottomLeft:0,11')) }}

                            @else
                            {{ Form::text('city', $company->city, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'cityInputEdit')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-local" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Local</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            <!-- {{ Form::text('local', ($search ? $search->local : '$company->local'), array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'localInput', 'data-prompt-position' => 'bottomLeft:0,11')) }} -->
                            {{ Form::text('local', $company->local, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'localInputEdit', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('local', $company->local, array('class' => 'form-control validate[required, regex[/^[\w-]*$/], alpha_num', 'id' => 'localInputEdit')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-stree-address" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Street Address</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('street_adrress', $company->street_adrress, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('street_adrress', $company->street_adrress, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-business-hour" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Business Hour</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('business_hour', $company->business_hour, array('class' => 'form-control isTimepicker validate[regex[/^[\w-]*$/]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('business_hour', $company->business_hour, array('class' => 'form-control validate[regex[/^[\w-]*$/]')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-regular-holiday" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Regular Holiday</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('regular_holiday', $company->regular_holiday, array('class' => 'form-control validate[regex[/^[\w-]*$/]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('regular_holiday', $company->regular_holiday, array('class' => 'form-control validate[regex[/^[\w-]*$/]')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-phone" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Phone</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('phone', $company->phone, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('phone', $company->phone, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-fax" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">Fax</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('fax', $company->fax, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('fax', $company->fax, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-url" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">URL</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('url', $company->url, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num, maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('url', $company->url, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num, maxSize[255]]')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-license-number" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <strong class="field-title">License Number</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::text('license_number', $company->license_number, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num, maxSize[255]]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            {{ Form::text('license_number', $company->license_number, array('class' => 'form-control validate[regex[/^[\w-]*$/], alpha_num, maxSize[255]]')) }}
                            @endif
                        </div>
                    </div>

                    <div id="form-image" class="form-group">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2 col-header">
                            <span class="label label-danger label-required">Required</span>
                            <strong class="field-title">Image</strong>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10 col-content">
                            @if($company->page_type == 'create')
                            {{ Form::file('image', $company->image, array('class' => 'form-control validate[required]', 'data-prompt-position' => 'bottomLeft:0,11')) }}
                            @else
                            <!-- belum show image -->
                            {{ Form::file('image', array('class' => 'form-control validate[required]')) }}
                            @endif
                        </div>
                    </div>
                    {{ Form::close() }}

                    <div id="form-button" class="form-group no-border">
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center" style="margin-top: 20px;">
                            <button type="submit" name="submit" id="send" form="company-form" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
@endsection

@section('title', 'Company | ' . env('APP_NAME',''))

@section('body-class', 'custom-select')

@section('css-scripts')
@endsection

@section('js-scripts')
<script src="{{ asset('js/backend/companies/form.js') }}"></script>
<script src="{{ asset('bower_components/bootstrap/js/tooltip.js') }}"></script>
<!-- validationEngine -->
<script src="{{ asset('js/backend/backend.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine-en.js') }}"></script>
<script src="{{ asset('js/3rdparty/validation-engine/jquery.validationEngine.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#postcodeInput').change(function() {
            $('#search-button').click(function() {});
        });
    });
</script>
</script>
@endsection