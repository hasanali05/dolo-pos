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
<div class="row" id="warrant">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Category List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Warrenty
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
                        <th>Purchase Date</th>
                        <th>Sale Date</th>
                        <th>Warranty Type</th>
                        <th>Warranty Start</th>
                        <th>Warranty End</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                          <th>S/L</th>
                        <th>Purchase Date</th>
                        <th>Sale Date</th>
                        <th>Warranty Type</th>
                        <th>Warranty Start</th>
                        <th>Warranty End</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(warrant, index) in warranties">
                        <td>@{{index+1}}</td>
                        <td>@{{warrant.purchase?warrant.purchase.purchase_date:''}}</td>
                        <td>@{{warrant.sale?warrant.sale.sale_date:''}}</td>
                        <td>@{{warrant.warranty_type}}</td>
                        <td>@{{warrant.warranty_start}}</td>
                        <td>@{{warrant.warranty_end}}</td>
                        <td>     
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#warrantDetail" @click="setData(index)">
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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="warrantDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">warrant details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card mb-0">
                                    <div class="card-title">Purchase info</div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Purchase Date</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.purchase?warrant.purchase.purchase_date:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>purchase amount</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.purchase?warrant.purchase.amount:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>purchase commission</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.purchase?warrant.purchase.commission:''}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>purchase payment</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.purchase?warrant.purchase.payment:''}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>purchase due</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.purchase?warrant.purchase.due:''}}</p>
                                            </div>
                                          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card mb-0">
                                    <div class="card-title">warrant info</div>
                                    <div class="card-body">
                                        <div class="row"> 
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>Warranty Duration </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.warranty_duration}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                             Warranty Type</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.warranty_type}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Warranty Start</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.warranty_start}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Warranty end</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.warranty_end}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Issue Date</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.issue_date}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Reason</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.reason}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>return Date</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.return_date}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Status</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.status}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card mb-0">
                                    <div class="card-title">Inventory info</div>
                                    <div class="card-body">                                  
                                        <div class="row"> 
                                            <div class="col-md-3 col-xs-6 b-r"> <strong> Unique Code</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.inventory?warrant.inventory.unique_code:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong> Quantity </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.inventory?warrant.inventory.quantity:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Buying Price </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.inventory?warrant.inventory.buying_price:''}}</p>
                                            </div> 
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Selling Price </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.inventory?warrant.inventory.selling_price:''}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Status </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.inventory?warrant.inventory.status:''}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card mb-v-">
                                    <div class="card-title">Sale info</div>
                                        <div class="card-body">

                                        <div class="row"> 
                                            <div class="col-md-3 col-xs-6 b-r"> <strong> Sale Date</strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.sale?warrant.sale.sale_date:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong> Amount </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.sale?warrant.sale.amount:''}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Commission </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.sale?warrant.sale.commission:''}}</p>
                                            </div> 
                                            <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Payment </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.sale?warrant.sale.payment:''}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> 
                                                <strong>
                                            Due </strong>
                                                <br>
                                                <p class="text-muted">@{{warrant.sale?warrant.sale.due:''}}</p>
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



     <div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="javascript:void(0)" method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Wrentry</h5>
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
                                        <select class="form-control form-white" placeholder="Choose Supplier" v-model="warrant.inventory">
                                              <option  v-for="inventory in inventories" :value="inventory">@{{inventory.product?inventory.product.name:''}}</option>
                                                                          
                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="far fa-calendar-alt"></i></button>
                                        <input type="date" class="form-control" placeholder="Issue Date" v-model="warrant.issue_date" required="">
                                        <input type="hidden" class="form-control" v-model="warrant.id">
                                    </div>
                                </div>
                                   <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="far fa-keyboard"></i></button>
                                        <input type="text" class="form-control" placeholder="Reason" v-model="warrant.reason" required="">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="far fa-calendar-alt"></i></button>
                                        <input type="date" class="form-control" placeholder=" Return Date" v-model="warrant.return_date" required="">
                                    </div>
                                </div>

                                   <div class="col-6">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="fas fa-angle-double-down"></i></button>
                                        <select class="form-control form-white" placeholder="Choose Supplier" v-model="warrant.status">

                                            <option value="pending">pending</option>
                                            <option value="accepted">accepted</option>
                                            <option value="declined">declined</option>
                                            <option value="solved">solved</option>
                                            <option value="returned">returned</option>
                                            <option value="refunded">returned</option>
                                              
                                                                          
                                          
                                        </select>
                                    </div>
                                </div>
                            </div>
                             

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                            <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                            <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!warrant.id"><i class="ti-save"></i> Save</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="warrant.id"><i class="ti-save"></i> Update</button>
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
            el: '#warrant',
            data: {
                errors: [],
                warrant: {
                    id: '',
                    warranty_duration: '',
                    warranty_type: '',
                    warranty_start: '',
                    warranty_end: '',
                    issue_date: '',
                    reason: '',
                    return_date: '',
                    status: '',
                    purchase:{
                        id:'',
                       
                    },
                    inventory:{
                        id:'',     
                    },
                    sale:{
                        id:'',
                       
                    }
                },
                currentIndex: 0,
                warranties: [],                
                inventories: [],                
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
                _this.getAllInventory();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("warranties.all") }}')
                    .then(function (response) {
                        _this.warranties = response.data.warranties;
                    })
                },
           
                 getAllInventory() {
                    var _this = this;
                    axios.get('{{ route("inventories.all") }}')
                    .then(function (response) {
                        _this.inventories = response.data.inventories;
                    })
                },
             
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.warrant = _this.warranties[index];
                },


                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.warrant= {
                     id: '',
                     warranty_duration: '',
                     warranty_type: '',
                     warranty_start: '',
                     warranty_end: '',
                     issue_date: '',
                     reason: '',
                     return_date: '',
                     status: '',
                    }
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            warranty: _this.warrant
                        }
                        axios.post('{{ route("warranties.addOrUpdate") }}', data)
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
                                    _this.warranties.push(data.warranty);
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
                                      title: 'warrant created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {

                                    _this.$set( _this.warranties, _this.currentIndex, data.warranty )
                                    _this.warranties[_this.currentIndex] = data.warranty;
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
                                      title: 'warrant updated successfully'
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
                    let warrant = _this.warrant;
                    let count = 0; 

                    if (!warrant.reason) {
                        _this.errors.push("reason required.");
                        count++;
                    }
                     if (!warrant.return_date) {
                        _this.errors.push("Return date Date required.");
                        count++;
                    }
                     if (!warrant.issue_date) {
                        _this.errors.push("Issue date required.");
                        count++;
                    }
                     if (!warrant.inventory.id) {
                        _this.errors.push("product name name required.");
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