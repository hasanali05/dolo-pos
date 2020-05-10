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
                        <option v-for="(inventory,index) in products" :value="index" :key="index">@{{ inventory.product.name + " | " + inventory.supplier.name + (inventory.qty_type == 'unique' ?  (" | " + inventory.unique_code) : '')}}</option>
                    </select>
                </div>
                <div class="col-md-6"> 
                    Bar code / Unique code
                    <input type="text" class="form-control" id="barcodeScanner" aria-describedby="barcodeHelp" placeholder="Scan / Enter barcode" @blur="scannerScaned()" v-model="sacnedCode">
                    <small id="barcodeHelp" class="form-text text-muted">Click on the input and scan by barcode scanner.</small>
                </div>
              </div>
              <div class="row">
                <div class="table-responsive products">

                        <table id="invoiceTable" class="table table-bordered table-striped"  name="invoiceTable">
                            <thead>
                              <tr>
                                  <th class="sn">#</th>
                                  <th class="model">Product name</th>
                                  <th class="model">Supplier name</th>
                                  <th class="s-n">unique code / <br> Quantity</th>
                                  <th class="s-n">Warrenty</th>
                                  <th class="unit">Price (BDT)</th>
                                  <th class="unit">Line Price (BDT)</th>
                                  <th class="action">Action</th>
                              </tr>

                            </thead>
                            <tbody id="tbody">
                                <tr v-for="(detail, index) in saleDetails" :key="index">
                                  <td class="sn">@{{index+1}}</td>
                                  <td class="model">@{{detail.product.name}}</td>
                                  <td class="model">@{{detail.supplier.name}}</td>                                  
                                  <td class="s-n" v-if="detail.qty_type == 'unique'">
                                      @{{detail.unique_code}}
                                  </td>
                                  <td class="s-n" v-if="detail.qty_type == 'quantity'">
                                    avl: @{{detail.quantity - detail.sold_quantity}}
                                      <br>
                                    sale:<input type="number" style="width:50%" v-model="detail.sold_quantity" :max="detail.quantity" min="1">
                                  </td>
                                  <td class="unit">
                                    <span>@{{ detail.purchase.warranty_duration}} @{{ detail.purchase.warranty_type }}</span>
                                  </td>
                                  <td class="total"><input type="number" min="1" style="width:100%" v-model="detail.selling_price"></td>
                                  <td class="total" v-if="detail.qty_type == 'unique'">@{{isNaN(detail.selling_price) ? 0 : detail.selling_price}}</td>
                                  <td class="total" v-else>@{{isNaN(detail.selling_price * detail.sold_quantity) ? 0 : detail.selling_price * detail.sold_quantity}}</td>
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
                            <option v-for="(customer,index) in customers" :value="index" :key="index">@{{ customer.name }}</option>
                        </select>
                        <button type="button" class="btn btn-dark w-100" data-toggle="modal" data-target="#createCustomerModel"  @click.prevent="clearCustomerData()">
                        Create New
                        </button>
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
                      <label>Payment Collection to</label>
                      <select class="select2 form-control custom-select" style="width: 100%; height:36px;"  @change="changeAccount($event)">
                          <option value="">--Select Account--</option>
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
                    <div class="col-sm-12 p-t-10 p-b-10" v-if="computedDue > 0">
                        <label>Next Payment Date</label>
                        <input class="form-control" type="date" value="2011-08-19" v-model="next_payment_date">
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
    

