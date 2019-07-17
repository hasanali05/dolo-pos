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
<div class="row" id="saleTransactions">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Sale Transection  List</h4>
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

            <table class="table table-bordered table-striped" data-mobile-responsive="true" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Customer Name</th>
                        <th>Reson</th>
                        <th>Amount</th>
                        <th>Action</th>
         
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                       <th>Customer Name</th>
                        <th>Reson</th>
                        <th>Amount</th>
                        <th>Action</th>
               
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(saleTransaction, index) in saleTransactions">
                        <td>@{{index+1}}</td>
                        <td>@{{saleTransaction.customer?saleTransaction.customer.name:''}}</td>
                        <td>@{{saleTransaction.reason}}</td>
                        <td>@{{saleTransaction.amount}}</td>

         
                        <td> 
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#saleTransactionModel" @click="setData(index)">
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
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose Customer" v-model="saleTransaction.customer_id">
                                        
                                        <option  v-for="customer in customers" :value="customer.id">@{{customer.name}}</option>
                            
                                      
                                    </select>
                                </div>
                            </div>
                          
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="saleTransaction.reason">
                                        
                                        <option :value="3">Collection</option>
                            
                                      
                                    </select>
                                </div>
                            </div>
                                <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Price" v-model="saleTransaction.amount" required="">
                                    <input type="hidden" class="form-control" v-model="saleTransaction.id">
                                </div>
                            </div>
                                <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>

                                    <textarea v-model="saleTransaction.note" placeholder="write somethings" style="width: 325px"></textarea>
                                 
                                   
                                </div>
                            </div>
                         
                           
                         
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!saleTransaction.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="saleTransaction.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="saleTransactionModel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailLabel">saleTransaction details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">customer info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>customer Name</strong>
                                            <br>
                                            <p class="text-muted">@{{saleTransaction.customer?saleTransaction.customer.name:''}}</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> 
                                            <strong> customer Contact </strong>
                                            <br>
                                            <p class="text-muted">@{{saleTransaction.customer?saleTransaction.customer.contact:''}}</p>
                                        </div>
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">@{{saleTransaction.customer?saleTransaction.customer.address:''}}</p>
                                        </div>
                                      
                                      
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">Transaction Detail</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-12 col-xs-12 b-r">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <th>S/L</th>
                                                    <th>Reason</th>
                                                    <th>Amount</th>
                                                    <th>Balance</th>
                                                    <th>Note</th>
                                                </thead>
                                                <tbody>    
                                                    <td>S/L</td>
                                                    <td>@{{saleTransaction.reason}}</td>
                                                    <td>@{{saleTransaction.amount}}</td>
                                                    <td>@{{saleTransaction.amount}}</td>
                                                    <td>@{{saleTransaction.note}}</td>
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
            el: '#saleTransactions',
            data: {
                errors: [],
                saleTransaction: {
                    id: '',
                    reason: 3,
                    amount: '',
                      customer: {
                        id:'',
                        name: '',
                        contact: '',
                    }

                },
                currentIndex: 0,
                saleTransactions: [],                              
                customers: [],                              
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
                _this.getAllDatacustomer();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("saleTransaction.all") }}')
                    .then(function (response) {
                        _this.saleTransactions = response.data.saleTransactions;
                    })
                },
                  getAllDatacustomer() {
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
                    _this.saleTransaction = _this.saleTransactions[index];
                },

                  clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.saleTransaction= {
                        id: '',
                    reason: 3,
                    amount: '',
                    customer: {
                        id:'',
                        name: '',
                        contact: '',
                    }
                    }
                },

                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            saleTransaction: _this.saleTransaction
                        }
                        axios.post('{{ route("saleTransaction.addOrUpdate") }}', data)
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
                                    _this.saleTransactions.push(data.saleTransaction);
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
                                      title: 'saleTransaction created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {

                                    _this.$set( _this.saleTransactions, _this.currentIndex, data.saleTransaction )
                                    _this.saleTransactions[_this.currentIndex] = data.saleTransaction;
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
                                      title: 'saleTransaction updated successfully'
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
                    let saleTransaction = _this.saleTransaction;
                    let count = 0; 

                    if (!saleTransaction.amount) {
                        _this.errors.push("Price required.");
                        count++;
                    }
                     if (!saleTransaction.note) {
                        _this.errors.push("Note required.");
                        count++;
                    }
                     if (!saleTransaction.customer_id) {
                        _this.errors.push("Customer name required.");
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