@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->

    <link rel="stylesheet" type="text/css" href="{{asset('/')}}/template/assets/libs/select2/dist/css/select2.min.css">
@endsection

@section('page-title')
Candidates
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="interviews">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="alert alert-success text-center" v-if="successMessage" v-text="successMessage"></h4>
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">interviews List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New interview
                            </button>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>S/L</th>
                            <th>Candidate Name</th>
                            <th>Date</th>
                            <th>Test Task</th>
                            <th>Output</th>
                            <th>Mark</th>
                            <th>Creator</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>S/L</th>
                            <th>Candidate Name</th>
                            <th>Date</th>
                            <th>Test Task</th>
                            <th>Output</th>
                            <th>Mark</th>
                            <th>Creator</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr v-for="(interview, index) in interviews" :key="index">
                            <td>@{{index+1}}</td>
                            <td>@{{interview.candidate.name}}</td>
                            <td>@{{interview.date}}</td>
                            <td>@{{interview.test_task}}</td>
                            <td>@{{interview.output}}</td>
                            <td>@{{interview.mark}}</td>
                            <td>@{{interview.creator?interview.creator.name:'Added directly on database'}} <small><br>(@{{interview.created_at}})</small> </td>
                            <td style="min-width: 100px;">     
                                <button class="btn btn-info btn-icon-split"  data-toggle="modal" data-target="#interviewDetail" @click="setData(index)">
                                    <span class="icon text-white" >
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

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="interviewDetailLabel" aria-modal="true" id="interviewDetail">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="interviewDetailLabel">Candidate detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" v-if="interview">
                    <div class="row">
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Name</strong>
                            <br>
                            <p class="text-muted" v-if="interview.candidate">@{{interview.candidate.name}}</p>
                        </div>
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Date</strong>
                            <br>
                            <p class="text-muted">@{{interview.date}}</p>
                        </div> 
                        <div class="col-md-12 col-xs-6 b-r"> <strong>Test task</strong>
                            <br>
                            <p class="text-muted">@{{interview.test_task}}</p>
                        </div>    
                        <div class="col-md-12 col-xs-6 b-r"> <strong>Output</strong>
                            <br>
                            <p class="text-muted">@{{interview.output}}</p>
                        </div>   
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Mark </strong>
                            <br>
                            <p class="text-muted">@{{interview.mark}} 
                                <br>
                                <span class="badge badge-secondary badge-info">(out of 10)</span>
                            </p>
                        </div>    
                        <div class="col-md-6 col-xs-6 b-r"> <strong>Creator</strong>
                            <br>
                             <p class="text-muted">@{{interview.creator?interview.creator.name:'Added directly on database'}} <small><br>(@{{interview.created_at}})</small>
                        </div>       
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                            <div class="col-8">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <div class="form-control" style="padding: 3px">
                                        <select class="select2 form-control custom-select select2-hidden-accessible" style="width: 100%; height:36px;">
                                            <option value="">----Select----</option>
                                            <option  v-for="(candidate, index) in candidates" :key="index" :value="candidate.id">@{{candidate.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-calendar text-white"></i></button>
                                    <input type="date" class="form-control" placeholder="Interview date" v-model="interview.date">
                                </div>
                            </div>
                            <div class="col-12">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-list text-white"></i></button>
                                    <textarea  class="form-control" placeholder="Interview Task" v-model="interview.test_task"></textarea>
                                </div>
                            </div>
                            <div class="col-9">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-list text-white"></i></button>
                                    <textarea  class="form-control" placeholder="The output from interview task" v-model="interview.output"></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-cup text-white"></i></button>
                                    <input type="number" class="form-control" placeholder="Marks (out of 10)" v-model="interview.mark" min="0" max="10">
                                </div>
                            </div>   
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!interview.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="interview.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('custom-js')

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/template/assets/libs/select2/dist/js/select2.min.js"></script>

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">
        const app = new Vue({
            el: '#interviews',
            data: {
                errors: [],
                successMessage: '',
                interview: {
                    id: '',
                    date: '',
                    test_task: '',
                    output: '',
                    mark: '',
                    candidate: {
                        id: '',
                    },
                },  
                currentIndex: 0,
                interviews: [],
                candidates: [],
                candidateList: '',
            },
            mounted: function mounted() {
                var _this = this;   
                _this.getAllData();
                _this.candidateList = $(".select2").select2();
                _this.candidateList.on("change", function (e) {
                    _this.interview.candidate.id = e.target.value;
                });
            },
            methods: {
                splitJoin(theText){
                    return theText.split(', ');
                },
                getAllData: function getAllData() {                     
                    var _this = this;       
                    axios.get('{{ route("interviews.all") }}')
                    .then(function (response) {
                        _this.interviews = response.data.interviews;
                    })

                    axios.get('{{ route("candidates.all") }}')
                    .then(function (response) {
                        _this.candidates = response.data.candidates;
                    })
                },
                setData: function setData(index) {                
                    var _this = this;  
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.interview = _this.interviews[index];
                    _this.candidateList.val(_this.interviews[index].candidate.id);
                    _this.candidateList.trigger('change');
                },
                clearData: function clearData() {           
                    var _this = this; 
                    _this.errors = [];
                    _this.interview = {
                        id: '',
                        date: '',
                        test_task: '',
                        output: '',
                        mark: '',
                        candidate: {
                            id: '',
                        },
                    };
                    _this.successMessage = '';
                },
                saveData: function saveData() {           
                    var _this = this; 
                    if(_this.validate()){
                        //save data      
                        let data = {
                            interview: _this.interview
                        }                  
                        axios.post('{{ route("interviews.addOrUpdate") }}', data)
                        .then(function (response) {
                            let data = response.data;
                            if(data.success == true) {
                                //modal close
                                if (data.status=='somethingwrong') {                                    
                                    // _this.errors.push("Something wrong. Try again.");
                                    alert("something Wrong. Try Again.")
                                }
                                if(data.status=='created') {                                                  
                                    _this.interviews.push(data.interview);
                                    _this.successMessage = 'Interview information successfully created.';
                                    //modal close      
                                    document.getElementById('modalClose').click();         
                                }
                                if(data.status=='updated') {
                                    _this.$set(_this.interviews , _this.currentIndex , data.interview);
                                    console.log(data.interview); 
                                    console.log(_this.interviews[_this.currentIndex]); 
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
                    let interview = _this.interview;
                    let count = 0; 
                    if (!interview.candidate.id) {
                        _this.errors.push("You have to must select a candidate.");
                        count++;
                    }
                    if (!interview.date) {
                        _this.errors.push('You have to must add a interview date.');
                        count++;
                    }
                    if (!interview.test_task) {
                        _this.errors.push("Test task is required.");
                        count++;
                    } 
                    if (interview.mark) {
                        if (interview.mark<0  || interview.mark>10) {
                            _this.errors.push("Mark must be between 0 to 10.");
                            count++;
                        }
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