<div class="modal fade" id="createCustomerModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel"><i class="ti-marker-alt mr-2"></i> Create New customer</h5>
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
                                    <button type="button" class="btn btn-info"><i class="fas fa-angle-double-down"></i></button>
                                    <select class="form-control form-white" v-model="customer.account_id">
                                        <option>select Account Name</option>
                                        <option v-for="account in accounts" :value="account.id">@{{account.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-user text-white"></i></button>
                                    <input type="text" class="form-control" placeholder="name" v-model="customer.name" required="">
                                    <input type="hidden" class="form-control" v-model="customer.id">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="fas fa-phone"></i></button>
                                    <input type="text" class="form-control" placeholder="contact" v-model="customer.contact" required="">
                                    
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="far fa-address-card"></i></button>
                                    <input type="text" class="form-control" placeholder="Address" v-model="customer.address" required="">
                                    
                                </div>
                            </div>


                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <button type="button" class="btn btn-info"><i class="ti-wand text-white"></i></button>
                                    <select class="form-control form-white" v-model="customer.is_active">
                                        <option value="1">Active</option>
                                        <option value="0">In-active</option>
                                    </select>
                                </div>
                            </div>                         
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Close</button>
                        <button type="submit" class="btn btn-info" @click.prevent="clearCustomerData()"><i class="ti-close"></i> Clear data</button>
                        <button type="submit" class="btn btn-success" @click.prevent="saveCustomerData()" v-if="!customer.id"><i class="ti-save"></i> Save</button>
                        <button type="submit" class="btn btn-primary" @click.prevent="saveCustomerData()" v-if="customer.id"><i class="ti-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
        
    </div>


            <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="employeeDetailLabel" aria-modal="true" id="supplyDetail">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="employeeDetailLabel">Supply detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Column -->
                            <div class="col-lg-12 col-xlg-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">  
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Account Name</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.account?customer.account.name:''}}</p>
                                            </div><div class="col-md-3 col-xs-6 b-r"> <strong>Name</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.name}}</p>
                                            </div>
                                             <div class="col-md-3 col-xs-6 b-r"> <strong>Mobile</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.contact}}</p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong>Status</strong>
                                                <br>
                                                <h3>
                                                    <span class="badge badge-success" v-if="customer.is_active == 1">Active
                                                    </span>
                                                    <span class="badge badge-danger" v-else>Inactive
                                                    </span>
                                                </h3>
                                            </div>
                                            <div class="col-md-6 col-xs-6 b-r"> <strong>Address</strong>
                                                <br>
                                                <p class="text-muted">@{{customer.address}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Column -->
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"  v-on:click="counter += 1" >Close</button>
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
                customer: {
                    id: '',
                    account_id:'',
                    name: '',
                    contact: '',
                    address: '',
                    is_active: '1',
                    account: {
                        id:'',
                        name: ''
                    }
                },
                accounts: JSON.parse('{!!$receivableAccounts!!}'),  
                sacnedCode: '',  

                customers: [],
                products: [],
                transactionAccounts: JSON.parse('{!!$transactionAccounts!!}'),

                selectedcustomer: '',
                selectedAccount: '',
                saleDetails: [],
                selectList: [],

                total: '',
                convayance: '0',
                grandTotal: '',
                sale_date: '{{date('Y-m-d')}}',
                next_payment_date: '',
                payment_amount: 0,
                payment_note: '',
            },
            computed: {
              computedTotal () {
                let total = 0;
                this.saleDetails.forEach(function (detail) {
                  if (detail.selling_price) {
                    if (detail.qty_type == 'quantity') {
                      total+=Number(detail.selling_price) * Number(detail.sold_quantity);
                    } else {                      
                      total+=Number(detail.selling_price);
                    }
                  }
                })
                this.total = total;
                return this.total;
              },
              computedGrandTotal () {
                // if(Number(this.convayance) > this.grandTotal) this.convayance = this.grandTotal;
                if(Number(this.convayance) < 0) this.convayance = 0;
                this.grandTotal = this.total+Number(this.convayance);
                return this.grandTotal;
              },
              computedPaid () {
                if(!this.payment_amount) this.payment_amount = 0;
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
                _this.getInventoryProduct();
            },
            methods: {
                scannerScaned(){
                  let found = -1;
                  for (let index = 0; index < this.products.length; index++) {
                    const product = this.products[index];
                    if(product.unique_code == this.sacnedCode) {
                      found = index;
                      break;
                    }
                  }
                  if(found == -1) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });                      
                        Toast.fire({
                            type: 'warning',
                            title: 'Product not found.'
                        })
                  } else {
                    this.findProductAndAdd(found);
                  }
                  
                },
                clearCustomerData() {
                    var _this = this;
                    _this.errors = [];
                    _this.customer = {
                        id: '',
                        name: '',
                        account_id: '',
                        contact: '',
                        address: '',
                        is_active: '1',
                        account:{
                            id:'',
                            name:''
                        }
                    }
                },
                
                saveCustomerData() {
                    var _this = this;
                    if(_this.validateCustomer()){
                        //save data
                        let data = {
                            customer: _this.customer
                        }
                        axios.post('{{ route("customers.addOrUpdate") }}', data)
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
                                    _this.customers.push(data.customer);
                                    //modal close
                                    document.getElementById('modalClose').click();
                                   
                                      //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Customer created successfully'
                                  })

                                    //end sweet alart
                                }
                                if(status=='updated') {
                                    
                                    _this.$set( _this.customers, _this.currentIndex, data.customer )
                                    //modal close
                                    document.getElementById('modalClose').click();
                                    
                                      //sweet alrat

                                    const Toast = Swal.mixin({
                                      toast: true,
                                      position: 'top-end',
                                      showConfirmButton: false,
                                      timer: 3000
                                  });

                                    Toast.fire({
                                      type: 'success',
                                      title: 'Customer updated successfully'
                                  })

                                    //end sweet alart
                                }
                                
                                _this.getAllcustomer();
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
                validateCustomer() {           
                    var _this = this; 
                    _this.errors = [];
                    let customer = _this.customer;
                    let count = 0; 

                    if (!customer.name) {
                        _this.errors.push("Name required.");
                        count++;
                    }
                     if (!customer.contact) {
                        _this.errors.push("Contact required.");
                        count++;
                    }
                    if (!customer.address) {
                        _this.errors.push("Address required.");
                        count++;
                    }

                     if (!customer.account_id) {
                        _this.errors.push("Account name required.");
                        count++;
                    }

                    if(count==0) return true;
                    else return false;
                },
                getAllcustomer() {
                    var _this = this;
                    axios.get('{{ route("customers.all") }}')
                    .then(function (response) {
                        _this.customers = response.data.customers;
                    })
                },
                getInventoryProduct() {
                    var _this = this;
                    axios.get('{{ route("inventories.prodducts") }}')
                    .then(function (response) {
                        _this.products = response.data.inventories;
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
                findProductAndAdd(value){
                    var _this = this;
                      let selectedIndex = _this.products[value].id;                    
                      let index = _this.selectList.indexOf(selectedIndex);
                      if(index == -1) {
                        //not found
                        _this.selectList.push(selectedIndex);
                        _this.saleDetails.push(_this.products[value]);
                      } else {  
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });                      
                        Toast.fire({
                            type: 'warning',
                            title: 'Product already added.'
                        })
                      }
                },
                addTosale(event) 
                { 
                    if(event.target.value>=0) {  
                      this.findProductAndAdd(event.target.value);
                    }
                },
                removeRow(index) 
                {   
                  let selectedIndex = this.selectList.indexOf(this.saleDetails[index].id);
                  this.selectList.splice( selectedIndex, 1 );
                  this.saleDetails.splice(index, 1);
                },           
                clearData() {
                    var _this = this;

                    _this.errors= [];
                    _this.successMessage='';

                    _this.customers= [];
                    _this.products= [];
                    _this.selectList= [];
                    _this.transactionAccounts= JSON.parse('{!!$transactionAccounts!!}');

                    _this.selectedcustomer= '';
                    _this.selectedAccount= '';
                    _this.saleDetails= [];

                    _this.total= '';
                    _this.convayance= '';
                    _this.grandTotal= '';
                    _this.sale_date= '{{date('Y-m-d')}}';
                    _this.payment_amount= 0;
                    _this.payment_note= '';
                },
                saveData() {
                    var _this = this;
                    _this.errors = [];
                    if(_this.validate()){
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
                                    //fetch updated inventory
                                    _this.getAllcustomer();
                                    _this.getInventoryProduct();
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
                      if(detail.qty_type == 'unique' && !detail.unique_code) {
                          _this.errors.push("Add unique code properly to all product.");
                          count++;
                      }
                      if(detail.qty_type == 'quantity' && (!detail.sold_quantity || detail.sold_quantity < 1)) {
                          _this.errors.push("Add quantity properly to all product.");
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
                    if (_this.computedDue > 0 && !_this.next_payment_date) {
                        _this.errors.push("Select a next payment date.");
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