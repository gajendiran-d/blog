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
            <div class="card-header">
                <h4 class="card-title">
                    <div class="row">
                        <div class="col-md-8">{{ __('Other Post') }}</div>
                        <div class="col-md-4 text-right"><span class="badge badge-dark">{{$count}}</span></div>
                    </div>
                </h4>
            </div>
            <div class="card-body">
          @if($count==0)
            <div class="text-center text-danger">Sorry no data exist</div>
            <div>&nbsp;</div>
          @else
  <div class="table-responsive">
    <table class="table table-striped">
    <thead>
      <tr>
        <th class="text-left">Title</th>
        <th class="text-center">Approve</th>
        <th class="text-center">View</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($post as $value)
            <td class="text-left"><label class="col-form-label">{{$value['title']}}</label></td>
            @if($value['approve_status']==1)
            <td class="text-center">
              <form  action="{{action('PostController@updateStatus')}}" method="post">
                @csrf
                <input name="id" type="hidden" value="{{$value['id']}}">
                <input name="status" type="hidden" value="0">
                <button class="btn btn-link" type="submit"><i class="fa fa-lock-open text-secondary" ></i></button>
              </form>
            </td>
            @endif
            @if($value['approve_status']==0)
            <td class="text-center">
              <form  action="{{action('PostController@updateStatus')}}" method="post" >
                @csrf
                <input name="id" type="hidden" value="{{$value['id']}}">
                <input name="status" type="hidden" value="1">
                <button class="btn btn-link" type="submit"><i class="fa fa-lock text-secondary"></i></button>
              </form>
            </td>
            @endif
            <td class="text-center"><a class="btn btn-link" href="{{url('viewPost/'.$value['id'])}}"><i class="fa fa-file text-success"></i></a></td>
        @endforeach
    </tbody>
  </table>
</div>
@endif
</div>
</div>
</div>
</div>
</div>
 @endsection
