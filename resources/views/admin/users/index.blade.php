@extends('admin._layout.layout')

@section('seo_title', __('Users'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Users')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Users')</li>
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
                        <h3 class="card-title">@lang('Search Users')</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.users.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new User')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-1 form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">@lang('enabled')</option>
                                        <option value="0">@lang('disabled')</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Email')</label>
                                    <input type="text" class="form-control" placeholder="Search by email" name="email">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Name')</label>
                                    <input type="text" class="form-control" placeholder="Search by name" name="name">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang('Phone')</label>
                                    <input type="text" class="form-control" placeholder="Search by phone" name="phoneNumber">
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
                        <h3 class="card-title">@lang('All Users')</h3>
                        <div class="card-tools">


                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="entities-list-table" class="table table-bordered">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 20px">@lang('Status')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Phone')</th>
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

<form action="{{route('admin.users.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Delete User')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to delete user?')</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->

<form action="{{route('admin.users.change_status')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Status change</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to change status to "ENABLED"?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Enable</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

<form action="{{route('admin.users.change_status')}}" method="post" class="modal fade" id="disable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Status change</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to change status to "DISABLED"?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Disable</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>

@endsection

@push('head_links')
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('footer_javascript')
<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">


    $('#entities-filter-form [name]').on('change keyup', function (e) {
        $('#entities-filter-form').trigger('submit');
    });

    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault();

        entitiesDataTable.ajax.reload(null, true);
    });

    let entitiesDataTable = $('#entities-list-table').DataTable({
        "searching": false,
        "paging": false,
        "processing": true,
        "serverSide": true,
        "ajax": {"serverSide": true,
            "url": "{{route('admin.users.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";

                dtData["status"] = $('#entities-filter-form [name="status"]').val();
                dtData["photo"] = $('#entities-filter-form [name="photo"]').val();
                dtData["email"] = $('#entities-filter-form [name="email"]').val();
                dtData["name"] = $('#entities-filter-form [name="name"]').val();
                dtData["phoneNumber"] = $('#entities-filter-form [name="phoneNumber"]').val();
            }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],
        "order": [[7, 'desc']],
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "status", "data": "status", "className": "text-center"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "email", "data": "email"},
            {"name": "name", "data": "name"},
            {"name": "phoneNumber", "data": "phoneNumber", "orderable": false},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });

    $('#entities-list-table').on('click', '[data-action="change"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#enable-modal [name="id"]').val(id);
        $('#enable-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="change"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });

    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
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
            toastr.error("@lang('Something went wrong. User cannot delete himself.')");
        });
    });

    $('#enable-modal').on('submit', function (e) {
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
            toastr.error("@lang('Something went wrong. User cannot change his status.')");
        });
    });
    $('#disable-modal').on('submit', function (e) {
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
            toastr.error("@lang('Something went wrong. User cannot change his status.')");
        });
    });



</script>
@endpush