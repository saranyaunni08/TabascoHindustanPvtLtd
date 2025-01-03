@extends('layouts.default')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <!-- Success message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Partner Table -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Partner List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover table-responsive">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Gender</th>
                                <th>Nationality</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($partners as $partner)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $partner->first_name }}</td>
                                    <td>{{ $partner->last_name }}</td>
                                    <td>{{ $partner->email }}</td>
                                    <td>{{ $partner->phone_number }}</td>
                                    <td>{{ $partner->address }}</td>
                                    <td>{{ ucfirst($partner->gender) }}</td>
                                    <td>{{ $partner->nationality }}</td>
                                    <td>
                                        <a href="{{ route('admin.partners.edit', $partner->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this partner?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Optional: Add custom styles -->
<style>
    .table th, .table td {
        text-align: center;
    }

    .table th {
        background-color: #f8f9fa;
    }

    .card {
        border-radius: 10px;
    }

    .card-header {
        font-size: 1.5rem;
    }

    .btn-warning {
        background-color: #f0ad4e;
    }

    .btn-danger {
        background-color: #d9534f;
    }

    .btn-sm {
        padding: 5px 10px;
    }

    /* Ensure the table fits within the container */
    .table-responsive {
        overflow-x: auto;
    }
</style>
@endsection

@section('scripts')
<!-- Optional: Include JS for confirmation dialogs -->
<script>
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Are you sure you want to delete this partner?')) {
                this.closest('form').submit();
            }
        });
    });
</script>
@endsection
