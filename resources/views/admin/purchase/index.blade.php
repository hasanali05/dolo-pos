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
<div class="row" id="purchase">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Purchase List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <a href="{{route('purchasesdetail.all')}}">
                                <button type="button" class="btn btn-dark" >
                             Purchase
                            </button>
                            </a>
                            
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
                        <th>Supplier Name</th>
                        <th>Purchase Date</th>
                        <th>Purchase Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Supplier Name</th>
                        <th>Purchase Date</th>
                        <th>Purchase Amount</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(purchase, index) in purchases">
                        <td>@{{index+1}}</td>
                        <td>@{{purchase.supplier?purchase.supplier.name:''}}</td>
                        <td>@{{purchase.purchase_date}}</td>
                        <td>@{{purchase.amount}}</td>

         
                        <td> 
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#supplyDetail" @click="setData(index)">
                                <span class="icon text-white" >
                                    <i class="fas fa-eye"></i>
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
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Purchase</h5>
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
                                    <select class="form-control form-white" v-model="purchase.supplier.id">
                                        
                                        <option v-for="purchase in purchases">@{{purchase.supplier?purchase.supplier.name:''}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Purchase Date" v-model="purchase.purchase_date" required="">
                                    <input type="hidden" class="form-control" v-model="purchase.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Amount" v-model="purchase.amount" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Commission" v-model="purchase.commission" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Payment" v-model="purchase.payment" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Due" v-model="purchase.due" required="">
                                    
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="purchase.is_active">
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!purchase.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="purchase.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailLabel">Purchase detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">Supplier info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>supplier Name</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.name:''}}</p>
                                        </div><div class="col-md-3 col-xs-6 b-r"> 
                                            <strong> supplier Contact </strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.contact:''}}</p>
                                        </div>
                                         <div class="col-md-3 col-xs-6 b-r"> <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.address:''}}</p>
                                        </div>

                                        <div class="col-md-3 col-xs-6 b-r">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">Purchase info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Purchase Date</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.purchase_date:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Purchase</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.amount:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Convyance</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.commission:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Paid</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.payment:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Due</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.due:''}}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12" v-if="purchase.supplies">
                            <div class="card mb-0">
                                <div class="card-title">Purchase Detail</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-12 col-xs-12 b-r">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>S/L</th>
                                                        <th>Product</th>
                                                        <th>Unique code</th>
                                                        <th>Price</th>
                                                        <th>Warranty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    <tr v-for="(supply,index) in purchase.supplies">
                                                        <td>@{{index+1}}</td>
                                                        <td>@{{supply.product?supply.product.name:''}}</td>
                                                        <td>@{{supply.unique_code}}</td>
                                                        <td>@{{supply.price}}</td>
                                                        <td>@{{supply.warranty_duration}} @{{supply.warranty_type}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  v-on:click="counter += 1" >Close</button>
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
            el: '#purchase',
            data: {
                errors: [],
                purchase: {
                    id: '',
                    purchase_date: '',
                    amount: '',
                    commission: '',
                    payment: '',
                    due: '',
                    is_active: '1',
                    supplier: {
                        id:'',
                        name: ''
                    }
                },
                currentIndex: 0,
                purchases: [],                
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("purchases.all") }}')
                    .then(function (response) {
                        _this.purchases = response.data.purchases;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.purchase = _this.purchases[index];
                },

           
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.purchase = {
                        id: '',
                        purchase_date: '',
                        amount: '',
                        commission: '',
                        payment: '',
                        due: '',
                        is_active: '1',
                        supplier:{
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
                            purchase: _this.purchase
                        }
                        axios.post('{{ route("purchases.addOrUpdate") }}', data)
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
                                    _this.purchases.push(data.purchase);
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
                                      title: 'Purchase created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    _this.purchases[_this.currentIndex] = data.purchase;
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
                                      title: 'Purchase updated successfully'
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
                    let purchase = _this.purchase;
                    let count = 0; 

                    if (!purchase.purchase_date) {
                        _this.errors.push("Purchase date required.");
                        count++;
                    }
                     if (!purchase.amount) {
                        _this.errors.push("Amount required.");
                        count++;
                    }
                    if (!purchase.commission) {
                        _this.errors.push("Commission required.");
                        count++;
                    }

                     if (!purchase.payment) {
                        _this.errors.push("Payment required.");
                        count++;
                    }
                     if (!purchase.due) {
                        _this.errors.push("Due required.");
                        count++;
                    }
                     if (!purchase.supplier.id) {
                        _this.errors.push("Supplier name required.");
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