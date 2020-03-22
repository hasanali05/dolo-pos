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
<div class="row" id="balanceTransfers">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Balance Transfers List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark mr-2" data-toggle="modal" data-target="#creatAccountemodel"  @click.prevent="clearAccountData()">
                            Create Balance Transfer Account
                            </button>
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#balanceTransferModal"  @click.prevent="clearData()">
                            Balance Transfer
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
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot style="text-align: center;">
                    <tr>
                        <th>S/L</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody style="text-align: center;">
                    <tr v-for="(balanceTransfer, index) in balanceTransfers">
                        <td>@{{index+1}}</td>
                        <td>@{{balanceTransfer.from ? balanceTransfer.from.name : 'not found'}}</td>
                        <td>@{{balanceTransfer.to ? balanceTransfer.to.name : 'not found'}}</td>
                        <td>@{{balanceTransfer.amount}}</td>
                        <td>@{{balanceTransfer.note}}</td>
                        <td>     
                            {{-- <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#balanceTransferDetail" @click="setData(index)">
                                <span class="icon text-white" >
                                    <i class="fas fa-eye"></i>
                                </span>
                            </button>  --}}
                            <button class="btn btn-warning btn-icon-split"   data-toggle="modal" data-target="#balanceTransferModal"  @click="setData(index)">
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
    
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="balanceTransferDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Balance Transfer Detail</h5>
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
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Balance Transfer Name</strong>
                                                <br>
                                                <p class="text-muted">@{{balanceTransfer.name}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Group</strong>
                                                <br>
                                                <p class="text-muted">@{{balanceTransfer.group}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Sub Group</strong>
                                                <br>
                                                <p class="text-muted">@{{balanceTransfer.sub_group}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong>Active</strong>
                                                <br>
                                                <h3 >
                                                    <span class="badge badge-success" v-if="balanceTransfer.is_active == 1">Active
                                                    </span>
                                                    <span class="badge badge-danger" v-else>Inactive
                                                    </span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



    <div class="modal fade" id="balanceTransferModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Balance Transfer</h5>
                        
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
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></button>
                                    <select class="form-control form-white" placeholder="Sub Group" v-model="balanceTransfer.from_account_id">
                                        <option v-for="account in transactionAccounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></i></button>

                                    <select class="form-control form-white" placeholder="Sub Group" v-model="balanceTransfer.to_account_id">
                                        <option v-for="account in transactionAccounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="number" min="1" class="form-control" placeholder="amount" v-model="balanceTransfer.amount">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="note" v-model="balanceTransfer.note">
                                </div>
                                <b v-if="balanceTransfer.id">Note: You can update only note.</b>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!balanceTransfer.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="balanceTransfer.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="creatAccountemodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Balance Transfer</h5>
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
                                    <input type="text" class="form-control" placeholder="username" v-model="account.name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></button>
                                    <select class="form-control form-white" placeholder="Sub Group" v-model="account.group">
                                        <option value="Asset">Asset</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-down"></i></i></button>

                                    <select class="form-control form-white" placeholder="Sub Group" v-model="account.sub_group">
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" placeholder="Choose status" v-model="account.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearAccountData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveAccountData()" v-if="!account.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveAccountData()" v-if="account.id"><i class="ti-save"></i> Update</button>
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
            el: '#balanceTransfers',
            data: {
                errors: [],                
                account: {
                    id: '',
                    name: '',
                    group: 'Asset',
                    sub_group: 'Cash',
                    is_active: 1,
                },
                balanceTransfer: {
                    id: '',
                    from_account_id: '',
                    to_account_id: '',
                    amount: '',
                    note: '',
                },
                currentIndex: 0,
                balanceTransfers: [],
                successMessage: '',
                groups: JSON.parse('{!!$accountGroups!!}'),
                subGroups: JSON.parse('{!!$accountSubGroups!!}'),
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("balanceTransfers.all") }}')
                    .then(function (response) {
                        _this.balanceTransfers = response.data.balanceTransfers;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.balanceTransfer = _this.balanceTransfers[index];
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.balanceTransfer = {
                        id: '',
                        from_account_id: '',
                        to_account_id: '',
                        amount: '',
                        note: '',
                    };
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            balanceTransfer: _this.balanceTransfer
                        }
                        axios.post('{{ route("balanceTransfers.addOrUpdate") }}', data)
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
                                    _this.balanceTransfers.push(data.balanceTransfer);
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
                                      title: 'Balance Transfer created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    _this.balanceTransfers[_this.currentIndex] = data.balanceTransfer;
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
                                      title: 'Balance Transfer updated successfully'
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
                clearAccountData() {
                    var _this = this;
                    _this.errors = [];
                    _this.account = {
                        id: '',
                        name: '',
                        group: '',
                        sub_group: '',
                        is_active: 1,
                    };
                },
                saveAccountData() {
                    var _this = this;
                    if(_this.validateAccount()){
                        //save data
                        let data = {
                            account: _this.account
                        }
                        axios.post('{{ route("accounts.addOrUpdate") }}', data)
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
                                    if (data.account.is_active == 1) {
                                        _this.transactionAccounts.push(data.account);
                                    }
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
                                      title: 'Account created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    if (data.account.is_active == 1) {
                                        _this.transactionAccounts[_this.currentIndex] = data.account;
                                    }
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
                                      title: 'Account updated successfully'
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
                    let balanceTransfer = _this.balanceTransfer;
                    let count = 0; 

                    if (balanceTransfer.from_account_id == balanceTransfer.to_account_id) {
                        _this.errors.push("You cannot transfer same account.");
                        count++;
                    }
                    if (balanceTransfer.amount <=0 ) {
                        _this.errors.push("Amount must be greater than 0.");
                        count++;
                    }

                    if(count==0) return true;
                    else return false;
                },

                validateAccount() {           
                    var _this = this; 
                    _this.errors = [];
                    let account = _this.account;
                    let count = 0; 

                    if (!account.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!account.group) {
                        _this.errors.push("Group required.");
                        count++;
                    }
                    if (!account.sub_group) {
                        _this.errors.push("Sub group required.");
                        count++;
                    }
                    if (!account.is_active) {
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