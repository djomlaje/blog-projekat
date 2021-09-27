<?php
if ($comment->status == 1) {
    ?>
    <div class="btn-group">
        <a href="{{$comment->getPostUrl()}}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i>
        </a>
        <button 
            type="button" 
            title="Disable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#change-status-modal"
            data-featured="{{$comment->status}}"
            data-name="{{$comment->name}}"
            data-action="change"
            data-id="{{$comment->id}}"
            >
            <i class="fas fa-minus-circle"></i>
        </button>

    </div>
    <?php
} elseif ($comment->status == 0) {
    ?>
    <div class="btn-group">
        <a href="{{$comment->getPostUrl()}}" class="btn btn-info" target="_blank">
            <i class="fas fa-eye"></i>
        </a>
        <button 
            type="button" 
            title="Enable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#change-status-modal"
            data-featured="{{$comment->status}}"
            data-name="{{$comment->name}}"
            data-action="change"
            data-id="{{$comment->id}}"
            >
            <i class="fas fa-check"></i>
        </button>
    </div>

    <?php
}
?>