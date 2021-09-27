<div class="btn-group">
    <a href="{{$blogPost->getFrontUrl()}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.blog_posts.edit', ['blogPost' => $blogPost->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        title="Delete"
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
    @if($blogPost->status == 0)
    <button 
        type="button" 
        title="Change status"
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#change-status-modal"
        data-action="change"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-plus"></i>
    </button>
    @else
    <button 
        type="button" 
        title="Change status"
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#change-status-modal"
        data-action="change"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-minus"></i>
    </button>
    @endif
    @if($blogPost->important == 0)
    <button 
        type="button" 
        title="Importance"
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#change-importance-modal"
        data-action="importance"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-hand-point-up"></i>
    </button>
    @else
    <button 
        type="button" 
        title="Importance"
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#change-importance-modal"
        data-action="importance"
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-hand-point-down"></i>
    </button>
    @endif
</div>