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
<div class="row" id="expense">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Expense List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Expense
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
                        <th>Account name</th>
                        <th>Title</th>
                        <th>Expense Date</th>
                        <th>Amount</th>
                        <th>Reason</th>
                        <th>type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                         <th>S/L</th>
                        <th>Account name</th>
                        <th>Title</th>
                        <th>Expense Date</th>
                        <th>Amount</th>
                        <th>Reason</th>
                        <th>type</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                <tbody>
                    <tr v-for="(expense, index) in expenses">
                        <td>@{{index+1}}</td>
                        <td>@{{expense.account?expense.account.name:''}}</td>
                        <td>@{{expense.title}}</td>
                        <td>@{{expense.expense_date}}</td>
                        <td>@{{expense.amount}}</td>
                        <td>@{{expense.reason}}</td>
                        <td>@{{expense.type}}</td>
                        

      


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
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Expense</h5>
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
                                    <select class="form-control form-white" v-model="expense.account_id">
                                        <option>select Account Name</option>
                                        <option v-for="account in accounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-keyboard"></i></button>
                                    <input type="text" class="form-control" placeholder="Title" v-model="expense.title" required="">
                                    <input type="hidden" class="form-control" v-model="expense.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-calendar-alt"></i></button>
                                    <input type="date" class="form-control" placeholder="Expense Date" v-model="expense.expense_date" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-keyboard"></i></button>
                                    <input type="text" class="form-control" placeholder="Amount" v-model="expense.amount" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-keyboard"></i></i></button>
                                    <input type="text" class="form-control" placeholder="Reason" v-model="expense.reason" required="">
                                    
                                </div>
                            </div>
                             <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="expense.type">
                                        <option value="unusual">unusual</option>
                                        <option value="regular">regular</option>
                                    </select>
                                </div>
                            </div>


                         
                        </div>
                        <!-- <div class="input-group mb-3">
                            <button type="button" class="btn btn-info"><i class="ti-import text-white"></i></button>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputGroupFile01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose Image</label>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!expense.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="expense.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Expense detail</h5>
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
                                            
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Account Name</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.account?expense.account.name:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Title</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.title}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Expense Date</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.expense_date}}</p>
                                            </div>
                                            
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Amount</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.amount}}</p>
                                            </div> 
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Reason</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.reason}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Type</strong>
                                                <br>
                                                <p class="text-muted">@{{expense.type}}</p>
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
            el: '#expense',
            data: {
                errors: [],
                expense: {
                    id: '',
                    account_id:'1',
                    title: '',
                    expense_date: '',
                    amount: '',
                    reason: '',
                    type: '1',
                    account: {
                        id:'',
                        name: ''
                    }
                },
                currentIndex: 0,
                expenses: [],               
                accounts: [],               
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
                    axios.get('{{ route("accounts.all") }}')
                    .then(function (response) {
                        _this.accounts = response.data.accounts;
                    })
                },

                getAllData(){
                      var _this = this;
                    axios.get('{{ route("expenses.all") }}')
                    .then(function (response) {
                        _this.expenses = response.data.expenses;
                    })

                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.expense = _this.expenses[index];
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.expense = {
                        id: '',
                        account_id: '1',
                        title:'',
                        expense_date: '',
                        amount: '',
                        reason: '',
                        type: '1',
                        account:{
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
                            expense: _this.expense
                        }
                        axios.post('{{ route("expenses.addOrUpdate") }}', data)
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
                                    _this.expenses.push(data.expense);
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
                                      title: 'Expense created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    
                                    _this.$set( _this.expenses, _this.currentIndex, data.expense )
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
                                      title: 'Expense updated  successfully'
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
                    let expense = _this.expense;
                    let count = 0; 

                    if (!expense.title) {
                        _this.errors.push("Title required.");
                        count++;
                    }
                     if (!expense.expense_date) {
                        _this.errors.push("Expense Date required.");
                        count++;
                    }
                    if (!expense.amount) {
                        _this.errors.push("Amount required.");
                        count++;
                    }
                    if (!expense.reason) {
                        _this.errors.push("Reason required.");
                        count++;
                    }
                    if (!expense.type) {
                        _this.errors.push("Type required.");
                        count++;
                    }

                     if (!expense.account_id) {
                        _this.errors.push("Account name required.");
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