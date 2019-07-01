@extends('layouts.admin')

@section('custom-css')
@endsection

@section('page-title')
{{Auth::user()->name}}'s Profile
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')    
    <div class="row" id="myprofile">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="mt-4"> <img src="{{ asset('/') }}/template/assets/images/users/5.jpg" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-2">@{{user.name}}</h4>
                        <h6 class="card-subtitle">Admin</h6>
                        <div class="row text-center justify-content-md-center">
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                        </div>
                    </center>
                </div>
                <div>
                    <hr> </div>
                <div class="card-body"> <small class="text-muted">Email address </small>
                    <h6>@{{user.email}}</h6> <small class="text-muted pt-4 db">Phone</small>
                    <h6>+91 654 784 547</h6> <small class="text-muted pt-4 db">Address</small>
                    <h6>71 Pilgrim Avenue Chevy Chase, MD 20815</h6>
                    <small class="text-muted pt-4 db">Social Profile</small>
                    <br/>
                    <button class="btn btn-circle btn-secondary"><i class="fab fa-facebook-f"></i></button>
                    <button class="btn btn-circle btn-secondary"><i class="fab fa-twitter"></i></button>
                    <button class="btn btn-circle btn-secondary"><i class="fab fa-youtube"></i></button>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Tabs -->
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#setting" role="tab" aria-controls="pills-setting" aria-selected="false">Setting</a>
                    </li>
                </ul>
                <!-- Tabs -->
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                    <br>
                                    <p class="text-muted">@{{ user.name }}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                    <br>
                                    <p class="text-muted">(123) 456 7890</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                    <br>
                                    <p class="text-muted">@{{user.email}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Location</strong>
                                    <br>
                                    <p class="text-muted">London</p>
                                </div>
                            </div>
                            <hr>
                            <p class="mt-4">Admin has no profile</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card-body">
                            <p class="alert alert-success" v-if="successMessage">@{{successMessage}}</p>
                            <div v-if="errors.length" class="alert alert-danger">
                                <b>Please correct the following error(s):</b>
                                <ul>
                                    <li v-for="error in errors">@{{ error }}</li>
                                </ul>
                            </div>
                            <form class="form-horizontal form-material" method="POST" action="javascript:void(0)">
                                <div class="form-group">
                                    <label class="col-md-12">User Name</label>
                                    <div class="col-md-12">
                                        <input type="text" :placeholder="user.name" class="form-control form-control-line" v-model='user.name' >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" :placeholder="user.email" class="form-control form-control-line" name="example-email" id="example-email"  v-model='user.email'>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" @click.prevent="updateProfile()" >Update Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Column -->
    </div>
@endsection

@section('custom-js')

<!-- ============================================================== -->
<!-- This page plugin js -->
<!-- ============================================================== -->
<script src="{{asset('/')}}/js/vue.js"></script>
<script src="{{asset('/')}}/js/axios.min.js"></script>

    <script type="text/javascript">
        const app = new Vue({
            el: '#myprofile',
            data: {
                errors: [],
                successMessage: '',
                user:{'name':'{{ Auth::user()->name }}','email':'{{ Auth::user()->email }}'},
            },
            mounted: function mounted() {
                var _this = this;   
            },
            methods: {      
                updateProfile: function updateProfile() {
                    var _this = this; 
                    _this.successMessage = '';
                    _this.errors = [];
                    axios.post('{{route("admin.updateProfile")}}', _this.user)
                    .then(function (response) {
                        if(response.data.success == true){
                            _this.user = response.data.user;
                            _this.successMessage = "Profile Updated successfully.";
                        } else {
                            for (var key in response.data.errors) {
                                response.data.errors[key].forEach(function(element) {
                                    _this.errors.push(element);
                                });
                            }
                        }
                    })
                },   
                wait: function wait(ms){
                    var start = new Date().getTime();
                    var end = start;
                    while(end < start + ms) {
                        end = new Date().getTime();
                    }
                }
            }
        });
    </script>
@endsection