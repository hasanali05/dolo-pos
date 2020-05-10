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
<div class="row" id="purchaseTransaction">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Purchase Tarnsection List</h4>
                   <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New purchase
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

                <table class="table table-bordered table-striped" data-mobile-responsive="true" width="100%" cellspacing="0" ref="dataTableContent">
                    <thead>
                        <tr>
                             <th>S/L</th>
                            <th>Suppler Name</th>
                            <th>Reason</th>
                            <th>amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                              <th>S/L</th>
                            <th>Suppler Name</th>
                            <th>Reason</th>  
                            <th>amount</th>   
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(purchase, index) in purchases">
                            <td>@{{index+1}}</td>
                            <td>@{{purchase.supplier?purchase.supplier.name:''}}</td>
                            <td>@{{purchase.reason}}</td>
                            <td>@{{purchase.amount}}</td>
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
                            <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New collection</h5>
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
                                        <select class="form-control form-white" placeholder="Choose Supplier" v-model="purchase.supplier_id">
                                            
                                            <option  v-for="supplier in suppliers" :value="supplier.id">@{{supplier.name}}</option>
                                        </select>
                                        <span class="alart alert-info" v-if="purchase.id">*You cannot update supplier. If you need, just make another transaction or contact with developer.</span>  
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"> <i class="far fa-keyboard"></i></i></button>

                                        <textarea v-model="purchase.note" placeholder="write somethings" style="width: 325px"></textarea>                                    
                                       
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                        <select class="form-control form-white" placeholder="Choose Supplier" v-model="purchase.account_id">     
                                            <option v-for="(account, index) in transactionAccounts" :value="account.id">@{{account.name}}</option>  
                                        </select>
                                        <span class="alart alert-info" v-if="purchase.id">*You cannot update account. If you need, just make another transaction or contact with developer.</span>  
                                        <span class="alart alert-warning w-100" v-else>*Payment account</span>  
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-notepad text-white"></i></button>
                                        <input type="text" class="form-control" placeholder="Amount" v-model="purchase.amount" required="">
                                        <span class="alart alert-info" v-if="purchase.id">*You cannot update amount. If you need, just make another transaction or contact with developer.</span>  
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailLabel">Purchase details</h5>
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
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>supplier Name</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.name:''}}</p>
                                        </div><div class="col-md-6 col-xs-6 b-r"> 
                                            <strong> supplier Contact </strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.contact:''}}</p>
                                        </div>
                                         <div class="col-md-6 col-xs-6 b-r"> <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase.supplier?purchase.supplier.address:''}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">Transaction info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Reason</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.reason:''}}</p>
                                        </div><div class="col-md-6 col-xs-6 b-r"> 
                                            <strong> Amount</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.amount:''}}</p>
                                        </div>
                                         <div class="col-md-6 col-xs-6 b-r"> <strong>Note</strong>
                                            <br>
                                            <p class="text-muted">@{{purchase?purchase.note:''}}</p>
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

</div>

@endsection

@section('custom-js')
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">
        const app = new Vue({
            el: '#purchaseTransaction',
            data: {
                errors: [],
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),
                purchase: {
                    id: '',
                    reason: 3,
                    amount: '',
                    supplier: {
                        id:'',
                        name: '',
                        contact: '',
                    }
                 
                },
                currentIndex: 0,
                purchases:[],        
                suppliers:[],        
                successMessage:'',
                datatable: '',
            },
            mounted() {
                this.datatable = $(this.$refs.dataTableContent).DataTable();
                var _this = this;
                _this.getAllData();
                _this.getAllDatasupplier();
            },
            watch: {
                purchases(val) {
                    this.datatable.destroy();
                    this.$nextTick(() => {
                        this.datatable = $(this.$refs.dataTableContent).DataTable()
                    });
                }
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("purchaseTransaction.all") }}')
                    .then(function (response) {
                        _this.purchases = response.data.purchases;
                    })
                },
                  getAllDatasupplier() {
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
                    _this.purchase = _this.purchases[index];
                },
                      clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.purchase= {
                        id: '',
                    reason: 3,
                    amount: '',
                    supplier: {
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
                            purchase: _this.purchase
                        }
                        axios.post('{{ route("purchaseTransaction.addOrUpdate") }}', data)
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
                                      title: 'purchase created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {

                                    _this.$set( _this.purchases, _this.currentIndex, data.purchase )
                                    _this.purchases[_this.currentIndex] = data.purchase;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'purchase updated successfully';
                                      //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'purchase updated successfully'
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

                    if (!purchase.amount) {
                        _this.errors.push("Price required.");
                        count++;
                    }
                     if (!purchase.note) {
                        _this.errors.push("Note required.");
                        count++;
                    }
                     if (!purchase.supplier_id) {
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