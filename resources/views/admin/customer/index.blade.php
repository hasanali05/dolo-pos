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
<div class="row" id="customer">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Customer List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Customer
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
                        <th>Account name</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>   
                        <th>Customer Address</th>   
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Account name</th>
                        <th>Customer Name</th>
                        <th>Customer Contact</th>   
                        <th>Customer Address</th>   
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(customer, index) in customers">
                        <td>@{{index+1}}</td>
                        <td>@{{customer.account?customer.account.name:''}}</td>
                        <td>@{{customer.name}}</td>
                        <td>@{{customer.contact}}</td>
                        <td>@{{customer.address}}</td>
                        

                        <td>
                            <span class="badge badge-success" v-if="customer.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="customer.is_active == 1" @click.prevent="inactivecustomer(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="customer.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="customer.is_active == 0" @click.prevent="activecustomer(index)">Active-it</button> 
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

            </div>
        </div>
    </div>


<div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New customer</h5>
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
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-double-down"></i></button>
                                    <select class="form-control form-white" v-model="customer.account_id">
                                        <option>select Account Name</option>
                                        <option v-for="account in accounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="name" v-model="customer.name" required="">
                                    <input type="hidden" class="form-control" v-model="customer.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-phone"></i></button>
                                    <input type="text" class="form-control" placeholder="contact" v-model="customer.contact" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-address-card"></i></button>
                                    <input type="text" class="form-control" placeholder="Address" v-model="customer.address" required="">
                                    
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="customer.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!customer.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="customer.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
            <div class="modal-dialog modal-lg" role="document">
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
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">  
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Account Name</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.account?customer.account.name:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Name</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.name}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.contact}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Status</strong>
                                                <br>
                                                <h3>
                                                    <span class="badge badge-success" v-if="customer.is_active == 1">Active
                                                    </span>
                                                    <span class="badge badge-danger" v-else>Inactive
                                                    </span>
                                                </h3>
                                            </div>
                                            <div class="col-md-6 col-xs-6 b-r"> <strong>Address</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.address}}</p>
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
            el: '#customer',
            data: {
                errors: [],
                customer: {
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
                customers: [],               
                accounts: JSON.parse('{!!$receivableAccounts!!}'),               
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("customers.all") }}')
                    .then(function (response) {
                        _this.customers = response.data.customers;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.customer = _this.customers[index];
                    console.log(_this.customer)
                },
                inactivecustomer(index) {
                    var _this = this;
                    let data = {
                        customer_id: _this.customers[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("customers.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.customers[index] , 'is_active' , 0);
                           
                              //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'customer status inactivated  successfully'
                                  })

                                    //end sweet alart
                        }
                    })
                },
                activecustomer(index) {
                    var _this = this;
                    let data = {
                         customer_id: _this.customers[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("customers.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.customers[index] , 'is_active' , 1);
                           
                              //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'customer  status activated  successfully'
                                  })

                                    //end sweet alart
                        }
                    })
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.customer = {
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
                            customer: _this.customer
                        }
                        axios.post('{{ route("customers.addOrUpdate") }}', data)
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
                                    _this.customers.push(data.customer);
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
                                      title: 'Customer created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    
                                    _this.$set( _this.customers, _this.currentIndex, data.customer )
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
                                      title: 'Customer updated successfully'
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
                    let customer = _this.customer;
                    let count = 0; 

                    if (!customer.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                     if (!customer.contact) {
                        _this.errors.push("Contact required.");
                        count++;
                    }
                    if (!customer.address) {
                        _this.errors.push("Address required.");
                        count++;
                    }

                     if (!customer.account_id) {
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