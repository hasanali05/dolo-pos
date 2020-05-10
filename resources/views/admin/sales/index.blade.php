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
                            <a href="{{route('salesdetail.all')}}">
                                <button type="button" class="btn btn-dark" >
                             Sale
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
 
                <table class="table table-bordered" width="100%" cellspacing="0" ref="dataTableContent">
                    <thead style="text-align: center;">
                        <tr>
                            <th>S/L</th>
                            <th>Customer Name</th>
                            <th>Sale Date</th>
                            <th>Sale Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S/L</th>
                            <th>Customer Name</th>
                            <th>Sale Date</th>
                            <th>Sale Amount</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody style="text-align: center;">
                        <tr v-for="(sale, index) in sales">
                            <td>@{{index+1}}</td>
                            <td>@{{sale.customer?sale.customer.name:''}}</td>
                            <td>@{{sale.sale_date}}</td>
                            <td>@{{sale.amount}}</td>
             
                            <td> 
                                <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#saleDetail" @click="setData(index)">
                                    <span class="icon text-white" >
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </button> 
                                <button class="btn btn-warning btn-icon-split" @click="printInvoice(index)">
                                    <span class="icon text-white" >
                                        <i class="fa fa-print"></i>
                                    </span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="saleDetail">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeDetailLabel">Sale detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-xlg-12 col-md-12">
                            <div class="card mb-0">
                                <div class="card-title">Customer info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-3 col-xs-6 b-r"> <strong>customer Name</strong>
                                            <br>
                                            <p class="text-muted">@{{sale.customer?sale.customer.name:''}}</p>
                                        </div><div class="col-md-3 col-xs-6 b-r"> 
                                            <strong> customer Contact </strong>
                                            <br>
                                            <p class="text-muted">@{{sale.customer?sale.customer.contact:''}}</p>
                                        </div>
                                         <div class="col-md-3 col-xs-6 b-r"> <strong>Address</strong>
                                            <br>
                                            <p class="text-muted">@{{sale.customer?sale.customer.address:''}}</p>
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
                                <div class="card-title">Sale info</div>
                                <div class="card-body">
                                    <div class="row"> 
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Sale Date</strong>
                                            <br>
                                            <p class="text-muted">@{{sale?sale.sale_date:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Sale</strong>
                                            <br>
                                            <p class="text-muted">@{{sale?sale.amount:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Convyance</strong>
                                            <br>
                                            <p class="text-muted">@{{sale?sale.commission:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Paid</strong>
                                            <br>
                                            <p class="text-muted">@{{sale?sale.payment:''}}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 b-r"> <strong>Total Due</strong>
                                            <br>
                                            <p class="text-muted">@{{sale?sale.due:''}}</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                        <div class="col-lg-12 col-xlg-12 col-md-12" v-if="sale.details">
                            <div class="card mb-0">
                                <div class="card-title">Sale Detail</div>
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
                                                        <th>Qty</th>
                                                        <th>Warranty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                    <tr v-for="(sale,index) in sale.details">
                                                        <td>@{{index+1}}</td>
                                                        <td>@{{sale.inventory?sale.inventory.product.name:''}}</td>
                                                        <td>@{{sale.unique_code}}</td>
                                                        <td>@{{sale.price}}</td>
                                                        <td>@{{sale.quantity}}</td>
                                                        <td>@{{sale.warranty_duration}} @{{sale.warranty_type}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
        <form id="print-form"  target="_blank" action="{{route('admin.invoice')}}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="invoiceId" :value="InvoiceSaleId"/>
            <input type="hidden" name="type" value="sale"/>
        </form>
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
                InvoiceSaleId: '',
                datatable: '',
            },
            mounted() {
                this.datatable = $(this.$refs.dataTableContent).DataTable();
                var _this = this;
                _this.getAllData();
                _this.getAllCustomerData();
            },
            watch: {
                sales(val) {
                    this.datatable.destroy();
                    this.$nextTick(() => {
                        this.datatable = $(this.$refs.dataTableContent).DataTable()
                    });
                }
            },
            methods: {
                printInvoice (index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.sale = _this.sales[index];
                    
                    _this.$set(_this, 'InvoiceSaleId', _this.sale.id);
                    setTimeout(() => {
                        document.getElementById('print-form').submit();
                    }, 100);
                },
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
                                    
                                      //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Sale created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    _this.sales[_this.currentIndex] = data.sale;
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
                                      title: 'sale created successfully'
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