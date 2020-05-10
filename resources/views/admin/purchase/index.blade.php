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

            <table class="table table-bordered table-striped" data-mobile-responsive="true" width="100%" cellspacing="0" ref="dataTableContent">
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
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

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
                datatable: '',
            },
            mounted() {
                this.datatable = $(this.$refs.dataTableContent).DataTable();
                var _this = this;
                _this.getAllData();
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