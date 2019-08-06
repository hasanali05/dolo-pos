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
<div class="row" id="redeems">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center mb-4">
                    <h4 class="card-title">Bank transaction List</h4>
                </div>

                <div class="alert alert-success alert-dismissible fade show" role="alert" v-if="successMessage">
                    <strong>Successfull!</strong> @{{successMessage}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="successMessage=''">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

            <table class="table table-bordered table-striped" width="100%" cellspacing="0" data-toggle="table" data-mobile-responsive="true">
                <thead>
                    <tr>
                        <th>S/L</th>
                        <th>Supplier</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Redeem date</th>
                        <th>Ation</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>S/L</th>
                        <th>Supplier</th>
                        <th>Amount</th>
                        <th>Note</th>
                        <th>Redeem date</th>
                        <th>Ation</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(redeem, index) in redeems">
                        <td>@{{index+1}}</td>
                        <td>@{{redeem.supplier?redeem.supplier.name:''}}</td>
                        <td>@{{redeem.amount}}</td>
                        <td>@{{redeem.note}}</td>
                        <td>@{{redeem.redeem_date}}</td>
                        <td>
                            <button class="btn btn-danger" v-if="redeem.redeem_status == 'not-redeemed'" @click.prevent="redeemThis(index)">Redeemed</button> 
                        </td>
                    </tr>
                </tbody>
            </table>
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
            el: '#redeems',
            data: {
                errors: [],
                redeem: {
                    id: '',
                    amount: '',
                    note: '',
                    redeem_date: '',
                    redeem_status: '',
                    supplier: {
                        name: '',
                    }
                },
                currentIndex: 0,
                redeems: [],
                successMessage: ''
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("redeems.all") }}')
                    .then(function (response) {
                        _this.redeems = response.data.redeems;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.redeem = _this.redeems[index];
                },
                redeemThis(index) {
                    var _this = this;
                    let data = {
                        redeem_id: _this.redeems[index].id,
                        is_active: 1,
                    }
                    axios.post('{{ route("redeems.redeemed") }}',data)
                    .then(function (response) {
                        if(response.data.success == true) {
                            _this.$set(_this.redeems[index] , 'redeem_status' , 'redeemed');
                           
                             //sweet alrat
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                type: 'success',
                                title: 'The item redeemed successfully'
                            })
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            Toast.fire({
                                type: 'error',
                                title: 'You cannot change the status.'
                            })
                        }
                    })
                },
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.redeem = {
                        id: '',
                        amount: '',
                        note: '',
                        redeem_date: '',
                        redeem_status: '',
                        supplier: {
                            name: '',
                        }
                    }
                },
            }
        });

    </script>
@endsection