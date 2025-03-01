@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Reviews</h2>
    </div>

    <div class="card-body">
        <table id="reviewsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Feedback</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allReviews as $review)
                    <tr>
                        <td>{{ $review->user->name ?? 'N/A' }}</td> <!-- Assuming 'user' is the relationship -->
                        <td>{{ $review->feedback }}</td>
                        <td>{{ $review->rating }} / 5</td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-danger">Pending</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center">
                                <!-- Approve Button -->
                                @if(!$review->is_approved)
                                    <form method="POST" action="{{ route('admin.reviews.approve', $review->id) }}" class="me-2">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">Approve</button>
                                    </form>
                                @endif

                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.reviews.delete', $review->id) }}" onsubmit="return confirm('Are you sure you want to delete this review?');" class="me-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
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
        $('#reviewsTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[2, 'asc']] // Sort by Status column
        });
    });
</script>
@endpush
