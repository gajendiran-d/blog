@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="d-none d-md-block">&nbsp;</div>
          @if (\Session::has('success'))
            <div class="alert alert-success  text-center">
              <p>{{ \Session::get('success') }}</p>
            </div><br />
          @endif
          @if (\Session::has('error'))
            <div class="alert alert-danger  text-center">
              <p>{{ \Session::get('error') }}</p>
            </div><br />
          @endif
          <div class="card">
            <div class="card-body">
                <h3 class="text-center">{{$post['title']}}</h3>
                <div>&nbsp;</div>
                <img class="img-fluid" src="{{URL::to('/')}}/img/{{$post['image']}}">
                <div>&nbsp;</div>
                <div class="lead">{{$post['content']}}</div>
                <div>&nbsp;</div>
                <h4 class="text-primary">Comments</h4>
                @foreach ($comment as $value)
                    <blockquote class="blockquote">
                        <p class="mb-0">{{$value->comment}}</p>
                        <footer class="blockquote-footer">{{$value->name}}</footer>
                    </blockquote>
                @endforeach
                @if (Auth::user())
                    <form  action="{{action('PostController@addComment')}}" method="post">
                        @csrf
                        <input name="post_id" type="hidden" value="{{$post['id']}}">
                        <input name="user_id" type="hidden" value="{{$post['user_id']}}">
                        <div class="form-group col-12">
                            <textarea name="comment" id="comment" class="form-control" maxlength="300"></textarea>
                        </div>
                        <div class="form-group col-12" align="right">
                            <button class="btn btn-warning" type="submit">Send</button>
                        </div>
                    </form>
                @else
                    <div class="text-danger">Please login to add your comments</div>
                @endif

</div>
</div>
</div>
</div>
</div>
 @endsection
