@extends('admin._layout.layout')

@section('seo_title', __('Add new blog post'))

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Add new blog post')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.blog_posts.index')}}">@lang('Blog posts')</a></li>
                    <li class="breadcrumb-item active">@lang('Add new blog post')</li>
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
                        <h3 class="card-title">@lang('Add new blog post')</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" id="entity-form" action="{{route('admin.blog_posts.insert')}}" method="post" enctype="multipart/form-data">
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
                                                @if($blogPostCategory->id == old('blog_post_category_id'))
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
                                            value="{{old('name')}}"
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
                                        >{{old('description')}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'description'])
                                    </div>
                                    <div class="form-group">
                                    <label>Important</label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                      <input 
                                          type="radio" 
                                          id="important-no" 
                                          name="important" 
                                          value="0"
                                          @if(0 == old('important'))
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
                                          @if(1 == old('important'))
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
                                                        is_array(old('tag_id'))
                                                        && in_array($tag->id, old('tag_id'))
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
                                        <input name="photo1" type="file" class="form-control @if($errors->has('photo1')) is-invalid @endif">
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo1'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Choose Thumb Photo')</label>
                                        <input name="photo2" type="file" class="form-control @if($errors->has('photo2')) is-invalid @endif">
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'photo2'])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('Details')</label>
                                        <textarea 
                                            name="details"
                                            class="form-control @if($errors->has('details')) is-invalid @endif" 
                                            placeholder="@lang('Enter details')"
                                        >{{old('details')}}</textarea>
                                        @include('admin._layout.partials.form_errors', ['fieldName' => 'details'])
                                    </div>
                                </div>
                                <div class="offset-md-1 col-md-5">
                                    
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
<script type="text/javascript">
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