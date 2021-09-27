@extends('admin._layout.layout')

@section('seo_title', __('Add new user'))

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Users Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">@lang('Users')</a></li>
                    <li class="breadcrumb-item active">@lang('Users Form')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Enter data for the user')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form"
                        action="{{route('admin.users.insert')}}"
                        method="post"
                        enctype="multipart/form-data"
                        role="form"
                    >
                    @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Email')</label>
                                        <div class="input-group">
                                            <input 
                                                name="email"
                                                value="{{old('email')}}"
                                                type="email" 
                                                class="form-control @if($errors->has('email')) is-invalid @endif" 
                                                placeholder="Enter email"
                                            >
                                            
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    @
                                                </span>
                                            </div>
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'email'])
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input 
                                            name="name"
                                            value="{{old('name')}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name"
                                        >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <div class="input-group">
                                            <input 
                                                name="phoneNumber"
                                                value="{{old('phoneNumber')}}"
                                                type="text" 
                                                class="form-control @if($errors->has('phoneNumber')) is-invalid @endif" 
                                                placeholder="Enter phone"
                                            >
                                            @include('admin._layout.partials.form_errors', ['fieldName' => 'phoneNumber'])
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('Choose New Photo')</label>
                                        <input 
                                            name="photo"
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                        >
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                            <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

@push('footer_javascript')
<script type="text/javascript">

    $('#entity-form [name="brand_id"]').select2({
        "theme": "bootstrap4"
    });

    $('#entity-form [name="user_category_id"]').select2({
        "theme": "bootstrap4"
    });

    $('#entity-form').validate({
        rules: {
            "email": {
                "required": true
            },
            "name": {
                "required": true
            }

        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });

</script>
@endpush

