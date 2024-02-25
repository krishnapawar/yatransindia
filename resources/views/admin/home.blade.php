@extends('layouts.app',['pageTitle'=>'Dashboard'])

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers??'0' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">New Users Today</h5>
                    <p class="card-text">{{ $newUsers??'' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total News</h5>
                    <p class="card-text">{{ $newsCount??'' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
