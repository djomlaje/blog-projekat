@extends('admin._layout.layout')

@section('seo_title', __('Edit blog post'))

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Edit blog post')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.blog_posts.index')}}">@lang('Blog posts')</a></li>
                    <li class="breadcrumb-item active">@lang('Edit blog post')</li>
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
                            @lang('Editing blog post')
                            -
                            #{{$blogPost->id}}
                            -
                            <strong>{{$blogPost->name}}</strong>
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="entity-form" action="{{route('admin.blog_posts.update', ['blogPost' => $blogPost->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="blog_post_user_id" value="{{\Auth::user()->id}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Blog Post Category')</label>
                                        <select 
                                            name="blog_post_category_id" 
                                            class="form-control @if($errors->has('blog_post_category_id')) is-invalid @endif"
                                            >
                                            <option value="">-- Choose Category --</option>
                                            @foreach($blogPostCategories as $blogPostCategory)
                                            <option 
                                                value="{{$blogPostCategory->id}}"
                                                @if($blogPostCategory->id == old('blog_post_category_id', $blogPost->blog_post_category_id))
                                                selected
                                                @endif
                                            >{{$blogPostCategory->name}}</option>
                                            @endforeach
                                        </select>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'blog_post_category_id'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Name')</label>
                                        <input 
                                            name="name"
                                            value="{{old('name', $blogPost->name)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="@lang('Enter name')"
                                        >
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Description')</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="@lang('Enter Description')"
                                        >{{old('description', $blogPost->description)}}</textarea>
                                    </div>
                                    <div class="form-group">
                                    <label>Important</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input 
                                          type="radio" 
                                          id="important-no" 
                                          name="important" 
                                          value="0"
                                          @if(0 == old('important', $blogPost->important))
                                          checked
                                          @endif
                                          class="custom-control-input"
                                       >
                                      <label class="custom-control-label" for="important-no">No</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input 
                                          type="radio" 
                                          id="important-yes" 
                                          name="important" 
                                          value="1"
                                          @if(1 == old('important', $blogPost->important))
                                          checked
                                          @endif
                                          class="custom-control-input">
                                      <label class="custom-control-label" for="important-yes">Yes</label>
                                    </div>
                                    <div style="display: none;" class="form-control @if($errors->has('important')) is-invalid @endif"></div>
                                    @include('admin._layout.partials.form_errors', ['fieldName' => 'important'])
                                  </div>

                                    <div class="form-group">
                                        <label>@lang('Tags')</label>
                                        <div>
                                            @foreach($tags as $tag)
                                            <div class="form-check form-check-inline">
                                                <input 
                                                    name="tag_id[]" 
                                                    value="{{$tag->id}}"
                                                    class="form-check-input @if($errors->has('tag_id')) is-invalid @endif" 
                                                    type="checkbox" 
                                                    multiple
                                                    id="tag-checkbox-{{$tag->id}}"
                                                    @if(
                                                        is_array(old('tag_id', $blogPost->tags->pluck('id')->toArray()))
                                                        && in_array($tag->id, old('tag_id', $blogPost->tags->pluck('id')->toArray()))
                                                    )
                                                    checked
                                                    @endif
                                                    >
                                                <label 
                                                    class="form-check-label" 
                                                    for="tag-checkbox-{{$tag->id}}"
                                                    >{{$tag->name}}</label>
                                                @include('admin._layout.partials.form_errors', ['fieldName' => 'tag_id'])
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang('Choose New Photo')</label>
                                        <input name="photo1" type="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Choose New Thumb Photo')</label>
                                        <input name="photo2" type="file" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Details')</label>
                                        <textarea 
                                            name="details"
                                            class="form-control @if($errors->has('details')) is-invalid @endif" 
                                            placeholder="@lang('Enter details')"
                                        >{{old('details', $blogPost->details)}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'details'])
                                    </div>
                                </div>
                                <div class="offset-md-1 col-md-5">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('Photo')</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        data-photo="photo1"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        @lang('Delete Photo')
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$blogPost->getPhoto1Url()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container="photo1"
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>@lang('Thumb Photo')</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        data-photo="photo2"
                                                    >
                                                        <i class="fas fa-remove"></i>
                                                        @lang('Delete Thumb Photo')
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$blogPost->getPhoto1ThumbUrl()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container="photo2"
                                                        >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang('Save')</button>
                            <a href="{{route('admin.blog_posts.index')}}" class="btn btn-outline-secondary">@lang('Cancel')</a>
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
<!-- CkEditor4 -->
<script src="{{url('/themes/admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>

<script type="text/javascript">
    
    $('#entity-form [name="details"]').ckeditor({
        "height": "400px",
        "filebrowserBrowseUrl": "{{route('elfinder.ckeditor')}}"
    });
    
    $('#entity-form').on('click', '[data-action="delete-photo"]', function (e) {
        e.preventDefault();
        
        let photo = $(this).attr('data-photo');
        
        $.ajax({
            "url": "{{route('admin.blog_posts.delete_photo', ['blogPost' => $blogPost->id])}}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}",
                "photo": photo
            }
        }).done(function (response) {
            
            toastr.success(response.system_message);
            
            $('img[data-container="' + photo + '"]').attr('src', response.photo_url);
            
        }).fail(function() {
            
            toastr.error('Error while deleting photo');
            
        });
    });
    
    $('#entity-form [name="blog_post_category_id"]').select2({
        "theme": "bootstrap4"
    });
    
    $('#entity-form').validate({
        rules: {
            "blog_post_category_id": {
                "required": true
            },
            "name": {
                "required": true,
                "minlength": 2,
                "maxlength": 255
            },
            "description": {
                "maxlength": 2000
            },
            "important": {
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