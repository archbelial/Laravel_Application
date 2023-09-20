@extends('layouts.home')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit</h1>
            <form action="{{ route('employees.proceed-data', $employee['data']['id']) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">
                    Proceed
                </button>
                <a class="btn btn-danger" href="{{ route('employees.index') }}"> Back</a>
            </form>
        </div>
    </div>
</div>
     
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
     
{{-- @dd($employee) --}}
<form action="{{ route('employees.update',$employee['data']['id']) }}" method="POST" enctype="multipart/form-data"> 
    @csrf

    @method('PATCH')
    
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Code:</strong>
                <input type="text" name="code" class="form-control" placeholder="Code" value="{{$employee['data']['CODE']}}" readonly>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{$employee['data']['NAME']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Gender:</strong>
                <select name="gender" class="form-control" disabled>
                    <option value="Male" {{$employee['data']['GENDER'] === 'Male'? 'selected' : ''}} >Male</option>
                    <option value="Female" {{$employee['data']['GENDER'] === 'Female'? 'selected' : ''}}>Female</option>
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Position:</strong>
                <input type="text" name="position" class="form-control" placeholder="position" value="{{$employee['data']['POSITION']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Level:</strong>
                <input type="text" name="level" class="form-control" placeholder="level" value="{{$employee['data']['LEVEL']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
                <strong>Leave Days:</strong>
                <input type="text" name="leave_days" class="form-control" placeholder="Leave Days" value="{{$employee['data']['LEAVE_DAYS']}}" readonly>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
     
</form>
@endsection