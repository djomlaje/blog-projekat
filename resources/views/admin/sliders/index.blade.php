@extends('admin._layout.layout')

@section('seo_title', __('Sliders'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Sliders')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Sliders')</li>
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
                        <h3 class="card-title">@lang('All Sliders')</h3>
                        <div class="card-tools">
                            <form style="display: none;" id="change-priority-form" class="btn-group" action="{{route('admin.sliders.change_priorities')}}" method="post">
                                @csrf
                                <input type="hidden" name="priorities" value="">

                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                    @lang('Save Order')
                                </button>
                                <button type="button" data-action="hide-order" class="btn btn-outline-danger">
                                    <i class="fas fa-remove"></i>
                                    @lang('Cancel')
                                </button>
                            </form>
                            <button data-action="show-order" class="btn btn-outline-secondary">
                                <i class="fas fa-sort"></i>
                                @lang('Change Order')
                            </button>
                            <a href="{{route('admin.sliders.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new Slider')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 10%">@lang('Status')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th style="width: 30%;">@lang('Name')</th>
                                    <th style="width: 30%;">@lang('Description')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Last Change')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($sliders as $slider)
                                <tr data-id="{{$slider->id}}">
                                    <td>
                                        <span style="display: none;" class="btn btn-outline-secondary handle">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$slider->id}}
                                    </td>
                                    @if($slider->status == 1) 
                                    <td class="text-center">
                                        <span class="text-success">enabled</span>
                                    </td>
                                    @else 
                                    <td class="text-center">
                                        <span class="text-danger">disabled</span>
                                    </td>
                                    @endif
                                    <td class="text-center" style="width: 5%">
                                        <img src="{{$slider->getPhotoUrl()}}" style="max-width: 80px;">
                                    </td>
                                    <td>
                                        <strong>{{$slider->name}}</strong>
                                    </td>
                                    <td style="width: 10%;">
                                        {{\Str::limit($slider->description, 40)}}
                                    </td>
                                    <td class="text-center">{{$slider->created_at}}</td>
                                    <td class="text-center">{{$slider->updated_at}}</td>
                                    <td class="text-center">
                                        @include('admin.sliders.partials.actions')
                                    </td>
                                </tr>
                                @endforeach
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

<form class="modal fade" id="delete-modal" action="{{route('admin.sliders.delete')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Delete Slider')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang('Are you sure you want to delete slider') <strong data-container="name"></strong>?</p>
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
<!-- /.modal -->

<form action="{{route('admin.sliders.change_status')}}" method="post" class="modal fade" id="enable-modal">
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

<form action="{{route('admin.sliders.change_status')}}" method="post" class="modal fade" id="disable-modal">
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

    $('#entities-list-table').on('click', '[data-action="delete"]', function (e) {

        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');

        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
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

    $('#enable-modal').on('submit', function (e) {
        e.preventDefault();

        $(this).modal('hide');

        $.ajax({
            "url": $(this).attr('action'),
            "type": "post",
            "data": $(this).serialize()
        }).done(function (response) {

            toastr.success(response.system_message);
            location.reload();
        }).fail(function () {
            toastr.error("@lang('Something went wrong. Slider status cannot be changed')");
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
            location.reload();
        }).fail(function () {
            toastr.error("@lang('Something went wrong. Slider status cannot be changed.')");
        });
    });


    $('#sortable-list').sortable({
        handle: ".handle",
        "update": function (event, ui) {

            let priorities = $('#sortable-list').sortable('toArray', {
                "attribute": "data-id"
            });

            $('#change-priority-form [name="priorities"]').val(priorities.join(','));
        }
    });

    $('[data-action="show-order"]').on('click', function (e) {

        $('[data-action="show-order"]').hide();

        $('#change-priority-form').show();

        $('#sortable-list .handle').show();
    });

    $('[data-action="hide-order"]').on('click', function (e) {

        $('[data-action="show-order"]').show();

        $('#change-priority-form').hide();

        $('#sortable-list .handle').hide();

        $('#sortable-list').sortable('cancel');
    });

</script>
@endpush