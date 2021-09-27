@if($blogPost->status == 1) 
<td class="text-center">
    <span class="text-success">enabled</span>
</td>
@else 
<td class="text-center">
    <span class="text-danger">disabled</span>
</td>
@endif