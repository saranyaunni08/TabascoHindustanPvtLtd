@extends('layouts.default', ['title' => 'Dashboard', 'page' => 'dashboard'])
@section('content')
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Dashboard</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="row p-4">
              {{-- Your content here --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
