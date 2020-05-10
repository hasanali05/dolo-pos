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
<div class="row" id="purchasesDetails">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Purchase List</h4>
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
                            <th>Purchase Name</th>
                            <th>Inventory Date</th>
                            <th>price Amount</th>
                            <th>warranty_duration </th>
                            <th>warranty_type </th>
                            <th>unique_code </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th>S/L</th>
                            <th>Purchase Name</th>
                            <th>Inventory Date</th>
                            <th>price Amount</th>
                            <th>warranty_duration </th>
                            <th>warranty_type </th>
                            <th>unique_code </th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(purchasesDetail, index) in purchasesDetails">
                            <td>@{{index+1}}</td>
                            <td>@{{purchasesDetail.purchase?purchasesDetail.purchase.name:''}}</td>
                            <td>@{{purchasesDetail.inventory?purchasesDetail.inventory.name:''}}</td>
                            <td>@{{purchasesDetail.price}}</td>
                            <td>@{{purchasesDetail.warranty_duration}}</td>
                            <td>@{{purchasesDetail.warranty_type}}</td>
                            <td>@{{purchasesDetail.unique_code}}</td>
             
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
                            <!-- Column -->
                            <div class="col-lg-4 col-xlg-3 col-md-5">
                                <div class="card">
                                    

                                </div>
                            </div>
                            <!-- Column -->
                            <!-- Column -->
                            <div class="col-lg-8 col-xlg-9 col-md-7">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>supplier Name</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.purchase?purchasesDetail.purchase.name:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Purchase Date</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.inventory?purchasesDetail.inventory.name:''}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Amount</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.price}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Commission</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.warranty_type}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Payment</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.warranty_duration}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Due</strong>
                                                <br>
                                                <p class="text-muted">@{{purchasesDetail.unique_code}}</p>
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
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script src="http://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">
        const app = new Vue({
            el: '#purchasesDetails',
            data: {
                errors: [],
                purchasesDetail: {
                    id: '',
                    purchase_id: '',
                    inventory_id: '',
                    price: '',
                    warranty_duration: '',
                    warranty_type: '',
                    unique_code: '',
                    purchase: {
                        id:'',
                        name: ''
                    },
                    inventory: {
                        id:'',
                        name: ''
                    }

                },
                currentIndex: 0,
                purchasesDetails: [],                
                successMessage:'',
                datatable: '',
            },
            mounted() {
                this.datatable = $(this.$refs.dataTableContent).DataTable();
                var _this = this;
                // _this.getAllData();
            },
            watch: {
                purchasesDetails(val) {
                    this.datatable.destroy();
                    this.$nextTick(() => {
                        this.datatable = $(this.$refs.dataTableContent).DataTable()
                    });
                }
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("purchasesDetails.all") }}')
                    .then(function (response) {
                        _this.purchasesDetails = response.data.purchasesDetails;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.purchasesDetail = _this.purchasesDetails[index];
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