@extends('admin._layout.layout')

@section('seo_title', __('Blog posts'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Blog Posts')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Blog Posts')</li>
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

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Products</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.blog_posts.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new blog post')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" name="name" class="form-control" placeholder="Search by name">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Category')</label>
                                    <select class="form-control" name="blog_post_category_id">
                                        <option value="">@lang('--Choose Category --')</option>
                                        @foreach(\App\Models\BlogPostCategory::query()->orderBy('priority')->get() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Author')</label>
                                    <select class="form-control" name="author">
                                        <option value="">@lang('--Choose Author --')</option>
                                        @foreach(\App\Models\User::query()->orderBy('name')->get() as $author)
                                        <option value="{{$author->id}}">{{$author->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>@lang('Status')</label>
                                    <select class="form-control" name="status">
                                        <option value="">@lang('-- All --')</option>
                                        <option value="1">@lang('Enabled')</option>
                                        <option value="0">@lang('Disabled')</option>
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>@lang('On Index')</label>
                                    <select class="form-control" name="importance">
                                        <option value="">@lang('-- All --')</option>
                                        <option value="1">@lang('yes')</option>
                                        <option value="0">@lang('no')</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang('Tags')</label>
                                    <select class="form-control" multiple name="tag_ids">
                                        @foreach(\App\Models\Tag::query()->orderBy('name')->get() as $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All posts')</h3>
                        <div class="card-tools">
                            
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 5px">#</th>
                                    <th class="text-center">@lang('Thumb Photo')</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Important')</th>
                                    <th class="text-center">@lang('Category')</th>
                                    <th style="width: 20%;">@lang('Name')</th>
                                    <th class="text-center">@lang('Comments')</th>
                                    <th class="text-center">@lang('Views')</th>
                                    <th class="text-center">@lang('Author')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody> 

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<form class="modal fade" id="delete-modal" action="{{route('admin.blog_posts.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Delete blog post')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to delete blog post') <strong data-container="name"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-danger">@lang('Delete')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

<form class="modal fade" id="change-status-modal" action="{{route('admin.blog_posts.change_status')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Change status of blog post')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to change status of blog post') <strong data-container="name"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-danger">@lang('Change')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->

<form class="modal fade" id="change-importance-modal" action="{{route('admin.blog_posts.importance')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Change importance of blog post')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to change importance blog post') <strong data-container="name"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang('Cancel')</button>
                <button type="submit" class="btn btn-primary">@lang('Change')</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

@endsection

@push('footer_javascript')
<script type="text/javascript">

    $('#entities-filter-form [name="blog_post_category_id"]').select2({
        "theme": "bootstrap4"
    });

    $('#entities-filter-form [name="tag_ids"]').select2({
        "theme": "bootstrap4",
        "tags": true
    });

    $('#entities-filter-form [name]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });

    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault();
        
        entitiesDataTable.ajax.reload(null, true);
    });

    let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": "{{route('admin.blog_posts.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                
                dtData["name"] = $('#entities-filter-form [name="name"]').val();
                dtData["blog_post_category_id"] = $('#entities-filter-form [name="blog_post_category_id"]').val();
                dtData["author"] = $('#entities-filter-form [name="author"]').val();
                dtData["status"] = $('#entities-filter-form [name="status"]').val();
                dtData["importance"] = $('#entities-filter-form [name="importance"]').val();
                dtData["tag_ids"] = $('#entities-filter-form [name="tag_ids"]').val();
            }
        },
        "lengthMenu": [5, 10, 25, 50, 100, 250],
        "pageLength": 5,
        "order": [[9, "desc"]],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "photo2", "data": "photo2", "orderable": false, "searchable": false},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "important", "data": "important", "className": "text-center"},
            {"name": "blog_post_category_name", "data": "blog_post_category_name"},
            {"name": "name", "data": "name"},
            {"name": "comments", "data": "comments"},
            {"name": "views", "data": "views"},
            {"name": "author", "data": "author"},
            {"name": "created_at", "data": "created_at"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });



    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="change"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#change-status-modal [name="id"]').val(id);
        $('#change-status-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="importance"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#change-importance-modal [name="id"]').val(id);
        $('#change-importance-modal [data-container="name"]').html(name);
    });

    $('#delete-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);

            entitiesDataTable.ajax.reload(null, false);
        }).fail(function () {
            toastr.error("@lang('Greska prilikom brisanja')");
        });
    });

    $('#change-status-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);

            entitiesDataTable.ajax.reload(null, false);
        }).fail(function () {
            toastr.error("@lang('Greska prilikom mijenjanja statusa.')");
        });
    });

    $('#change-importance-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);

            entitiesDataTable.ajax.reload(null, false);
        }).fail(function () {
            toastr.error("@lang('Greska prilikom mijenjanja vaznosti.')");
        });
    });

</script>
@endpush