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
<div class="row" id="supplier">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Suppler List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Suppler
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

            <table class="table table-bordered table-striped" data-mobile-responsive="true" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Suppler Name</th>
                        <th>Suppler Contact</th>
                        <th>Account name</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Suppler Name</th>
                        <th>Suppler Contact</th>
                        <th>Account name</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(supplier, index) in suppliers">
                        <td>@{{index+1}}</td>
                        <td>@{{supplier.name}}</td>
                        <td>@{{supplier.contact}}</td>
                        <td>@{{supplier.account?supplier.account.name:''}}</td>

      

                        
                        <td>
                            <span class="badge badge-success" v-if="supplier.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="supplier.is_active == 1" @click.prevent="inactivesupplier(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="supplier.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="supplier.is_active == 0" @click.prevent="activesupplier(index)">Active-it</button> 
                        </td>
                        <td> 
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#supplyDetail" @click="setData(index)">
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


<div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Supplier</h5>
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
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="supplier.account_id">
                                        <option>select Supplier Name</option>
                                        <option v-for="account in accounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="name" v-model="supplier.name" required="">
                                    <input type="hidden" class="form-control" v-model="supplier.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="contact" v-model="supplier.contact" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Address" v-model="supplier.address" required="">
                                    
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="supplier.is_active">
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!supplier.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="supplier.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Supply detail</h5>
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
                                            <h6 class="card-subtitle"></h6>

                                            <span class="badge badge-success" v-if="supplier.is_active == 1">Active</span>
                                            <span class="badge badge-danger" v-if="supplier.is_active == 0">In-active</span>

                                        </center>
                                    </div>

                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-8 col-xlg-9 col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Account Name</strong>
                                                <br>
                                                <p class="text-muted">@{{supplier.account?supplier.account.name:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Name</strong>
                                                <br>
                                                <p class="text-muted">@{{supplier.name}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">@{{supplier.contact}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Address</strong>
                                                <br>
                                                <p class="text-muted">@{{supplier.address}}</p>
                                            </div>






                                        </div>

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
    


</div>



@endsection

@section('custom-js')

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">
        const app = new Vue({
            el: '#supplier',
            data: {
                errors: [],
                supplier: {
                    id: '',
                    account_id:'',
                    name: '',
                    contact: '',
                    address: '',
                    is_active: '1',
                    account: {
                        id:'',
                        name: ''
                    }
                },
                currentIndex: 0,
                suppliers: [],               
                accounts: [],               
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
                _this.getAllAccountData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("accounts.all") }}')
                    .then(function (response) {
                        _this.accounts = response.data.accounts;
                    })
                },

                getAllAccountData(){
                      var _this = this;
                    axios.get('{{ route("suppliers.all") }}')
                    .then(function (response) {
                        _this.suppliers = response.data.suppliers;
                    })

                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.supplier = _this.suppliers[index];
                },
                inactivesupplier(index) {
                    var _this = this;
                    let data = {
                        supplier_id: _this.suppliers[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("suppliers.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.suppliers[index] , 'is_active' , 0);
                            _this.successMessage = 'Supplier status inactivated successfully';
                        }
                    })
                },
                activesupplier(index) {
                    var _this = this;
                    let data = {
                         supplier_id: _this.suppliers[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("suppliers.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.suppliers[index] , 'is_active' , 1);
                            _this.successMessage = 'Supplier  status activated successfully';
                        }
                    })
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.supplier = {
                        id: '',
                        name: '',
                        account_id: '',
                        contact: '',
                        address: '',
                        is_active: '1',
                        account:{
                            id:'',
                            name:''
                         
                  
                    
                    }
                        }
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            supplier: _this.supplier
                        }
                        axios.post('{{ route("suppliers.addOrUpdate") }}', data)
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
                                    _this.suppliers.push(data.supplier);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Supplier created successfully';
                                }
                                if(status=='updated') {
                                    
                                    _this.$set( _this.suppliers, _this.currentIndex, data.supplier )
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Supplier updated successfully';
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
                    let supplier = _this.supplier;
                    let count = 0; 

                    if (!supplier.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                     if (!supplier.contact) {
                        _this.errors.push("Contact required.");
                        count++;
                    }
                    if (!supplier.address) {
                        _this.errors.push("Address required.");
                        count++;
                    }

                     if (!supplier.account_id) {
                        _this.errors.push("Account name required.");
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