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
<div class="row" id="accounts">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Accounts List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Account
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

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead style="text-align: center;">
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Name</th>
                        <th>Group</th>
                        <th>Sub Group</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody style="text-align: center;">
                    <tr v-for="(account, index) in accounts">
                        <td>@{{index+1}}</td>
                        <td>@{{account.name}}</td>
                        <td>@{{account.group}}</td>
                        <td>@{{account.sub_group}}</td>
                        <td>
                            <span class="badge badge-success" v-if="account.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="account.is_active == 1" @click.prevent="inactiveAccount(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="account.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="account.is_active == 0" @click.prevent="activeAccount(index)">Active-it</button> 
                        </td>
                        <td>     
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#accountDetail" @click="setData(index)">
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
    
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="accountDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Account Detail</h5>
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
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Account Name</strong>
                                                <br>
                                                <p class="text-muted">@{{account.name}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Group</strong>
                                                <br>
                                                <p class="text-muted">@{{account.group}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Sub Group</strong>
                                                <br>
                                                <p class="text-muted">@{{account.sub_group}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Active</strong>
                                                <br>
                                                <h3 >
                                                    <span class="badge badge-success" v-if="account.is_active == 1">Active
                                                    </span>
                                                    <span class="badge badge-danger" v-else>Inactive
                                                    </span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



    <div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Account</h5>
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
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="username" v-model="account.name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></button>
                                    <select class="form-control form-white" placeholder="Sub Group" v-model="account.group">
                                        <option v-for="group in groups" :value="group">@{{group}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></i></button>

                                    <select class="form-control form-white" placeholder="Sub Group" v-model="account.sub_group">
                                        <option v-for="subGroup in subGroups" :value="subGroup">@{{subGroup}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="account.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!account.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="account.id"><i class="ti-save"></i> Update</button>
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
            el: '#accounts',
            data: {
                errors: [],
                account: {
                    id: '',
                    name: '',
                    group: '',
                    sub_group: '',
                    is_active: 1,
                },
                currentIndex: 0,
                accounts: [],
                successMessage: '',
                groups: JSON.parse('{!!$accountGroups!!}'),
                subGroups: JSON.parse('{!!$accountSubGroups!!}'),
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("accounts.all") }}')
                    .then(function (response) {
                        _this.accounts = response.data.accounts;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.account = _this.accounts[index];
                },
                inactiveAccount(index) {
                    var _this = this;
                    let data = {
                        account_id: _this.accounts[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("accounts.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.accounts[index] , 'is_active' , 0);
                            //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Account  status inactivated   successfully'
                                  })

                                    //end sweet alart
                        }
                    })
                },
                activeAccount(index) {
                    var _this = this;
                    let data = {
                        account_id: _this.accounts[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("accounts.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.accounts[index] , 'is_active' , 1);
                            //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Account  status activated   successfully'
                                  })

                                    //end sweet alart
                        }
                    })
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.account = {
                        id: '',
                        name: '',
                        group: '',
                        sub_group: '',
                        is_active: 1,
                    };
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            account: _this.account
                        }
                        axios.post('{{ route("accounts.addOrUpdate") }}', data)
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
                                    _this.accounts.push(data.account);
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
                                      title: 'Account created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    _this.accounts[_this.currentIndex] = data.account;
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
                                      title: 'Account updated successfully'
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
                    let account = _this.account;
                    let count = 0; 

                    if (!account.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!account.group) {
                        _this.errors.push("Group required.");
                        count++;
                    }
                    if (!account.sub_group) {
                        _this.errors.push("Sub group required.");
                        count++;
                    }
                    if (!account.is_active) {
                        _this.errors.push("Status required.");
                        count++;
                    }

                    if(count==0) return true;
                    else return false;
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