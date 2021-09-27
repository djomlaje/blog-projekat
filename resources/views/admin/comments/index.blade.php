@extends('admin._layout.layout')

@section('seo_title', __('Comments'))

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
                    <li class="breadcrumb-item active">@lang('Comments')</li>
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
                        <h3 class="card-title">@lang('All Comments')</h3>
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang('Status')</th>
                                    <th class="text-center">@lang('Blog Post')</th>
                                    <th class="text-center">@lang('Name')</th>
                                    <th style="width: 30%;">@lang('Description')</th>
                                    <th class="text-center">@lang('Created At')</th>
                                    <th class="text-center">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($comments as $comment)
                                <tr data-id="{{$comment->id}}">
                                    <td>
                                        <span style="display: none;" class="btn btn-outline-secondary handle">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$comment->id}}
                                    </td>
                                    @if($comment->status == 1) 
                                    <td class="text-center">
                                        <span class="text-success">enabled</span>
                                    </td>
                                    @else 
                                    <td class="text-center">
                                        <span class="text-danger">disabled</span>
                                    </td>
                                    @endif
                                    <td>
                                        <strong>{{$comment->getBlogPostName()}}</strong>
                                    </td>
                                    <td>
                                        <strong>{{$comment->name}}</strong>
                                    </td>
                                    <td style="width: 10%;">
                                        {{\Str::limit($comment->description, 40)}}
                                    </td>
                                    <td class="text-center">{{$comment->created_at}}</td>
                                    <td class="text-center">
                                        @include('admin.comments.partials.actions')
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


<form class="modal fade" id="change-status-modal" action="{{route('admin.comments.change_status')}}" method="post">
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
                <p>@lang('Are you sure you want to change status of the comment?') <strong></strong>?</p>
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

@endsection

@push('head_links')

<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.theme.min.css')}}" rel="stylesheet" type="text/css"/>
@endpush

@push('footer_javascript')

<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>

<script type="text/javascript">

    
    $('#entities-list-table').DataTable({
        "order": [[5, 'desc']],
        "columns": [
                {"name": "id"},
                {"name": "status", "searchable": false},
                {"name": "blog_post", "searchable": false},
                {"name": "name", "searchable": false},
                {"name": "description", "searchable": false},
                {"name": "created_at", "searchable": false},
                {"name": "actions", "orderable": false, "searchable": false}
        ]
    });
    
    $('#entities-list-table').on('click', '[data-action="change"]', function (e) {

        let id = $(this).attr('data-id');

        $('#change-status-modal [name="id"]').val(id);
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
            location.reload();
        }).fail(function () {
            toastr.error("@lang('Greska prilikom mijenjanja statusa.')");
        });
    });


</script>
@endpush