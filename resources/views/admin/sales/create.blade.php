@extends('layouts.admin')

@section('custom-css')
    <link href="{{asset('/')}}template/assets/libs/bootstrap-table/dist/bootstrap-table.min.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
       html body .p-10 {
            padding: 10px;
        }
          html body .m-b-0 {
            margin-bottom: 0;
        }
          html body .p-t-10 {
            padding-top: 10px;
        }
          html body .p-b-10 {
            padding-bottom: 10px;
        }
    .card-border-radius{
        border:1px solid #c7c7c7;
        border-radius: 20px;
    }
    .table td, .table th {
        padding: 2px 5px ;
    }


        .table-bordered th,
        .table-bordered td {
          border: 1px solid #dee2e6;
        }

        table tr:nth-child(2n) td {
          background: #F5F5F5;
        }
        .sales table {
            margin-top: 30px;
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
        }
        .sales table th{
          height: 25px;
          color: #1b0000;
          font-size: 16px;
          font-weight: bold;
        }
        .sales table td{
          border: 1px solid #dee2e6;
          height: 25px;
          text-align: center;
        }

        .products table {
            margin-top: 30px;
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 16px;
        }
        .products table th{
          border: 1px solid #dee2e6;
          height: 25px;
          color: #1b0000;
          font-weight: bold;
        }
        .products table td{
          border: 1px solid #dee2e6;
          height: 25px;
          text-align: left;
          padding: 2px 5px;
        }
        .products table td:nth-child(6){
          text-align: right;
        }
        .products table td input{
          text-align: right;
        }

        .products th.item,
        .products th.model{
            width: 25%
        }
        .products th.s-n{
            width: 15%
        }
        .products th.total,
        .products th.unit{
            width: 10%
        }
        .products th.qty{
            width: 10%
        }
        .products th.sn{
            width: 5%
        }
        .products th.action{
            width: 5%
        }
        .products table  .summery td{
          height: 25px;
          text-align: right;
          border:none;
        }
        .products table  .summery td:last-child{
          height: 25px;
          text-align: right;
          border:1px solid #dee2e6;
        }
        .products table  .summery td:first-child{
            background: #fff;
        }
</style>

    <!-- Custom CSS -->
@endsection

@section('page-title')
Home page
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
@endsection

