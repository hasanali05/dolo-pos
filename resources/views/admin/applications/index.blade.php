@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
Home page
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="applications">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Employees List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Employee
                            </button>
                        </div>
                    </div>
                </div>
                <table data-toggle="table" data-mobile-responsive="true"
                class="table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Reason</th>
                        <th>Date</th>
                        <th>Admin</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(application, index) in applications">
                        <td>@{{index+1}}</td>
                        <td>@{{application.employee.name}}</td>
                        <td>@{{application.subject}}</td>
                        <td>@{{application.reason}}</td>
                        <td>@{{application.date}}</td>
                        <td>@{{application.admin?application.admin.name:'none'}}</td>
                        <td>
                            <h3><span class="badge badge-info badge-lg">@{{application.status}}</span></h3>

                            <button class="btn btn-danger" v-if="application.status == 'pending'" @click.prevent="statusChange(index, 'approved')">Approve-it</button> 

                            <button class="btn btn-success" v-if="application.status == 'pending'" @click.prevent="statusChange(index, 'declined')">Declined-it</button> 
                        </td>
                        <td>     
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#applicationDetail" @click="setData(index)">
                                <span class="icon text-white" >
                                    <i class="fas fa-eye"></i>
                                </span>
                            </button> 
                            <button class="btn btn-warning btn-icon-split"   data-toggle="modal" data-target="#createmodel"  @click="setData(index)">
                                <span class="icon text-white">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </button>                                  
                        </td>
                    </tr>
                </tbody>
            </table>
<!-- <nav aria-label="..." style="float: right">
<ul class="pagination pagination-sm">
<li class="page-item disabled">
<a class="page-link" href="javascript:void(0)" tabindex="-1">Previous</a>
</li>
<li class="page-item"><a class="page-link" href="javascript:void(0)">1</a></li>
<li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
<li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
<li class="page-item">
<a class="page-link" href="javascript:void(0)">Next</a>
</li>
</ul>
</nav> -->
            </div>
        </div>
    </div>
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="applicationDetailLabel" aria-modal="true" id="applicationDetail">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="applicationDetailLabel">Application detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Designation</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Bitbucket</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Trello</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Skype</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Join Date</strong>
                                                <br>
                                                <p class="text-muted"></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <b class="mt-4">Employee Address: </b>
                                        <p class="mt-4"></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  v-on:click="counter += 1" >Close</button>
                    </div>
                </div>
            </div>
        </div>



    <div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Employee</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div v-if="errors.length" class="alert alert-danger">
                            <b>Please correct the following error(s):</b>
                            <ul>
                                <li v-for="error in errors">@{{ error }}</li>
                            </ul>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="username" v-model="application.name">
                                    <input type="hidden" class="form-control"  v-model="application.id">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-key text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Default password" v-model="application.password">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="application.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Full Name" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Designation" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-mobile text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Phone no" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Email address" v-model="application.email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Bitbucket email" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Trello email" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-skype text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Skype id" v-model="application">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-calendar text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Join Date" v-model="application">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-map text-white"></i></button>
                                    <textarea class="form-control" placeholder="Address" v-model="application"></textarea>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="input-group mb-3">
                            <button type="button" class="btn btn-info"><i class="ti-import text-white"></i></button>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose Image</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!application.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="application.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('custom-js')

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">
        const app = new Vue({
            el: '#applications',
            data: {
                errors: [],
                application: {
                    id: '',
                    subject: '',
                    reason: '',
                    status: '123456',
                    date: 1,
                    note: '',
                    employee: {
                        name: '',
                    },
                    admin: {
                        name: '',
                    }
                },
                currentIndex: 0,
                applications: []
            },
            mounted: function mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData: function getAllData() {
                    var _this = this;
                    axios.get('{{ route("applications.all") }}')
                    .then(function (response) {
                        _this.applications = response.data.applications;
                    })
                },
                setData: function setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.application = _this.applications[index];
                },
                statusChange: function instatusChange(index, status) {
                    var _this = this;
                    let data = {
                        application_id: _this.applications[index].id,
                        status: status,
                    }
                    axios.post('{{ route("applications.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.applications[index] , 'status' , status);
                        }
                    })
                },
                clearData: function clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.application = {
                        id: '',
                        subject: '',
                        reason: '',
                        status: '123456',
                        date: 1,
                        note: '',
                        employee: {
                            name: '',
                        },
                        admin: {
                            name: '',
                        }
                    };
                },
                saveData: function saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            application: _this.application
                        }
                        axios.post('{{ route("applications.addOrUpdate") }}', data)
                        .then(function (response) {
                            let data = response.data;
                            if(response.data.success == true) {
                                //modal close
                                if (status=='somethingwrong') {
                                    // _this.errors.push("Something wrong. Try again.");
                                    alert("something Wrong. Try Again.")
                                }
                                if(status=='created') {
                                    _this.applications.push(data.application);
                                    //modal close
                                }
                                if(status=='updated') {
                                    _this.applications[currentIndex] = data.application;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                }
                            } else {                                
                                for (var key in data.errors) {
                                    data.errors[key].forEach(function(element) {
                                        _this.errors.push(element);
                                    });
                                }
                            }
                        }) 
                    }
                },
                validate: function validate() {           
                    var _this = this; 
                    _this.errors = [];
                    let application = _this.application;
                    let count = 0; 

                    if (!application.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!application.detail.phone) {
                        _this.errors.push("Phone number required.");
                        count++;
                    }
                    if (!application.detail.designation) {
                        _this.errors.push("Designation required.");
                        count++;
                    }
                    if (!application.email) {
                        _this.errors.push('Email required.');
                        count++;
                    } else if (!this.validEmail(application.email)) {
                        _this.errors.push('Valid email required.');
                        count++;
                    }
                    if (!application.detail.bitbucket) {
                        _this.errors.push('Bitbucket email required.');
                        count++;
                    } else if (!this.validEmail(application.detail.bitbucket)) {
                        _this.errors.push('Valid bitbucket email required.');
                        count++;
                    }
                    if (!application.detail.trello) {
                        _this.errors.push('Trello email required.');
                        count++;
                    } else if (!this.validEmail(application.detail.trello)) {
                        _this.errors.push('Valid trello email required.');
                        count++;
                    }
                    if (!application.detail.skype) {
                        _this.errors.push('Skype id required.');
                        count++;
                    } 
                    if (!application.detail.designation) {
                        _this.errors.push('Designation required.');
                        count++;
                    } 
                    if (!application.detail.join_date) {
                        _this.errors.push('Join Date required.');
                        count++;
                    } 
                    if(count==0) return true;
                    else return false;
                },
                validEmail: function (email) {
                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                },
                wait: function wait(ms){
                    var start = new Date().getTime();
                    var end = start;
                    while(end < start + ms) {
                        end = new Date().getTime();
                    }
                },
            }
        });

    </script>
@endsection