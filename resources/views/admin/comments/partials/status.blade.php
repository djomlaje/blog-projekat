@if($comment->status == 1) 
<td class="text-center">
    <span class="text-success">@lang('enabled')</span>
</td>
@else 
<td class="text-center">
    <span class="text-danger">@lang('disabled')</span>
</td>
@endif