@extends('admin._layout.layout')

@section('seo_title', __('Edit Slider'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit Slider')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.sliders.index')}}">@lang('Sliders')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit Slider')</li>
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
                        <h3 class="card-title">
                            @lang('Edit Slider')
                            #{{$slider->id}}
                            -
                            {{$slider->name}}

                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form 
                        id="entity-form"
                        role="form" 
                        action="{{route('admin.sliders.update', ['slider' => $slider->id])}}" 
                        method="post" 
                        enctype="multipart/form-data"
                        >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input 
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="@lang('Enter name')"
                                            name="name"
                                            value="{{old('name', $slider->name)}}"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('Url Title')</label>
                                        <input 
                                            type="text" 
                                            class="form-control @if($errors->has('url_title')) is-invalid @endif" 
                                            placeholder="@lang('Enter url title')"
                                            name="url_title"
                                            value="{{old('url_title', $slider->urlTitle)}}"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'url_title'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Url')</label>
                                        <input 
                                            type="text" 
                                            class="form-control @if($errors->has('url')) is-invalid @endif" 
                                            placeholder="@lang('Enter Url')"

                                            name="url"
                                            value="{{old('url', $slider->url)}}"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'url'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Desription')</label>
                                        <textarea 
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="@lang('Enter description')"
                                            name="description"
                                            >{{old('description', $slider->description)}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'description'])
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('Choose New Photo')</label>
                                        <input 
                                            name="photo"
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif"
                                            >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo'])
                                    </div>
                                </div>
                                <div class="offset-md-3 col-md-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>@lang('Photo')</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        data-photo="photo"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        @lang('Delete Photo')
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img src="{{$slider->getPhotoUrl()}}" alt="" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <a class="btn btn-outline-secondary" href="{{route('admin.sliders.index')}}">@lang('Cancel')</a>
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
    $('#entity-form').on('click', '[data-action="delete-photo"]', function (e) {
        e.preventDefault();

        let photo = $(this).attr('data-photo');

        $.ajax({
            "url": "{{route('admin.sliders.delete_photo', ['slider' => $slider->id])}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}",
                "photo": photo
            }
        }).done(function (response) {

            toastr.success(response.system_message);

            $('img[data-container="photo"]').attr('src', response.photo_url);
            location.reload();
        }).fail(function () {
            toastr.error('Error while deleteing photo');
        });
    });

    $('#entity-form').validate({
        rules: {
            "name": {
                "required": true
            }
        },
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