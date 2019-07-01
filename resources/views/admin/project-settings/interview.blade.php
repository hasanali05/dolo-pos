@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
Home page
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="projectSettings">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Project Setting List</h4>
                    <div class="ml-auto">
                        <div class="btn-group">
                            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  @click.prevent="clearData()">
                            Create New Setting
                            </button>
                        </div>
                    </div>
                </div>
                <table data-toggle="table" data-mobile-responsive="true"
                class="table-striped">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>

            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Meta Key</th>
                        <th>Meta Value</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Meta Key</th>
                        <th>Meta Value</th>
                        <th>Active/Not</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(setting, index) in settings">
                        <td>@{{index+1}}</td>
                        <td>@{{setting.key}}</td>                        
                        <td>@{{setting.value}}</td>                        
                        <td>
                            <span class="badge badge-success" v-if="setting.is_active == 1">Active</span>
                            <button class="btn btn-danger" v-if="setting.is_active == 1" @click.prevent="inactiveData(index)">In-activate-it</button> 

                            <span class="badge badge-danger" v-if="setting.is_active == 0">In-active</span>
                            <button class="btn btn-success" v-if="setting.is_active == 0" @click.prevent="activeData(index)">Active-it</button> 
                        </td>
                        <td>     
                            <button class="btn btn-warning btn-icon-split" data-toggle="modal" data-target="#createmodel" @click="setData(index)">
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

    <div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Project Setting</h5>
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
                            <div class="col-5">                                
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-key text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Key" v-model="setting.key">
                                    <input type="hidden" class="form-control"  v-model="setting.id">
                                </div>
                            </div>
                            <div class="col-5">                                        
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-link text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="Value" v-model="setting.value">
                                </div>
                            </div>                            
                            <div class="col-2">
                                <div class="input-group mb-3">
                                    <select class="form-control form-white" placeholder="Choose status" v-model="setting.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
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
                        <button type="submit" class="btn btn-success" @click.prevent="saveData()" v-if="!setting.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveData()" v-if="setting.id"><i class="ti-save"></i> Update</button>
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
            el: '#projectSettings',
            data: {
                errors: [],
                setting: {
                    id: '',
                    key: '',
                    value: '',
                    is_active: 1
                },
                settings: [],
                currentIndex: ''
            },
            mounted: function mounted() {
                var _this = this;   
                _this.getAllData();
            },
            methods: {
                getAllData: function getAllData() {                     
                    var _this = this;       
                    axios.get('{{ route("projectSettings.all") }}')
                    .then(function (response) {
                        _this.settings = response.data.settings;
                    })
                },
                setData: function setData(index) {                
                    var _this = this;  
                    _this.errors = [];
                    _this.setting = _this.settings[index];
                    _this.currentIndex = index;
                },
                inactiveData: function inactiveData(index) {
                    var _this = this; 
                    let data = {
                        data_id: _this.settings[index].id,
                        is_active: 0,
                    }
                    axios.post('{{ route("projectSettings.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.settings[index] , 'is_active' , 0); 
                        } 
                    }) 
                },
                activeData: function activeData(index) {           
                    var _this = this; 
                    let data = {
                        data_id: _this.settings[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("projectSettings.statusChange") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.settings[index] , 'is_active' , 1); 
                        } 
                    }) 
                },
                clearData: function clearData() {           
                    var _this = this; 
                    _this.errors = [];
                    _this.setting = {
                        id: '',
                        key: '',
                        value: '',
                        is_active: 1
                    },
                    _this.currentIndex= ''
                },
                saveData: function saveData() {        
                    var _this = this; 
                    if(_this.validate()){
                        //save data      
                        let data = {
                            setting: _this.setting
                        }                  
                        axios.post('{{ route("projectSettings.addOrUpdate") }}', data)
                        .then(function (response) {
                            let data = response.data;
                            if(data.success == true) {
                                //modal close
                                document.getElementById('modalClose').click();                 
                                if(data.status=='created') {                                                  
                                    _this.settings.push(data.setting);         
                                }
                                if(data.status=='updated') {
                                    _this.$set(_this.settings , _this.currentIndex , data.setting); 
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
                    let setting = _this.setting;
                    let count = 0; 
                    if (!setting.key) {
                        _this.errors.push("Key required.");
                        count++;
                    }
                    if (!setting.value) {
                        _this.errors.push("Value required.");
                        count++;
                    }
                    if(count==0) return true;
                    else return false;
                },
            }
        });

    </script>
@endsection