@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Customer List</h2>
    </div>

    <div class="card-body">
        <table id="customerTable" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Picture</th>
                    <th scope="col">Name</th>
                    <th scope="col">P.No</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if ($user->role === 'user')
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Customer" width="30" height="30" class="rounded-circle">
                            @elseif ($user->role === 'admin')
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Admin" width="30" height="30" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

       </div>
</div>
@endsection

@push('scripts')

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {

        $('#customerTable').DataTable();
    });
</script>
@endpush
