@extends('layouts.employee')

@section('custom-css')
@endsection

@section('page-title')
Employee Dashboard
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employee.dashboard') }}">Dashboard</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    This is some text within a card block.
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
@endsection