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
<div class="row" id="sales"> 
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Sale List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Sale
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
                        <th>Customer Name</th>
                        <th>Sale Date</th>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Payment</th>
                        <th>Due</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Customer Name</th>
                        <th>Sale Date</th>
                        <th>Amount</th>
                        <th>Commission</th>
                        <th>Payment</th>
                        <th>Due</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody style="text-align: center;">
                    <tr v-for="(sale, index) in sales">
                        <td>@{{index+1}}</td>
                        <td>@{{sale.customer?sale.customer.name:"Empty"}}</td>
                        <td>@{{sale.sale_date}}</td>
                        <td>@{{sale.amount}}</td>
                        <td>@{{sale.commission}}</td>
                        <td>@{{sale.payment}}</td>
                        <td>@{{sale.due}}</td>
                        <td>
                            <span class="badge badge-success" v-if="sale.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="sale.is_active == 1" @click.prevent="inactivesale(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="sale.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="sale.is_active == 0" @click.prevent="activesale(index)">Active-it</button> 
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
                        <h5 class="modal-title" id="employeeDetailLabel">Sale Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
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
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Sale</h5>
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
                                    <select class="form-control form-white" v-model="sale.customer_id">
                                        <option>--select Customer Name--</option>
                                        <option v-for="customer in customers" :value="customer.id">@{{customer.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                     <input type="date" class="form-control" placeholder="date" v-model="sale.sale_date">
                       
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                     <input type="number" class="form-control" placeholder="amount" v-model="sale.amount">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                     <input type="number" class="form-control" placeholder="commission" v-model="sale.commission">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                     <input type="number" class="form-control" placeholder="payment" v-model="sale.payment">
                                </div>
                            </div>
                             <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                     <input type="number" class="form-control" placeholder="due" v-model="sale.due">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="sale.is_active">
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!sale.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="sale.id"><i class="ti-save"></i> Update</button>
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
            el: '#sales',
            data: {
                errors: [],
                sale: {
                    id: '',
                    sale_date: '',
                    amount: '',
                    commission: '',
                    payment: '',
                    due: '',
                    is_active: 1,

                customers:{
                     account_id:'',
                     name:'',
                     contact:'',
                     address:'',
                    }
                },
                currentIndex: 0,
                sales: [],
                customers: [],
                successMessage: '',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
                  _this.getAllCustomerData();
            },
            methods: {
                getAllCustomerData() {
                    var _this = this;
                    axios.get('{{ route("customers.all") }}')
                    .then(function (response) {
                        _this.customers = response.data.customers;
                    })
                },
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("sales.all") }}')
                    .then(function (response) { 
                        _this.sales = response.data.sales;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.sale = _this.sales[index];   
                },
                inactivesale(index) {
                    var _this = this;
                    let data = {
                        sale_id: _this.sales[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("sales.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.sales[index] , 'is_active' , 0);
                            _this.successMessage = 'Sale status inactivated successfully';
                        }
                    })
                },
                activesale(index) {
                    var _this = this;
                    let data = {
                        sale_id: _this.sales[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("sales.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.sales[index] , 'is_active' , 1);
                              _this.successMessage = 'Sale status activated successfully';
                        }
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.sale = _this.sales[index];
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.sale = {
                        id: '',
                    sale_date: '',
                    amount: '',
                    commission: '',
                    payment: '',
                    due: '',
                    is_active: 1, 
                    };
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            sale: _this.sale
                        }
                        axios.post('{{ route("sales.addOrUpdate") }}', data)
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
                                    _this.sales.push(data.sale);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Sale created successfully.';
                                }
                                if(status=='updated') {
                                    _this.sales[_this.currentIndex] = data.sale;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'sale updated successfully.';
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
                    let sale = _this.sale;
                    let count = 0; 

                    if (!sale.payment) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!sale.amount) {
                        _this.errors.push("Amount required.");
                        count++;
                    }
                    if (!sale.commission) {
                        _this.errors.push("Commission required.");
                        count++;
                    }
                    if (!sale.payment) {
                        _this.errors.push("Payment required.");
                        count++;
                    }
                    if (!sale.due) {
                        _this.errors.push("Due required.");
                        count++;
                    }
                    if (!sale.is_active) {
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