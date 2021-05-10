
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if(session('success'))
        <div class="alert alert-success  text-center">
        {{ session('success') }}
        </div>
       @endif
        @if ($errors->any())
      <div class="alert alert-danger  text-center">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
    @endif
            <div class="card">
                <div class="card-header text-center"><b>{{ __('Edit Post') }}</b></div>

                <div class="card-body">
      <form method="post" action="{{action('PostController@update', $id)}}" enctype="multipart/form-data" name="form" id="form">
      @csrf
      <input name="_method" type="hidden" value="PATCH">
       <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label">{{ __('Title') }}</label>
          <div class="col-md-8">
            <input type="text" class="form-control" name="title" value="{{$post['title']}}"  maxlength="75" required>
          </div>
        </div>

        <div class="form-group row">
            <label for="image" class="col-md-4 col-form-label">{{ __('Image') }}<span class="text-danger"> *</span></label>
            <div class="col-md-4">
                <input type="file" name="image" id="image" onchange="imagePreview(this);" />
            </div>
            <div class="col-md-4" align="right">
                <img id="image_preview" width="100px" height="60px" src="{{URL::to('/')}}/img/{{$post['image']}}" />
            </div>
            <script type="text/javascript">
            function imagePreview(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#image_preview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            </script>
        </div>

        <div class="form-group row">
        <label for="description" class="col-md-4 col-form-label">{{ __('Content') }}</label>
          <div class="col-md-8">
              <textarea class="form-control" name="content" value="" maxlength="750" rows="5" cols="50" required>{{$post['content']}}</textarea>
            </div>
        </div>

    <div  align="right" >
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>

      </form>

   </div>
            </div>
        </div>
    </div>
</div>
@endsection