@section('content')
<div class="row" id="sale">
    <div class="col-md-9">
        <div class="card border-danger">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">Invoice</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="alert alert-success alert-dismissible fade show w-100" role="alert" v-if="successMessage">
                    <strong>Successfull!</strong> @{{successMessage}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click.prevent="successMessage=''">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="col-md-6">                  
                  Products:
                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;" @change="addTosale($event)">
                        <option value="-1"><--- Select Product ---></option>
                        <option v-for="(product,index) in products" :value="index" :key="index">@{{ product.name }}</option>
                    </select>
                </div>
              </div>
              <div class="row">
                <div class="table-responsive products">

                        <table id="invoiceTable" class="table table-bordered table-striped"  name="invoiceTable">
                            <thead>
                              <tr>
                                  <th class="sn">#</th>
                                  <th class="model">Product name</th>
                                  <th class="s-n">unique code</th>
                                  <th class="s-n">Warrenty<br><span class="text-info" style="font-size: 12px;">(Default : 0 days)</span></th>
                                  <th class="unit">Buy Price (BDT)</th>
                                  <th class="total">Sell Price (BDT)</th>
                                  <th class="action">Action</th>
                              </tr>

                            </thead>
                            <tbody id="tbody">
                                <tr v-for="(detail, index) in saleDetails" :key="index">
                                  <td class="sn">@{{index+1}}</td>
                                  <td class="model">@{{detail.name}}</td>
                                  <td class="s-n"><input type="text" style="width:100%" v-model="detail.unique_code"></td>
                                  <td class="unit">
                                    <input type="number" min="0" style="width:48%" v-model="detail.warranty_duration">
                                    <select style="width:48%; height: 100%;" v-model="detail.warranty_type">
                                      <option value="days">days</option>
                                      <option value="months">months</option>
                                      <option value="years">years</option>
                                    </select>
                                  </td>
                                  <td class="unit"><input type="number" min="1" style="width:100%" v-model="detail.buying_price"></td>
                                  <td class="total"><input type="number" min="1" style="width:100%" v-model="detail.selling_price"></td>
                                  <td class="action">
                                    <a data-toggle="tooltip" data-original-title="Remove" @click.prevent="removeRow(index)">
                                      <i class="fa fa-trash text-danger m-r-10"></i> 
                                    </a>
                                  </td>
                              </tr>
                            </tbody>
                            <tfoot>       
                              <tr class="summery">
                                  <td colspan="5">Total</td>
                                  <td colspan="2">@{{computedTotal}}</td>
                              </tr>        
                              <tr class="summery">
                                  <td colspan="5" style="font-weight: bold">Convayance</td>
                                  <td colspan="2"><input type="number" min="0" style="width:100%" v-model="convayance"></td>
                              </tr>  
                              <tr class="summery">
                                  <td colspan="5" style="font-weight: bold">Grand Total</td>
                                  <td colspan="2">@{{computedGrandTotal}}</td>
                              </tr>
                              <tr class="summery text-info">
                                  <td colspan="5" style="font-weight: bold">Paid</td>
                                  <td colspan="2">@{{computedPaid}}</td>
                              </tr>
                              <tr class="summery text-danger">
                                  <td colspan="5" style="font-weight: bold">Due</td>
                                  <td colspan="2">@{{computedDue}}</td>
                              </tr>
                              </tfoot>
                        </table>
                        <br>
                        <br>
                         <button type="submit" class="btn btn-info waves-effect pull-right m-r-10" name="invoice" value="active" @click.prevent="saveData()">sale</button>
                </div>


                <div v-if="errors.length" class="alert alert-danger w-100" style="margin-top: 10px;">
                    <b>Please correct the following error(s):</b>
                    <ul>
                        <li v-for="error in errors">@{{ error }}</li>
                    </ul>
                </div>
             </div> 
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">customer & Payments</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="bg-danger w-100 p-10">
                      <h6 class="m-b-0 text-white">customer Info</h6>
                    </div>
                    <div class="col-sm-12">

                        <label>Select customer</label>
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" @change="changecustomer($event)">
                            <option value="-1">Not registered customer</option>
                            <optgroup>
                                <option v-for="(customer,index) in customers" :value="index" :key="index">@{{ customer.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10" >        
                        <label style="font-weight: 500">customer information</label>
                        <div>
                          
                          <template v-if="selectedcustomer"> 
                            <p>Name: @{{selectedcustomer.name}}</p>
                            <p>Contact: @{{selectedcustomer.contact}}</p>
                            <p>Address: @{{selectedcustomer.address}}</p>
                          </template>
                          <p v-else class="text-alert">customer not selected</p>
                        </div>
                    </div>
                    <div class="bg-danger w-100 p-10">
                      <h6 class="m-b-0 text-white">Payment Info</h6>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>Payment From</label>
                      <select class="select2 form-control custom-select" style="width: 100%; height:36px;"  @change="changeAccount($event)">
                          <option v-for="(account, index) in transactionAccounts" :value="index">@{{account.name}}</option>
                      </select>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>sale Date</label>
                      <input class="form-control" type="date" value="2011-08-19" v-model="sale_date">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Payment amount</label>
                         <input type="number" v-model="payment_amount" min="0" class="form-control">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Transaction Note</label>
                         <textarea class="form-control" rows="3" v-model="payment_note" placeholder="Write some note if any..."></textarea>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10" >        
                        <label style="font-weight: 500">Account information</label>
                        <div>                          
                          <template v-if="selectedAccount"> 
                            <p>Name: @{{selectedAccount.name}}</p>
                            <p>Group: @{{selectedAccount.group}}</p>
                            <p>Sub Group: @{{selectedAccount.sub_group}}</p>
                          </template>
                          <p v-else class="text-alert">Account not selected</p>
                        </div>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                        <button type="submit" class="btn waves-effect waves-light btn-block btn-info" name="invoice" value="active" @click.prevent="saveData()">sale</button>
                    </div>
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
            el: '#sale',
            data: {
                errors: [],
                successMessage:'',

                customers: [],
                products: [],
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),

                selectedcustomer: '',
                selectedAccount: '',
                saleDetails: [],

                total: '',
                convayance: '',
                grandTotal: '',
                sale_date: '',
                payment_amount: 0,
                payment_note: '',
            },
            computed: {
              computedTotal () {
                let total = 0;
                this.saleDetails.forEach(function (detail) {
                  if (detail.buying_price) {
                    total+=Number(detail.buying_price);
                  }
                })
                this.total = total;
                return this.total;
              },
              computedGrandTotal () {
                if(Number(this.convayance) > this.grandTotal) this.convayance = this.grandTotal;
                if(Number(this.convayance) < 0) this.convayance = 0;
                this.grandTotal = this.total-Number(this.convayance);
                return this.grandTotal;
              },
              computedPaid () {
                if(this.payment_amount > this.grandTotal) this.payment_amount = this.grandTotal;
                if(this.payment_amount < 0) this.payment_amount = 0;
                return this.payment_amount;
              },
              computedDue () {
                return this.grandTotal-this.payment_amount;
              }
            },
            mounted() {
                var _this = this;
                _this.getAllcustomer();
                _this.getAllProduct();
            },
            methods: {
                getAllcustomer() {
                    var _this = this;
                    axios.get('{{ route("customers.all") }}')
                    .then(function (response) {
                        _this.customers = response.data.customers;
                    })
                },
                getAllProduct() {
                    var _this = this;
                    axios.get('{{ route("products.all") }}')
                    .then(function (response) {
                        _this.products = response.data.products;
                    })
                },
                changecustomer(event) 
                { 
                    var _this = this;
                    if(event.target.value<0)
                      _this.selectedcustomer = '';
                    else 
                      _this.selectedcustomer = _this.customers[event.target.value];
                },
                changeAccount(event) 
                { 
                    var _this = this;
                    if(event.target.value<0)
                      _this.selectedAccount = '';
                    else 
                      _this.selectedAccount = _this.transactionAccounts[event.target.value];
                },
                addTosale(event) 
                { 
                    var _this = this;
                    if(event.target.value>=0) 
                      _this.saleDetails.push(_this.products[event.target.value]);
                },
                removeRow(index) 
                {   
                  this.saleDetails.splice(index, 1);
                },           
                clearData() {
                    var _this = this;

                    _this.errors= [];
                    _this.successMessage='';

                    _this.customers= [];
                    _this.products= [];
                    _this.transactionAccounts= JSON.parse('{!!$transactionAccounts!!}');

                    _this.selectedcustomer= '';
                    _this.selectedAccount= '';
                    _this.saleDetails= [];

                    _this.total= '';
                    _this.convayance= '';
                    _this.grandTotal= '';
                    _this.sale_date= '';
                    _this.payment_amount= 0;
                    _this.payment_note= '';
                },
                saveData() {
                    var _this = this;
                    _this.errors = [];
                    if(1){
                    // if(_this.validate()){
                        //save data
                        let data = {
                            customer: _this.selectedcustomer,
                            account: _this.selectedAccount,
                            detail: _this.saleDetails,

                            sale: {
                              convayance: _this.convayance,
                              sale_date: _this.sale_date,
                              payment: _this.payment_amount,
                              note: _this.payment_note,
                            }
                        }
                        axios.post('{{ route("sales.addOrUpdate") }}', data)
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
                                    _this.clearData();
                                    //modal close
                                  
                                      //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'sale created successfully'
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
                    let sale = _this.sale;
                    let count = 0; 
                    if (!_this.selectedcustomer) {
                        _this.errors.push("You must have to select a customer first.");
                        count++;
                    }
                    if (_this.saleDetails.length < 1) {
                        _this.errors.push("You must have to select some product.");
                        count++;
                    }
                    _this.saleDetails.forEach(function (detail) {
                      if(!detail.buying_price) {
                          _this.errors.push("Add buying prices to all product.");
                          count++;
                      }
                      if(!detail.unique_code) {
                          _this.errors.push("Add buying prices to all product.");
                          count++;
                      }
                    })
                    if (!_this.selectedAccount) {
                        _this.errors.push("You must have to select an account.");
                        count++;
                    }
                    if (!_this.sale_date) {
                        _this.errors.push("Select a sale date.");
                        count++;
                    }
                     if (!_this.payment_amount) {
                        _this.errors.push("you must have to select payment amount.");
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