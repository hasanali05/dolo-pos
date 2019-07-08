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
<div class="row" id="ledgers">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4" >
                    <h4 class="card-title" style="text-align: center;">Ledger List</h4>

                </div>
                <h1 v-if="successMessage" class="text-center alert alert-success">@{{successMessage}}</h1>
                <table data-toggle="table" data-mobile-responsive="true"
                class="table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead style="text-align: center;">
                    <tr>
                        <th>S/L</th>
                        <th>Account Name</th>
                        <th>Entry Date</th>
                        <th>Type</th>
                        <th>Detail</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>balance</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Account Name</th>
                        <th>Entry Date</th>
                        <th>Type</th>
                        <th>Detail</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>balance</th>
   
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody style="text-align: center;">
                    <tr v-for="(ledger, index) in ledgers">
                        <td>@{{index+1}}</td>
                        <td>@{{ledger.account?ledger.account.name:"Empty"}}</td>
                        <td>@{{ledger.entry_date}}</td>
                        <td>@{{ledger.type}}</td>
                        <td>@{{ledger.detail}}</td>
                        <td>@{{ledger.debit}}</td>
                        <td>@{{ledger.credit}}</td>
                        <td>@{{ledger.balance}}</td>

                        <td>     
                            <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#ledgerDetail" @click="setData(index)">
                                <span class="icon text-white" >
                                    <i class="fas fa-eye"></i>
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
    
        <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ledgerShow" aria-modal="true" id="ledgerDetail">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ledgerShow">Ledger Detail</h5>
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
                                                <p class="text-muted" >@{{ledger.account?ledger.account.name:'none'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"><strong>Date</strong>
                                                <br>
                                                <p class="text-muted">@{{ledger?ledger.entry_date:'none'}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Ledger Type</strong>
                                                <br>
                                                <p class="text-muted">@{{ledger.type}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"><strong>Debit</strong>
                                                <br>
                                                <p class="text-muted">@{{ledger.debit}}</p>
                                            </div>
                                          <div class="col-md-3 col-xs-6 b-r"><strong>Credit</strong>
                                                <br>
                                                <p class="text-muted">@{{ledger.credit}}</p>
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



    <div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          
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
            el: '#ledgers',
            data: {
                errors: [],
                ledger: {
                    id: '',
                    account_id: '',
                    entry_date: '',
                    type: '',
                    detail: '',
                    debit: '',
                    credit: '',
                    balance: '',
                    is_active: 1,
                     created_by: '',
                    account: {
                        name:'',
                        group:'',
                        sub_group:'',
                        is_active: 1,
                        created_by: '',
                     }
                },
                currentIndex: 0,
                ledgers: [],
                successMessage: '',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("ledgers.all") }}')
                    .then(function (response) {
                        _this.ledgers = response.data.ledgers;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.ledger = _this.ledgers[index];
                },

                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.ledger = {
                        id: '',
                        name: '',
                        group: '',
                        sub_group: '',
                        is_active: 1,
                    };
                },
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            ledger: _this.ledger
                        }
                        axios.post('{{ route("ledgers.addOrUpdate") }}', data)
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
                                    _this.ledgers.push(data.ledger);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Account created successfully.';
                                }
                                if(status=='updated') {
                                    _this.ledgers[currentIndex] = data.ledger;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Account updated successfully.';
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
                    let ledger = _this.ledger;
                    let count = 0; 

                    if (!ledger.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!account.group) {
                        _this.errors.push("Group required.");
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