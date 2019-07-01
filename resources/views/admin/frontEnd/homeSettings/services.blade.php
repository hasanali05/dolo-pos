@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
    Service page
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
    <div class="row" id="services">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center mb-4">
                        <h4 class="card-title">Service List</h4>
                        <div class="ml-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark" @click="clearData(), showModal()" data-toggle="modal"  data-target="#createModal" >
                                    Add New Service
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-------------  Slider Image Table ------------}}

                    <table data-toggle="table" data-mobile-responsive="true"
                           class="table-striped">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr >
                            <th>S/L</th>
                            <th>Title</th>
                            <th>Description</th>

                            <th>Action</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr >
                            <th>S/L</th>
                            <th>Title</th>
                            <th>Description</th>

                            <th>Action</th>

                        </tr>
                        </tfoot>
                        <tbody>
                        <tr  v-for="(service, index) in services" >

                            <td> @{{index+1}}</td>
                            <td>@{{service.title}}</td>
                            <td>@{{service.description}}</td>


                            <td>

                                <button class="btn btn-warning btn-icon-split"   data-toggle="modal" data-target="#editModal"  @click.prevent="setData(index)">
                                <span class="icon text-white">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                                </button>

                                 <button class="btn btn-danger btn-icon-split"  @click.prevent="deleteData(service.id)"  >
                                <span class="icon text-white"  >
                                    <i class="fas fa-trash"></i>
                                </span>
                                    </button>
                            </td>


                        </tr>
                        </tbody>
                    </table>


                    {{---------- Slider table End -----------------}}

                </div>
            </div>
        </div>


        {{--Service Info Add Modal--}}


        <div class="modal fade" id="createModal" ref="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true"
      @hidden="resetModal"   @ok="handleSave"  >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="" method="POST" enctype="multipart/form-data" @submit.prevent="submitFile()" >
                        {{csrf_field()}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New Slider</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--
                            <div v-if="errors.length" class="alert alert-danger">
                                <b>Please correct the following error(s):</b>
                                <ul>
                                    <li v-for="error in errors">@{{ error }}</li>
                                </ul>
                            </div> -->
                            <div class="row">

                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                        <input type="text" class="form-control" placeholder="title" name="service_title" v-model="service.title">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                        <textarea name="description" id="description" cols="5" rows="5" class="form-control" v-model="service.description" placeholder="Description"></textarea>
                                    </div>
                                </div>





                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                            <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>

                            <button type="submit" class="btn btn-primary" @cick="hideModal()"  ><i class="ti-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-----------------  Service Info Add Section--}}



        {{------------------------  Service Info Edit  Modal ---------------------------------------}}


        <div class="modal fade" id="editModal" ref="editModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="" method="POST" enctype="multipart/form-data" @submit.prevent="updateFile()" >
                        {{csrf_field()}}
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Update Services</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!--
                            <div v-if="errors.length" class="alert alert-danger">
                                <b>Please correct the following error(s):</b>
                                <ul>
                                    <li v-for="error in errors">@{{ error }}</li>
                                </ul>
                            </div> -->
                            <div class="row">

                                <!-- <input type="text" class="form-control"  name="service_title"  id="service_id"  > -->

                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                        <input type="text" class="form-control" placeholder="title" name="service_title" v-model="service.title" id="service_title" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                        <textarea name="description" id="description" cols="5" rows="5" class="form-control" v-model="service.description" placeholder="Description"  ></textarea>
                                    </div>
                                </div>





                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                            <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>

                            <button type="submit" class="btn btn-primary" @click.prevent ="hideModal()"  ><i class="ti-save"></i> Update </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{---------------------------  Service Info Edit Section ----------------------------------}}













@endsection

@section('custom-js')

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">

        const app = new Vue({
            el:'#services',
            data:{
                errors: [],
                service:{
                    id:'',
                    title:'',
                    description:'',

                },

                currentIndex: 0,
                services: []
            },


            mounted: function mounted() {
                var _this = this;
                _this.getAllData();
            },

            methods:{

                getAllData: function getAllData() {
                    var _this = this;
                    axios.get('{{ route("admin.service-info") }}')
                        .then(function (response) {
                            _this.services = response.data.services;
                        })
                },

                submitFile: function submitFile() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            service: _this.service
                        }
                        axios.post('{{ route("admin.serviceAdd") }}', data)
                            .then(function (response) {
                                let data = response.data;
                                if(response.data.success == true) {
                                      
                                    if (status=='somethingwrong') {
                                        // _this.errors.push("Something wrong. Try again.");
                                        alert("something Wrong. Try Again.")
                                    }
                                    if(status=='created') {
                                        _this.services.push(data.service);
                                        //modal close
                                    }
                                    if(status=='updated') {
                                        _this.services[currentIndex] = data.service;
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
                    let service = _this.service;
                    let count = 0;

                    if (!service.title) {
                        _this.errors.push("Title required.");
                        count++;
                    }
                    if (!service.description) {
                        _this.errors.push("Services Description required.");
                        count++;
                    }


                    if(count==0) return true;
                    else return false;
                },
                clearData: function clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.service = {
                        id: '',
                        title:'',
                        description:'',
                    }
                },



                setData: function setData(index) {
                    var _this = this;
                    _this.clearData();
                    console.log(index);
                    _this.currentIndex = index;
                    _this.service = _this.services[index];
                },

                 deleteData: function deleteData(id){
                    var _this = this;
                    axios.post('{{ route('admin.deleteService-info') }}', {'id':id})
                        .then(function (response) {
                            let data = response.data;
                            if(response.data.success == true) {

                                swal('title','Service Deleted Successfully..!');
                                
                                _this.getVueItems();
                                _this.hasDeleted = false


                            } else {
                                for (var key in data.errors) {
                                    data.errors[key].forEach(function(element) {
                                        _this.errors.push(element);
                                    });
                                }
                            }
                        })

                },

                updateFile: function updateFile(){
                     var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            service: _this.service
                        }
                        axios.post('{{ route("admin.serviceUpdate") }}', data,{'id':id})
                            .then(function (response) {
                                let data = response.data;
                                if(response.data.success == true) {
                                    //modal close
                                    if (status=='somethingwrong') {
                                        // _this.errors.push("Something wrong. Try again.");
                                        alert("something Wrong. Try Again.")
                                    }
                                    if(status=='created') {
                                        _this.services.push(data.service);
                                        //modal close
                                    }
                                    if(status=='updated') {
                                        _this.services[currentIndex] = data.service;
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





            }
        });

    </script>
@endsection