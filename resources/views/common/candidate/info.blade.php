@extends('layouts.common')

@section('custom-css')
    <link href="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
Candidates
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('employee.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="candidates">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="alert alert-success text-center" v-if="successMessage" v-text="successMessage"></h4>
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Candidates add</h4>
                </div>
                 <form action="javascript:void(0)" method="POST">
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
            },
            mounted: function mounted() {
                var _this = this;   
            },
            methods: {
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
                    };
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
                                    _this.successMessage = 'Candidate information successfully stored.';  
                                    _this.candidate =  {
                                        id: '',
                                        name: '',
                                        phone: '',
                                        email: '',
                                        expected_salary: '',
                                        expected_join_date: '',
                                        expertise: '',
                                    };
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