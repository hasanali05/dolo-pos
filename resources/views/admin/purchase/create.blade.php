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
                <div class="col-md-6">                  
                  Products:
                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;" @change="addToPurchase($event)">
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
                                  <th class="s-n">Warrenty</th>
                                  <th class="unit">Buy Price (BDT)</th>
                                  <th class="total">Sell Price (BDT)</th>
                                  <th class="action">Action</th>
                              </tr>

                            </thead>
                            <tbody id="tbody">
                                <tr v-for="(detail, index) in purchaseDetails" :key="index">
                                  <td class="sn">@{{index+1}}</td>
                                  <td class="model">@{{detail.name}}</td>
                                  <td class="s-n"><input type="text" style="width:100%" v-model="detail.unique_code"></td>
                                  <td class="unit">
                                    <input type="number" min="1" max="1" style="width:48%" v-model="detail.warranty_duration">
                                    <select style="width:48%; height: 100%;" v-model="detail.warranty_type">
                                      <option value="days">days</option>
                                      <option value="months">months</option>
                                      <option value="years">years</option>
                                    </select>
                                  </td>
                                  <td class="unit"><input type="number" min="1" max="1" style="width:100%" v-model="detail.buying_price"></td>
                                  <td class="total"><input type="number" min="1" max="1" style="width:100%" v-model="detail.selling_price"></td>
                                  <td class="action">
                                    <a data-toggle="tooltip" data-original-title="Remove" @click.prevent="removeRow(index)">
                                      <i class="fa fa-trash text-danger m-r-10"></i> 
                                    </a>
                                  </td>
                              </tr>
                            </tbody>
                            <tfoot>
                              <tr class="summery">
                                  <td colspan="5" >Subtotal</td>
                                  <td colspan="2" id="subtotal">0</td>
                              </tr>        
                              <tr class="summery">
                                  <td colspan="5">Sales Tax </td>
                                  <td colspan="2" id="tax">0</td>
                              </tr>        
                              <tr class="summery">
                                  <td colspan="5">Total</td>
                                  <td colspan="2" id="total">0</td>
                              </tr>        
                              <tr class="summery">
                                  <td colspan="5" style="font-weight: bold">Convayance</td>
                                  <td colspan="2" id="convayance">0</td>
                              </tr>  
                              <tr class="summery">
                                  <td colspan="5" style="font-weight: bold">Grand Total</td>
                                  <td colspan="2" id="grandTotal">0</td>
                              </tr>
                              </tfoot>
                        </table>
                        <br>
                        <br>
                         <button type="submit" class="btn btn-info waves-effect pull-right m-r-10" name="invoice" value="active" @click.prevent="saveData()">Save Purchase</button>
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
                    <div class="col-sm-12 p-t-10">
                        <!-- sample modal content -->
                            <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add New Supplier</button>
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
                          <option v-for="(account, index) in transactionAccounts" :value="index">@{{account.name}}</option>
                      </select>
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                      <label>Purchase Date</label>
                      <input class="form-control" type="date" value="2011-08-19" name="payment_date">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10" style="display: none" id="payment">
                         <label>Payment amount</label>
                         <input type="number" name="payment_amount" min="0" class="form-control" value="0" max="0">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Transaction Note</label>
                         <textarea class="form-control" rows="3" name="payment_note" placeholder="Write some note if any..."></textarea>
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
                        <button type="submit" class="btn waves-effect waves-light btn-block btn-info" name="invoice" value="active" @click.prevent="saveData()">Generate</button>
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

                selectedSupplier: '',
                selectedAccount: '',
                purchaseDetails: [],
                suppliers: [],
                products: [],
                currentIndex: 0,
                purchase: '',
                successMessage:'',
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),
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
                getAllData() {
                    var _this = this;
                    axios.get('{{ route("purchases.all") }}')
                    .then(function (response) {
                        _this.purchases = response.data.purchases;
                    })
                },
                setData(index) {
                    var _this = this;
                    _this.errors = [];
                    _this.currentIndex = index;
                    _this.purchase = _this.purchases[index];
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
                    if(event.target.value>=0) 
                      _this.purchaseDetails.push(_this.products[event.target.value]);
                },
                removeRow(index) 
                {   
                  this.purchaseDetails.splice(index, 1);
                },

           
            
                saveData() {
                    var _this = this;
                    if(_this.validate()){
                        //save data
                        let data = {
                            purchase: _this.purchase
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
                                    _this.purchases.push(data.purchase);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Purchase created successfully';
                                }
                                if(status=='updated') {
                                    _this.purchases[_this.currentIndex] = data.purchase;
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    _this.successMessage = 'Purchase updated successfully';
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