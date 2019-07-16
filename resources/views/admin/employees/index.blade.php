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
<div class="row" id="employees">
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

                <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="successMessage">
                    <strong>Successfull!</strong> @{{successMessage}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="successMessage=''">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <table class="table table-bordered table-striped" width="100%" cellspacing="0" data-toggle="table" data-mobile-responsive="true">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Join Date</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Join Date</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(employee, index) in employees">
                        <td>@{{index+1}}</td>
                        <td>@{{employee.name}}</td>
                        <td>@{{employee.email}}</td>
                        <td>@{{employee.detail?employee.detail.designation:'Empty'}}</td>
                        <td>@{{employee.detail?employee.detail.phone:'Empty'}}</td>
                        <td>@{{employee.detail?employee.detail.join_date:'Empty'}}</td>
                        <td>
                            <span class="badge badge-success" v-if="employee.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="employee.is_active == 1" @click.prevent="inactiveEmployee(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="employee.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="employee.is_active == 0" @click.prevent="activeEmployee(index)">Active-it</button> 
                        </td>
                        <td>     
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#employeeDetail" @click="setData(index)">
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
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="employeeDetail">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Employee detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3 col-md-5">
                                <div class="card">
                                    <div class="card-body">
                                        <center class="mt-4"> <img src="{{ asset('/') }}/template/assets/images/users/5.jpg" class="rounded-circle" width="150" />
                                            <h4 class="card-title mt-2"></h4>
                                            <h6 class="card-subtitle">@{{employee.detail?employee.detail.full_name:"None"}}</h6>

                                            <span class="badge badge-success" v-if="employee.is_active == 1">Active</span>
                                            <span class="badge badge-danger" v-if="employee.is_active == 0">In-active</span>
                                            <div class="row text-center justify-content-md-center">
                                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i> <font class="font-medium">254</font></a></div>
                                                <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i> <font class="font-medium">54</font></a></div>
                                            </div>
                                        </center>
                                    </div>
                                    <div>
                                        <hr> </div>
                                    <div class="card-body"> <small class="text-muted">Email address </small>
                                        <h6>@{{employee.email}}</h6> <small class="text-muted pt-4 db">Phone</small>
                                        <h6>@{{employee.detail?employee.detail.phone:"None"}}</h6> <small class="text-muted pt-4 db">Address</small>
                                        <h6>@{{employee.detail?employee.detail.address:"None"}}</h6>
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
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Full Name</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.full_name:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.phone:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                                                <br>
                                                <p class="text-muted">@{{employee?employee.email:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Designation</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.designation:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Bitbucket</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.bitbucket:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Trello</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.trello:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Skype</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.skype:'None'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Join Date</strong>
                                                <br>
                                                <p class="text-muted">@{{employee.detail?employee.detail.join_date:'None'}}</p>
                                            </div>
                                        </div>
                                        <hr>
                                        <b class="mt-4">Employee Address: </b>
                                        <p class="mt-4">@{{employee.detail?employee.detail.address:'None'}} </p>
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
                                    <input type="text" class="form-control" placeholder="username" v-model="employee.name">
                                    <input type="hidden" class="form-control"  v-model="employee.id">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-key text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Default password" v-model="employee.password">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="employee.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Full Name" v-model="employee.detail.full_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Designation" v-model="employee.detail.designation">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-mobile text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Phone no" v-model="employee.detail.phone">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Email address" v-model="employee.email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Bitbucket email" v-model="employee.detail.bitbucket">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Trello email" v-model="employee.detail.trello">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-skype text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Skype id" v-model="employee.detail.skype">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-calendar text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Join Date" v-model="employee.detail.join_date">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-map text-white"></i></button>
                                    <textarea class="form-control" placeholder="Address" v-model="employee.detail.address"></textarea>
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!employee.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="employee.id"><i class="ti-save"></i> Update</button>
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
            el: '#employees',
            data: {
                errors: [],
                employee: {
                    id: '',
                    name: '',
                    email: '',
                    password: '123456',
                    is_active: 1,
                    created_by: '',
                    detail: {
                        full_name: '',
                        phone: '',
                        bitbucket: '',
                        trello: '',
                        skype: '',
                        avatar: '',
                        designation: '',
                        join_date: '',
                        address: '',
                    }
                },
                currentIndex: 0,
                employees: [],
                successMessage: ''
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("employees.all") }}')
                    .then(function (response) {
                        _this.employees = response.data.employees;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.employee = _this.employees[index];
                },
                inactiveEmployee(index) {
                    var _this = this;
                    let data = {
                        employee_id: _this.employees[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("employees.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.employees[index] , 'is_active' , 0);
                         
                             //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Employee  status inactivated   successfully'
                                  })

                                    //end sweet alart
                        }
                    })
                },
                activeEmployee(index) {
                    var _this = this;
                    let data = {
                        employee_id: _this.employees[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("employees.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.employees[index] , 'is_active' , 1);
                           
                             //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Employee  status activated   successfully'
                                  })

                                    //end sweet alart

                        }
                    })
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.employee = {
                        id: '',
                        name: '',
                        email: '',
                        password: '123456',
                        is_active: 1,
                        created_by: '',
                        detail: {
                            full_name: '',
                            phone: '',
                            bitbucket: '',
                            trello: '',
                            skype: '',
                            avatar: '',
                            designation: '',
                            join_date: '',
                            address: '',
                        }
                    }
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            employee: _this.employee
                        }
                        axios.post('{{ route("employees.addOrUpdate") }}', data)
                        .then(function (response) {
                            let data = response.data;
                            let status = response.data.status;
                            if(response.data.success == true) {
                                //modal close
                                if (status=='somethingwrong') {
                                    // _this.errors.push("Something wrong. Try again.");
                                    alert("something Wrong. Try Again.")
                                }
                                if(status=='created') {
                                    _this.employees.push(data.employee);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                   
                                     //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Employee created successfully'
                                  })

                                    //end sweet alart

                                }
                                if(status=='updated') {
                                    _this.employees[_this.currentIndex] = data.employee;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    

                                     //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Employee updated successfully'
                                  })

                                    //end sweet alart
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
                validate() {           
                    var _this = this; 
                    _this.errors = [];
                    let employee = _this.employee;
                    let count = 0; 

                    if (!employee.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!employee.detail.phone) {
                        _this.errors.push("Phone number required.");
                        count++;
                    }
                    if (!employee.detail.designation) {
                        _this.errors.push("Designation required.");
                        count++;
                    }
                    if (!employee.email) {
                        _this.errors.push('Email required.');
                        count++;
                    } else if (!this.validEmail(employee.email)) {
                        _this.errors.push('Valid email required.');
                        count++;
                    }
                    if (!employee.detail.bitbucket) {
                        _this.errors.push('Bitbucket email required.');
                        count++;
                    } else if (!this.validEmail(employee.detail.bitbucket)) {
                        _this.errors.push('Valid bitbucket email required.');
                        count++;
                    }
                    if (!employee.detail.trello) {
                        _this.errors.push('Trello email required.');
                        count++;
                    } else if (!this.validEmail(employee.detail.trello)) {
                        _this.errors.push('Valid trello email required.');
                        count++;
                    }
                    if (!employee.detail.skype) {
                        _this.errors.push('Skype id required.');
                        count++;
                    } 
                    if (!employee.detail.designation) {
                        _this.errors.push('Designation required.');
                        count++;
                    } 
                    if (!employee.detail.join_date) {
                        _this.errors.push('Join Date required.');
                        count++;
                    } 
                    if(count==0) return true;
                    else return false;
                },
                validEmail(email) {
                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                },
                wait(ms){
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