@extends('layouts.app', ['pageTitle' => 'User Details'])

@section('content_header')
    <div class="col-md-6 text-end">
        <a href="{{ route('users.index') }}" class="btn btn-outline-primary">Back</a>
    </div>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="col-6 text-start">
                <h5 class="card-title">User Information</h5>
            </div>
            <div class="col-6 text-end">
                <a href="{{ route('users.edit', auth()->user()->id) }}"  class="btn btn-primary">Update User</a>
            </div>
            

            <div id="profile_picture_preview" class="mt-2">
                <img src="{{ asset($user->profile_picture ?? 'https://via.placeholder.com/150') }}" alt="Profile Preview" class="img-fluid rounded-circle">
            </div>

            <dl class="row mt-3">
                <dt class="col-sm-3">First Name:</dt>
                <dd class="col-sm-9">{{ $user->first_name }}</dd>

                <dt class="col-sm-3">Last Name:</dt>
                <dd class="col-sm-9">{{ $user->last_name }}</dd>

                <dt class="col-sm-3">Email:</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>

                <dt class="col-sm-3">Phone:</dt>
                <dd class="col-sm-9">{{ $user->phone }}</dd>

                <dt class="col-sm-3">Gender:</dt>
                <dd class="col-sm-9">{{ $user->gender }}</dd>

                <dt class="col-sm-3">Role:</dt>
                <dd class="col-sm-9">{{ $user->role }}</dd>

                <dt class="col-sm-3">Addresses:</dt>
                <dd class="col-sm-9">
                    @forelse($user->addresses as $index => $address)
                        <div class="mb-2">
                            <strong>Address {{ $index + 1 }}:</strong><br>
                            {{ $address->address_line }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }} - {{ $address->zip_code }}
                        </div>
                    @empty
                        No addresses available.
                    @endforelse
                </dd>
            </dl>
        </div>
    </div>
@endsection

@section('script')
    <!-- Your existing JavaScript code -->
@endsection
