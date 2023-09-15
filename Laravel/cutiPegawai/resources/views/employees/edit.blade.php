@extends('employees.layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('employees.index') }}"> Back</a>
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
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Code:</strong>
                <input type="text" name="code" class="form-control" placeholder="Code" value="{{$employee['data']['CODE']}}" readonly>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{$employee['data']['NAME']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Gender:</strong>
                <input type="radio" name="gender" value="Male" {{$employee['data']['GENDER'] == 'Male'? 'checked' : ''}} disabled> Male
                <input type="radio" name="gender" value="Female" {{$employee['data']['GENDER'] == 'Female'? 'checked' : ''}} disabled> Female
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Position:</strong>
                <input type="text" name="position" class="form-control" placeholder="position" value="{{$employee['data']['POSITION']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Level:</strong>
                <input type="text" name="level" class="form-control" placeholder="level" value="{{$employee['data']['LEVEL']}}">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
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