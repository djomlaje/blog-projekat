
<?php
if ($slider->status == 1) {
    ?>
    <div class="btn-group">
        <a href="{{route('admin.sliders.edit', ['slider' => $slider->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
        <button 
            type="button" 
            title="Disable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#disable-modal"
            data-featured="{{$slider->status}}"
            data-name="{{$slider->name}}"
            data-action="change"
            data-id="{{$slider->id}}"
            >
            <i class="fas fa-minus-circle"></i>
        </button>
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"

            data-action="delete"
            data-id="{{$slider->id}}"
            data-name="{{$slider->name}}"
            >
            <i class="fas fa-trash"></i>
        </button>
    </div>
    <?php
} elseif ($slider->status == 0) {
    ?>
    <div class="btn-group">
        <a href="{{route('admin.sliders.edit', ['slider' => $slider->id])}}" class="btn btn-info">
            <i class="fas fa-edit"></i>
        </a>
        <button 
            type="button" 
            title="Enable"
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#enable-modal"
            data-featured="{{$slider->status}}"
            data-name="{{$slider->name}}"
            data-action="change"
            data-id="{{$slider->id}}"
            >
            <i class="fas fa-check"></i>
        </button>
        <button 
            type="button" 
            class="btn btn-info" 
            data-toggle="modal" 
            data-target="#delete-modal"

            data-action="delete"
            data-id="{{$slider->id}}"
            data-name="{{$slider->name}}"
            >
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <?php
}
?>