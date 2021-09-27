@push('head_css')
{!! htmlScriptTagJsApi() !!}
@endpush
<form action="{{route('front.contact.send_message')}}" method="post" class="commenting-form" id="main_contact_form">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <input 
                type="text" 
                value="{{old('your_name')}}"
                class="form-control @if($errors->has('your_name')) is-invalid @endif"
                name="your_name"
                id="f-name"
                placeholder="{{__('Your Name')}}"
                required
                >
            @include('front._layout.partials.form_errors', ['fieldName' => 'your_name'])
        </div>
        <div class="form-group col-md-6">
            <input 
                type="email" 
                value="{{old('your_email')}}"
                class="form-control @if($errors->has('your_email')) is-invalid @endif" 
                name="your_email" 
                id="email" 
                placeholder="@lang('Email Address (will not be published)')" 
                required                
                >
            @include('front._layout.partials.form_errors', ['fieldName' => 'your_email'])
        </div>
        <div class="form-group col-md-12">
            <textarea 
                name="message" 
                class="form-control @if($errors->has('message')) is-invalid @endif" rows="20"
                id="message" 
                placeholder="@lang('Type your message')" 
                required
                >{{old('message')}}</textarea>
            @include('front._layout.partials.form_errors', ['fieldName' => 'message'])
        </div>
        {!! htmlFormSnippet() !!}
        <div class="form-control @if($errors->has('g-recaptcha-response')) is-invalid @endif" hidden=""></div>
        @include('front._layout.partials.form_errors', ['fieldName' => 'g-recaptcha-response'])
        <div class="form-group col-md-12">
            <button type="submit" class="btn btn-secondary">Submit Your Message</button>
        </div>
    </div>
</form>

@push('footer_javascript')

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script>


<script type="text/javascript">
    
    $('#main_contact_form').validate({
        "rules": {
            "your_name": {
                "required": true,
                "minlength": 2
            },
            "your_email": {
                "required": true,
                "email": true
            },
            "message": {
                "required": true,
                "minlength": 50,
                "maxlength": 255
            }
        },
        "errorPlacement": function (error, element) {
            error.addClass('text-danger');
            error.insertAfter(element);
        }
    });
    
</script>

@endpush