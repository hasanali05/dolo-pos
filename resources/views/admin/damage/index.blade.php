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
<div class="row" id="damage">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Damage List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                          <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Damage
                            </button>
                          </div>
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
                        <th>Inventory Status</th>
                        <th>Unique Code</th>
                        <th>Issue Dae</th>
                        <th>Reson</th>
                        <th>Status</th>
            
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Inventory Status</th>
                        <th>Unique Code</th>
                        <th>Issue Dae</th>
                        <th>Reson</th>
                        <th>Status</th>
                 
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(damage, index) in damages">
                        <td>@{{index+1}}</td>
                        <td>@{{damage.inventory?damage.inventory.status:''}}</td>
                        <td>@{{damage.inventory?damage.inventory.unique_code:''}}</td>
                        <td>@{{damage.issue_date}}</td>
                        <td>@{{damage.reason}}</td>
                        <td>@{{damage.status}}</td>
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


<div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New damage</h5>
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
                                    <select class="form-control form-white" v-model="damage.inventory_id">
                                        <option>select Inventory</option>
                                        <option v-for="inventory in inventories" :value="inventory.id">@{{inventory.status}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Issue Date" v-model="damage.issue_date" required="">
                                    <input type="hidden" class="form-control" v-model="damage.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Reson" v-model="damage.reason" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Status" v-model="damage.status" required="">
                                    
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!damage.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="damage.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">damage detail</h5>
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
                                            
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Unique Code</strong>
                                                <br>
                                                <p class="text-muted">@{{damage.inventory?damage.inventory.unique_code:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Issue Date</strong>
                                                <br>
                                                <p class="text-muted">@{{damage.issue_date}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>damage Reason</strong>
                                                <br>
                                                <p class="text-muted">@{{damage.reason}}</p>
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
            el: '#damage',
            data: {
                errors: [],
                damage: {
                    id: '',
                    inventory_id:'',
                    issue_date: '',
                    reason: '',
                    status: '',
                    inventories: {
                        id:'',
                        unique_code: ''
                    }
                },
                currentIndex: 0,
                damages: [],               
                inventories: [],               
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
                _this.getAllAccountData();
            },
            methods: {
                getAllAccountData() {
                    var _this = this;
                    axios.get('{{ route("inventories.all") }}')
                    .then(function (response) {
                        _this.inventories = response.data.inventories;
                    })
                },

                getAllData(){
                      var _this = this;
                    axios.get('{{ route("damages.all") }}')
                    .then(function (response) {
                        _this.damages = response.data.damages;
                    })

                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.damage = _this.damages[index];
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.damage = {
                        id: '',
                        inventory_id:'1',
                        issue_date: '',
                        reason: ''
    
                        }
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            damage: _this.damage
                        }
                        axios.post('{{ route("damages.addOrUpdate") }}', data)
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
                                    _this.damages.push(data.damage);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'damage created successfully';
                                }
                                if(status=='updated') {
                                    
                                    _this.$set( _this.damages, _this.currentIndex, data.damage )
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'damage updated successfully';
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
                    let damage = _this.damage;
                    let count = 0; 

                    if (!damage.issue_date) {
                        _this.errors.push("Date required.");
                        count++;
                    }
                     if (!damage.reason) {
                        _this.errors.push("Reason required.");
                        count++;
                    }
                    if (!damage.status) {
                        _this.errors.push("Status required.");
                        count++;
                    }
                    if (!damage.inventory_id) {
                        _this.errors.push("Inventory required.");
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