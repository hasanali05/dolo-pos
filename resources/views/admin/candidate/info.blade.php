@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
Candidates
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="candidates">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="alert alert-success text-center" v-if="successMessage" v-text="successMessage"></h4>
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">candidates List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New candidate
                            </button>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Exp. salary</th>
                            <th>Exp. Join Date</th>
                            <th>Expertise</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S/L</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Exp. salary</th>
                            <th>Exp. Join Date</th>
                            <th>Expertise</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(candidate, index) in candidates">
                            <td>@{{index+1}}</td>
                            <td>@{{candidate.name}}</td>
                            <td>@{{candidate.phone}}</td>
                            <td>@{{candidate.email}}</td>
                            <td>@{{candidate.expected_salary}}</td>
                            <td>@{{candidate.expected_join_date}}</td>
                            <td>
                                <span class="badge badge-pill badge-info" v-for="expertise in splitJoin(candidate.expertise)" v-text="expertise" style="font-size: 14px;"></span>
                            </td>
                            <td>     
                                <button class="btn btn-info btn-icon-split" data-toggle="modal" data-target="#candidateDetail" @click="setData(index)">
                                    <span class="icon text-white">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                </button> 
                                <button class="btn btn-warning btn-icon-split"   data-toggle="modal" data-target="#createmodel" @click="setData(index)">
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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="candidateDetailLabel" aria-modal="true" id="candidateDetail">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="candidateDetailLabel">Candidate detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Name</strong>
                            <br>
                            <p class="text-muted">@{{candidate.name}}</p>
                        </div>
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Phone</strong>
                            <br>
                            <p class="text-muted">@{{candidate.phone}}</p>
                        </div> 
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Email</strong>
                            <br>
                            <p class="text-muted">@{{candidate.email}}</p>
                        </div>    
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Expected Salary</strong>
                            <br>
                            <p class="text-muted">@{{candidate.expected_salary}}</p>
                        </div>   
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Expected Join Date</strong>
                            <br>
                            <p class="text-muted">@{{candidate.expected_join_date}}</p>
                        </div>    
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Expretises</strong>
                            <br>
                                <span class="badge badge-pill badge-info" v-for="expertise in splitJoin(candidate.expertise)" v-text="expertise" style="font-size: 14px;"></span>
                        </div>       
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
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Candidate</h5>
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
                                    <input type="text" class="form-control" placeholder="Name" v-model="candidate.name">
                                </div>
                            </div>
                            <div class="col-6">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-mobile text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Phone no" v-model="candidate.phone">
                                </div>
                            </div>
                            <div class="col-6">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-email text-white"></i></button>
                                    <input type="email" class="form-control" placeholder="Email address" v-model="candidate.email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-credit-card text-white"></i></button>
                                    <input type="number" class="form-control" placeholder="Expected salary" v-model="candidate.expected_salary">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-calendar text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Expected Join Date" v-model="candidate.expected_join_date">
                                </div>
                            </div>
                            <div class="col-6">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Expertises (separate by comma)" v-model="candidate.expertise">
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!candidate.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="candidate.id"><i class="ti-save"></i> Update</button>
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
            el: '#candidates',
            data: {
                errors: [],
                successMessage: '',
                candidate: {
                    id: '',
                    name: '',
                    phone: '',
                    email: '',
                    expected_salary: '',
                    expected_join_date: '',
                    expertise: '',
                },
                currentIndex: 0,
                candidates: []
            },
            mounted: function mounted() {
                var _this = this;   
                _this.getAllData();
            },
            methods: {
                splitJoin(theText){
                    return theText.split(', ');
                },
                getAllData: function getAllData() {                     
                    var _this = this;       
                    axios.get('{{ route("candidates.all") }}')
                    .then(function (response) {
                        _this.candidates = response.data.candidates;
                    })
                },
                setData: function setData(index) {                
                    var _this = this;  
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.candidate = _this.candidates[index];
                },
                clearData: function clearData() {           
                    var _this = this; 
                    _this.errors = [];
                    _this.candidate =  {
                        id: '',
                        name: '',
                        phone: '',
                        email: '',
                        expected_salary: '',
                        expected_join_date: '',
                        expertise: '',
                    },
                    _this.successMessage = ''
                },
                saveData: function saveData() {           
                    var _this = this; 
                    if(_this.validate()){
                        //save data      
                        let data = {
                            candidate: _this.candidate
                        }                  
                        axios.post('{{ route("candidates.addOrUpdate") }}', data)
                        .then(function (response) {
                            let data = response.data;
                            if(data.success == true) {
                                //modal close
                                if (data.status=='somethingwrong') {                                    
                                    // _this.errors.push("Something wrong. Try again.");
                                    alert("something Wrong. Try Again.")
                                }
                                if(data.status=='created') {                                                  
                                    _this.candidates.push(data.candidate);
                                    _this.successMessage = 'Candidate information successfully created.';
                                    //modal close      
                                    document.getElementById('modalClose').click();         
                                }
                                if(data.status=='updated') {
                                    _this.$set(_this.candidates , _this.currentIndex , data.candidate); 
                                    _this.successMessage = 'Candidate information successfully updated.';
                                    //modal close
                                    document.getElementById('modalClose').click();
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
                validate: function validate() {           
                    var _this = this; 
                    _this.errors = [];
                    _this.successMessage = '';
                    let candidate = _this.candidate;
                    let count = 0; 

                    if (!candidate.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                    if (!candidate.phone) {
                        _this.errors.push("Phone number required.");
                        count++;
                    }
                    if (!candidate.email) {
                        _this.errors.push('Email required.');
                        count++;
                    } else if (!this.validEmail(candidate.email)) {
                        _this.errors.push('Valid email required.');
                        count++;
                    }
                    if (!candidate.expected_salary) {
                        _this.errors.push("Expected Salary required.");
                        count++;
                    }
                    if (!candidate.expected_join_date) {
                        _this.errors.push('Expected Join Date required.');
                        count++;
                    } 
                    if (!candidate.expertise) {
                        _this.errors.push('Expertises required.');
                        count++;
                    } 
                    if(count==0) return true;
                    else return false;
                },
                validEmail: function (email) {
                    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                },
                wait: function wait(ms){
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