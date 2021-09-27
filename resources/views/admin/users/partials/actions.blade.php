<?php
if (\Auth::user()->admin == 0) {
    
} else {
if (\Auth::user()->email == $user->email) {
    
} elseif ($user->status == 1) {
    ?>
    <div class="btn-group">
        <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
        <button 
            type="button" 
            title="Disable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#disable-modal"
            data-featured="{{$user->status}}"
            data-name="{{$user->name}}"
            data-action="change"
            data-id="{{$user->id}}"
            >
            <i class="fas fa-minus-circle"></i>
        </button>
<!--        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"
            data-action="delete"
            data-id="{{$user->id}}"
            data-name="{{$user->name}}"
            >
            <i class="fas fa-trash"></i>
        </button>-->
    </div>
    <?php
} elseif ($user->status == 0) {
    ?>
    <div class="btn-group">
        <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
        <button 
            type="button" 
            title="Enable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#enable-modal"
            data-featured="{{$user->status}}"
            data-name="{{$user->name}}"
            data-action="change"
            data-id="{{$user->id}}"
            >
            <i class="fas fa-check"></i>
        </button>
<!--        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"
            data-action="delete"
            data-id="{{$user->id}}"
            data-name="{{$user->name}}"
            >
            <i class="fas fa-trash"></i>
        </button>-->
    </div>

    <?php
}}
?>