@if($blogPost->important == 1)
<span class="text-success">Yes</span>
@elseif($blogPost->important == 0)
<span class="text-danger">No</span>
@endif