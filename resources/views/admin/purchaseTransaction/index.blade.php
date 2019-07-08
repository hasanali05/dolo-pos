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
                                 
                        </td>

                    </tr>
                </tbody>
            </table>

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
                            <!-- Column -->
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card">
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
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Reason</strong>
                                                <br>
                                                <p class="text-muted">@{{purchase.reason}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Amount </strong>
                                                <br>
                                                <p class="text-muted">@{{purchase.amount}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> 
                                             
                                         
                                         
                                           
                                          
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
            el: '#purchaseTransaction',
            data: {
                errors: [],
                purchase: {
                    id: '',
                    reason: '',
                    amount: '',
                    supplier: {
                        id:'',
                        name: '',
                        contact: '',
                    }
                 
                },
                currentIndex: 0,
                purchases:[],        
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("purchaseTransaction.all") }}')
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