@extends('layouts.employee')

@section('custom-css')
@endsection

@section('page-title')
{{Auth::user()->name}}'s Profile (Password change)
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Home</a></li>
@endsection

@section('content')    
    <div class="row">
        <!-- Column -->
        <div class="col-lg-12 col-xlg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($errors) && count($errors)>0)
                    <div class="alert alert-danger">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            @foreach($errors->get('password') as $error)
                            <li v-for="error in errors">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        <b>{{session()->get('message')}}</b>
                    </div>
                    @endif
                    <form class="form-horizontal form-material" method="POST" action="{{ route('employee.changePassword')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="col-md-12">New Password</label>
                            <div class="col-md-12">
                                <input type="text" placeholder="New password" class="form-control form-control-line" name="password" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-success">Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection

@section('custom-js')

@endsection