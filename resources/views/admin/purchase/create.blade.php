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
<div class="row" id="purchase">
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
                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;" @change="addToPurchase($event)">
                        <option value="-1"><--- Select Product ---></option>
                        <option v-for="(product,index) in products" :value="index" :key="index">@{{ product.name+" | "+ product.category?product.category.name:'' }}</option>
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
                                  <th class="s-n">unique code / <br> Quantity</th>
                                  <th class="s-n">Warrenty<br><span class="text-info" style="font-size: 12px;">(Default : 0 days)</span></th>
                                  <th class="unit">Buy Price (BDT)</th>
                                  <th class="total">Sell Price (BDT)</th>
                                  <th class="unit">Line Price (BDT)</th>
                                  <th class="action">Action</th>
                              </tr>

                            </thead>
                            <tbody id="tbody">
                                <tr v-for="(detail, index) in purchaseDetails" :key="index">
                                  <td class="sn">@{{index+1}}</td>
                                  <td class="model">
                                    @{{detail.name}}
                                    <br>
                                    <select v-model="detail.qty_type">
                                      <option value="unique">unique</option>
                                      <option value="quantity">quantity</option>
                                    </select>
                                  </td>
                                  <td class="s-n" v-if="detail.qty_type == 'unique'">
                                    <input type="text" style="width:100%" v-model="detail.unique_code">
                                  </td>
                                  <td class="s-n" v-else>
                                    <span style="width:50%">qty</span>
                                    <input type="number" style="width:50%" v-model="detail.quantity">
                                  </td>
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
                                  <td class="total" v-if="detail.qty_type == 'unique'">@{{calculateLineTotal(detail)}}</td>
                                  <td class="total" v-else>@{{isNaN(detail.buying_price * detail.quantity) ? 0 : detail.buying_price * detail.quantity}}</td>
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
                         <button type="submit" class="btn btn-info waves-effect pull-right m-r-10" name="invoice" value="active" @click.prevent="saveData()">Purchase</button>
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
                <h4 class="m-b-0 text-white">Supplier & Payments</h4></div>
            <div class="card-body">
                <div class="row">
                    <div class="bg-danger w-100 p-10">
                      <h6 class="m-b-0 text-white">Supplier Info</h6>
                    </div>
                    <div class="col-sm-12">

                        <label>Select Supplier</label>
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;" @change="changeSupplier($event)">
                            <option value="-1">Not registered Supplier</option>
                            <optgroup>
                                <option v-for="(supplier,index) in suppliers" :value="index" :key="index">@{{ supplier.name }}</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10" >        
                        <label style="font-weight: 500">Supplier information</label>
                        <div>
                          
                          <template v-if="selectedSupplier"> 
                            <p>Name: @{{selectedSupplier.name}}</p>
                            <p>Contact: @{{selectedSupplier.contact}}</p>
                            <p>Address: @{{selectedSupplier.address}}</p>
                          </template>
                          <p v-else class="text-alert">Supplier not selected</p>
                        </div>
                    </div>
                    <div class="bg-danger w-100 p-10">
                      <h6 class="m-b-0 text-white">Payment Info</h6>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>Payment From</label>
                      <select class="select2 form-control custom-select" style="width: 100%; height:36px;"  @change="changeAccount($event)">
                          <option value=""> --- Select payment account ---</option>
                          <option v-for="(account, index) in transactionAccounts" :value="index">@{{account.name}}</option>
                      </select>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>Purchase Date</label>
                      <input class="form-control" type="date" value="2011-08-19" v-model="purchase_date">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Payment amount</label>
                         <input type="number" v-model="payment_amount" min="0" class="form-control">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Transaction Note</label>
                         <textarea class="form-control" rows="3" v-model="payment_note" placeholder="Write some note if any..."></textarea>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>Redeem Date</label>
                      <input class="form-control" type="date" value="2011-08-19" v-model="redeem_date">
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
                        <button type="submit" class="btn waves-effect waves-light btn-block btn-info" name="invoice" value="active" @click.prevent="saveData()">Purchase</button>
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
            el: '#purchase',
            data: {
                errors: [],
                successMessage:'',

                suppliers: [],
                products: [],
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),

                selectedSupplier: '',
                selectedAccount: '',
                purchaseDetails: [],

                total: '',
                convayance: '',
                grandTotal: '',
                purchase_date: '',
                redeem_date: '',
                payment_amount: 0,
                payment_note: '',
            },
            computed: {
              computedTotal () {
                let total = 0;
                this.purchaseDetails.forEach(function (detail) {
                  if (detail.buying_price) {
                    if (detail.qty_type == 'quantity') {
                      total+=Number(detail.buying_price) * Number(detail.quantity);
                    } else { 
                      var str = detail.unique_code
                      var trim = str.replace(/(^,)|(,$)/g, "")   
                      trimArray = trim.split(',')              
                      total+=Number(detail.buying_price * trimArray.length);
                    }
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
                _this.getAllSupplier();
                _this.getAllProduct();
            },
            methods: {
                getAllSupplier() {
                    var _this = this;
                    axios.get('{{ route("suppliers.all") }}')
                    .then(function (response) {
                        _this.suppliers = response.data.suppliers;
                    })
                },
                getAllProduct() {
                    var _this = this;
                    axios.get('{{ route("products.all") }}')
                    .then(function (response) {
                        _this.products = response.data.products;
                    })
                },
                changeSupplier(event) 
                { 
                    var _this = this;
                    if(event.target.value<0)
                      _this.selectedSupplier = '';
                    else 
                      _this.selectedSupplier = _this.suppliers[event.target.value];
                },
                changeAccount(event) 
                { 
                    var _this = this;
                    if(event.target.value<0)
                      _this.selectedAccount = '';
                    else 
                      _this.selectedAccount = _this.transactionAccounts[event.target.value];
                },
                addToPurchase(event) 
                { 
                    var _this = this;
                    var index = _this.purchaseDetails.findIndex(detail => detail.id == _this.products[event.target.value].id);
                    if(index < 0 && event.target.value>=0) 
                      _this.purchaseDetails.push(_this.products[event.target.value]);
                },
                removeRow(index) 
                {   
                  this.purchaseDetails.splice(index, 1);
                },     
                calculateLineTotal(detail) 
                {
                    if (detail.qty_type == 'unique') {
                      var buying_price = detail.buying_price ? detail.buying_price : 0;
                      var str = detail.unique_code ? detail.unique_code : ''
                      var trim = str.replace(/(^,)|(,$)/g, "")    
                      trimArray = trim.split(',')              
                      return Number( buying_price * trimArray.length);
                    }
                },     
                clearData() {
                    var _this = this;

                    _this.errors= [];
                    _this.successMessage='';

                    _this.suppliers= [];
                    _this.products= [];
                    _this.transactionAccounts= JSON.parse('{!!$transactionAccounts!!}');

                    _this.selectedSupplier= '';
                    _this.selectedAccount= '';
                    _this.purchaseDetails= [];

                    _this.total= '';
                    _this.convayance= '';
                    _this.grandTotal= '';
                    _this.purchase_date= '';
                    _this.redeem_date= '';
                    _this.payment_amount= 0;
                    _this.payment_note= '';

                    _this.getAllSupplier();
                    _this.getAllProduct();
                },
                saveData() {
                    var _this = this;
                    _this.errors = [];
                    if(_this.validate()){
                        //save data
                        let data = {
                            supplier: _this.selectedSupplier,
                            account: _this.selectedAccount,
                            detail: _this.purchaseDetails,

                            purchase: {
                              convayance: _this.convayance,
                              purchase_date: _this.purchase_date,
                              redeem_date: _this.redeem_date,
                              payment: _this.payment_amount,
                              note: _this.payment_note,
                            }
                        }
                        axios.post('{{ route("purchases.addOrUpdate") }}', data)
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
                                        title: 'Purchase created successfully'
                                    })
                                    //end sweet alart
                                    _this.getAllSupplier();
                                    _this.getAllProduct();
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
                    let purchase = _this.purchase;
                    let count = 0; 
                    if (!_this.selectedSupplier) {
                        _this.errors.push("You must have to select a supplier first.");
                        count++;
                    }
                    if (_this.purchaseDetails.length < 1) {
                        _this.errors.push("You must have to select some product.");
                        count++;
                    }
                    _this.purchaseDetails.forEach(function (detail) {                      
                      var str = detail.unique_code
                      var trim = str.replace(/(^,)|(,$)/g, "")   
                      detail.unique_code = trim; 

                      if(!detail.buying_price) {
                          _this.errors.push("Add buying prices to all product.");
                          count++;
                      }
                      if(detail.qty_type == 'unique' && !detail.unique_code) {
                          _this.errors.push("Add unique code properly to all product.");
                          count++;
                      }
                      if(detail.qty_type == 'quantity' && (!detail.quantity || detail.quantity < 1)) {
                          _this.errors.push("Add quantity properly to all product.");
                          count++;
                      }
                    })
                    if (!_this.selectedAccount) {
                        _this.errors.push("You must have to select an account.");
                        count++;
                    }
                    if (!_this.purchase_date) {
                        _this.errors.push("Select a purchase date.");
                        count++;
                    }
                     if (!_this.payment_amount) {
                        _this.errors.push("you must have to select payment amount.");
                        count++;
                    }
                     if (!_this.convayance) {
                        _this.errors.push("you must have to add convayance. If no convayance then write 0.");
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