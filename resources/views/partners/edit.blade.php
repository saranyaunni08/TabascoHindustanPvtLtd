@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Edit Partner</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="first_name" class="font-weight-bold">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $partner->first_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name" class="font-weight-bold">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $partner->last_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $partner->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="phone_number" class="font-weight-bold">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $partner->phone_number }}" required>
                        </div>

                        <div class="form-group">
                            <label for="address" class="font-weight-bold">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ $partner->address }}" required>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success btn-lg">Update Partner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add SweetAlert for success message -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endsection

@section('styles')
<!-- SweetAlert2 for success alerts -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('scripts')
<!-- SweetAlert2 for success alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.1/dist/sweetalert2.min.js"></script>
@endsection
