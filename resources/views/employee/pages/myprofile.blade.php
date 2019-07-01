@extends('layouts.employee')

@section('custom-css')
@endsection

@section('page-title')
{{Auth::user()->name}}'s Profile
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Home</a></li>
@endsection

@section('content')    
    <div class="row" id="myprofile">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="mt-4"> <img src="{{ asset('/') }}/template/assets/images/users/5.jpg" class="rounded-circle" width="150" />
                        <h4 class="card-title mt-2"></h4>
                        <h6 class="card-subtitle">@{{user.detail?user.detail.full_name:"None"}}</h6>

                        <span class="badge badge-success" v-if="user.is_active == 1">Active</span>
                        <span class="badge badge-danger" v-if="user.is_active == 0">In-active</span>
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
                    <h6>@{{user.detail?user.detail.phone:"None"}}</h6> <small class="text-muted pt-4 db">Address</small>
                    <h6>@{{user.detail?user.detail.address:"None"}}</h6>
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
                                    <p class="text-muted">@{{user.detail?user.detail.full_name:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.phone:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                    <br>
                                    <p class="text-muted">@{{user?user.email:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Designation</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.designation:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Bitbucket</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.bitbucket:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Trello</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.trello:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Skype</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.skype:'None'}}</p>
                                </div>
                                <div class="col-md-3 col-xs-6"> <strong>Join Date</strong>
                                    <br>
                                    <p class="text-muted">@{{user.detail?user.detail.join_date:'None'}}</p>
                                </div>
                            </div>
                            <hr>
                            <b class="mt-4">Employee Address: </b>
                            <p class="mt-4">@{{user.detail?user.detail.address:'None'}} </p>
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
                                <div class="row">
                                    <div class="col-6">                                
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                            <input type="text" class="form-control" placeholder="username" v-model="user.name">
                                            <input type="hidden" class="form-control"  v-model="user.id">
                                        </div>
                                    </div>
                                    <div class="col-6">                                
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                            <input type="text" class="form-control" placeholder="Full Name" v-model="user.detail.full_name">
                                        </div>
                                    </div>
                                    <div class="col-6">                                
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                            <input type="text" class="form-control" placeholder="Designation" v-model="user.detail.designation">
                                        </div>
                                    </div>
                                    <div class="col-6">                                
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-mobile text-white"></i></button>
                                            <input type="text" class="form-control" placeholder="Phone no" v-model="user.detail.phone">
                                        </div>
                                    </div>
                                    <div class="col-6">                                
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                            <input type="email" class="form-control" placeholder="Email address" v-model="user.email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                            <input type="email" class="form-control" placeholder="Bitbucket email" v-model="user.detail.bitbucket">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                            <input type="email" class="form-control" placeholder="Trello email" v-model="user.detail.trello">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-skype text-white"></i></button>
                                            <input type="text" class="form-control" placeholder="Skype id" v-model="user.detail.skype">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-group mb-3">
                                            <button type="button" class="btn btn-info"><i class="ti-map text-white"></i></button>
                                            <textarea class="form-control" placeholder="Address" v-model="user.detail.address"></textarea>
                                        </div>
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
                user: {
                    id: '{{ Auth::user()->id }}',
                    name: '{{ Auth::user()->name }}',
                    email: '{{ Auth::user()->email }}',
                    is_active: '{{ Auth::user()->is_active }}',
                    creator: '{{ Auth::user()->creator->name }}',
                    detail: {
                        full_name: '{{ Auth::user()->detail->full_name }}',
                        phone: '{{ Auth::user()->detail->phone }}',
                        bitbucket: '{{ Auth::user()->detail->bitbucket }}',
                        trello: '{{ Auth::user()->detail->trello }}',
                        skype: '{{ Auth::user()->detail->skype }}',
                        avatar: '{{ Auth::user()->detail->avatar }}',
                        designation: '{{ Auth::user()->detail->designation }}',
                        join_date: '{{ Auth::user()->detail->join_date }}',
                        address: `{{ Auth::user()->detail->address }}`,
                    }
                },
            },
            mounted: function mounted() {
                var _this = this;   
            },
            methods: {      
                updateProfile: function updateProfile() {
                    var _this = this; 
                    _this.successMessage = '';
                    _this.errors = []; 
                    let data = {
                        employee: _this.user
                    }  
                    axios.post('{{route("employee.updateProfile")}}', data)
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