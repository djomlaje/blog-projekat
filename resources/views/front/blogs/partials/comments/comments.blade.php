<div class="post-comments" id="post-comments-loading">

</div>
<div class="add-comment">
    <header>
        <h3 class="h6">@lang('Leave a reply')</h3>
    </header>
    <form id="entity-form" method="post" class="commenting-form">
        @csrf
        <div class="row">
            <div class="form-group col-md-6">
                <input 
                    type="text" 
                    name="name"
                    id="username" 
                    placeholder="@lang('Name')" 
                    class="form-control"
                    >
            </div>
            <div class="form-group col-md-6">
                <input 
                    type="email" 
                    name="email" 
                    id="useremail" 
                    placeholder="@lang('Email Address (will not be published)')" 
                    class="form-control"
                    >
            </div>
            <div class="form-group col-md-12">
                <textarea 
                    name="description"
                    id="usercomment" 
                    placeholder="@lang('Type your comment')" 
                    class="form-control"
                    ></textarea>
            </div>
            <div class="form-group col-md-12">
                <button 
                    type="submit" 
                    class="btn btn-secondary"
                    data-action="comment-post"
                    >@lang('Submit Comment')</button>
            </div>
        </div>
    </form>
</div>

@push('footer_javascript')
<script>

    let blogID = "{{$blog->id}}";
    function commentsFrontRefreshList() 
    {
        $.ajax({
            "url": "{{route('front.blogs.partials.comments.content')}}",
            "type": "get",
            "data": {
                "blogID": blogID
            }
        }).done(function (response) {
            $('#post-comments-loading').html(response);
            
        }).fail(function (jqXHR, textStatus, error) {
            
            console.log('Greska');
        });
    }
    commentsFrontRefreshList();

    $('#entity-form').on('submit', function (e) {

        e.preventDefault();
        e.stopPropagation();
        
        let name = $('[name="name"]').val();
        let email = $('[name="email"]').val();
        let description = $('#usercomment').val();
        let blogID = "{{$blog->id}}";
        
        commentsFrontAddComment(name, email, description, blogID);
        commentsFrontRefreshList();
    });

    function commentsFrontAddComment(name, email, description, blogID) {
        $.ajax({

            "url": "{{route('front.blogs.partials.comments.insert')}}",
            "type": "POST",
            "data": {
                "_token": "{{csrf_token()}}",
                "blog_post_id": blogID,
                "name": name,
                "email": email,
                "description": description
            }

        }).done(function (response) {

            commentsFrontRefreshList();

        }).fail(function () {
            console.log('Neuspijesno dodavanje komentara');
        });
    }
    
    commentsFrontRefreshList();

</script>

@endpush