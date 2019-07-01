@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
@endsection

@section('page-title')
    Slider page
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
    <div class="row" id="sliders">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center mb-4">
                        <h4 class="card-title">Slider Image List</h4>
                        <div class="ml-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createmodel"  >
                                    Add New Slide
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-------------  Slideer Image Table ------------}}

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
                            <th>Header Text</th>
                            <th>Sub Header Text</th>
                            <th>Slider Image</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>S/L</th>
                            <th>Header Text</th>
                            <th>Sub Header Text</th>
                            <th>Slider Image</th>
                            <th>Action</th>

                        </tr>
                        </tfoot>
                        <tbody>
                        <tr >

                            <td> 1</td>
                            <td>Slider 1</td>
                            <td>Slider 1</td>
                            <td>Slider 1 </td>

                            <td>

                                <button class="btn btn-warning btn-icon-split"   data-toggle="modal" data-target="#createmodel">
                                <span class="icon text-white"  @click.prevent="setData(index)">
                                    <i class="fas fa-pencil-alt"></i>
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




        {{--Slider Imagte Add Modal--}}


<div class="modal fade" id="createmodel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('/admin/slider/add') }}" method="POST" enctype="multipart/form-data" >
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

                        <div class="col-6">
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                <input type="text" class="form-control" placeholder="Header Text" name="header_text" v-model="slider.header_text">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <button type="button" class="btn btn-info"><i class="ti-star text-white"></i></button>
                                <input type="text" class="form-control" placeholder="Sub Header Text" name="sub_head_text"  v-model="slider.sub_head_text">
                            </div>
                        </div>





                        <div class="col-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="slider_image" id="slider_image" >
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                    <button type="submit" class="btn btn-info" @click.prevent="clearData()"><i class="ti-close"></i> Clear data</button>
                   
                    <button type="submit" class="btn btn-primary" @click.prevent="submitFile()"><i class="ti-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

        {{-----------------  End Slider Image Add Section--}}


</div>



@endsection

@section('custom-js')

    <!-- <script src="{{asset('/')}}/template/assets/libs/bootstrap-table/dist/bootstrap-table.min.js"></script> -->

    <script src="{{asset('/')}}/js/vue.js"></script>
    <script src="{{asset('/')}}/js/axios.min.js"></script>
    <script type="text/javascript">

        const app = new Vue({
           el:'#sliders',
           data:{
            errors: [],
            slider:{
                id:'',
                header_text:'',
                sub_head_text:'',
                slider_image:'',
            },
           },

            methods:{
                submitFile: function saveData(){
//                    alert("Data Save")

                    axios.post('/admin/slider/add', {
                        header_text:'',
                        sub_head_text:'',
                        slider_image:'',
                    })
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                 },


                handleFileUpload: function handleFileUpload(){
                    this.file = this.$refs.file.files[0];
                },


                clearData: function clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.slider = {
                        id: '',
                        header_text:'',
                        sub_head_text:'',
                        slider_image:'',


                    }
                },



            }
        });

    </script>
@endsection