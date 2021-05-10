@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-12">
          <div class="d-none d-md-block">&nbsp;</div>
          @if($count==0)
            <div class="card">
                <div class="card-body">
                    <div>&nbsp;</div>
                    <div class="text-center text-danger">Sorry no data exist</div>
                    <div>&nbsp;</div>
                </div>
            </div>
          @else
            @foreach ($post as $value)
                <a href="{{url('viewPost/'.$value->id)}}" style="text-decoration: none">
                <div class="card">
                    <div class="card-body">
                        <blockquote class="blockquote">
                            <p class="mb-0">{{$value->title}}</p>
                            <footer class="blockquote-footer">{{$value->name}}</footer>
                        </blockquote>
                        <p class="text-black">{{substr($value->content,0,320)}}...</p>
                    </div>
                </div>
                </a>
                <div>&nbsp;</div>
            @endforeach
        @endif
</div>
</div>
</div>
 @endsection
