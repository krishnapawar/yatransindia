@extends('layouts.app',['pageTitle'=>'Users List'])
@section('content_header')
<div class="col-md-6 text-end">
    <a href="{{route('users.create')}}" class="btn btn-outline-primary">Add User</a>
</div>
@endsection
@section('content')
<table id="usersTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>Role</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->gender }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->addresses && count($user->addresses)>0 ? $user->addresses[0]->address_line : ''  }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                    <!-- Add a delete confirmation modal for each user -->
                    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Delete Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this user?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable();
    });
</script>
@endsection
