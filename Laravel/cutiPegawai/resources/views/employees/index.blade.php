@extends('employees.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Employees</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('employees.create') }}"> Create</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Code</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Position</th>
            <th>Level</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($employees['data']['data'] as $employee)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $employee['CODE'] }}</td>
                <td>{{ $employee['NAME'] }}</td>
                <td>{{ $employee['GENDER'] }}</td>
                <td>{{ $employee['POSITION'] }}</td>
                <td>{{ $employee['LEVEL'] }}</td>
                <td>
                    <form action="{{ route('employees.destroy', $employee['id']) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('employees.edit', $employee['id']) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{-- <div class="pagination">
        {{ $employees['data']['current_page'] }} of {{ $employees['data']['last_page'] }}
        <br>
        {{ $employees['data']['total'] }} records found
        <br>
        @foreach ($employees['data']['links'] as $link)
            <a href="{{ $link['url'] }}">{{ $link['label'] }}</a>
        @endforeach
    </div> --}}
@endsection
