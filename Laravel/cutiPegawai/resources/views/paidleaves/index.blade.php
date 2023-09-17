@extends('layouts.home')

@section('css')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" /> --}}
@endsection

@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Cuti</h6>
        </div>
        <div class="card-body">
            {{-- <div class="table-responsive"> --}}
            <table class="table-bordered table display" id="table_id" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Position</th>
                        <th>Level</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paidLeavesData['data'] as $paidLeave)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ $paidLeave['EMPLOYEE_CODE'] }}</td>
                            <td>{{ $paidLeave['NAME'] }}</td>
                            <td>{{ $paidLeave['GENDER'] }}</td>
                            <td>{{ $paidLeave['POSITION'] }}</td>
                            <td>{{ $paidLeave['LEVEL'] }}</td>
                            <td>
                                <a class="btn btn-circle btn-primary " href="#">
                                    <i class="fas fa-edit fa-md"></i></a>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-circle btn-danger" data-toggle="modal"
                                    data-target="#deleteModal">
                                    <i class="fas fa-trash fa-md"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <!-- Delete Modal-->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin ingin menghapus data ini
                                </h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">x</span>
                                </button>
                            </div>
                            <div class="modal-body">Anda tidak akan bisa memulihkan kembali data ini</div>
                            <div class="modal-footer">
                                <button class="btn btn-success" type="button" data-dismiss="modal">Cancel</button>
                                @foreach ($paidLeavesData['data'] as $paidLeave)
                                    <form action="{{ route('paidleaves.destroy', $paidLeave['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                @endforeach
                                <button type="submit" class="btn btn-danger">
                                    Delete
                                </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </table>
            {{-- </div> --}}
        </div>
    </div>

    <br>
@endsection
@section('javascripts')
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
    </script>
@endsection