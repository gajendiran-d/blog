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
                        <div class="col-md-8">{{ __('My Post') }}</div>
                        <div class="col-md-4 text-right"><span class="badge badge-dark">{{$count}}</span></div>
                    </div>
                </h4>
            </div>
            <div class="card-body">
              <div  align="right">
                <a href="{{action('PostController@create')}}"> <i class="fa fa-plus fa-2x text-success"></i></a>
              </div>
          @if($count==0)
            <div class="text-center text-danger">Sorry no data exist</div>
            <div>&nbsp;</div>
          @else
  <div class="table-responsive">
    <table class="table table-striped">
    <thead>
      <tr>
        <th class="text-left">Title</th>
        <th class="text-center">Edit</th>
        <th class="text-center">Delete</th>
        <th class="text-center">View</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($post as $value)
            <td class="text-left"><label class="col-form-label">{{$value['title']}}</label></td>
            <td class="text-center"><a class="btn btn-link" href="{{action('PostController@edit', $value['id'])}}"><i class="fa fa-edit text-primary"></i></a></td>
            <td class="text-center">
                <form onclick="return confirm('Do you really want to delete?')" action="{{action('PostController@destroy', $value['id'])}}" method="post">
                @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-link" type="submit"><i class="fa fa-trash text-danger"></i></button>
                </form>
            </td>
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
