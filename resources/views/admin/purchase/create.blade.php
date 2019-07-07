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







    




@php($products = [])
@php($customers = [])

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
                    <select class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="showInventory(this)" name="product_id">
                        <option value="0"><--- Select Product ---></option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}"> {{ $product->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">                  
                  <a href="javascript:void(0)" data-toggle="tooltip" data-original-title="New service" onclick="newService()"  class="btn btn-info m-r-10"style="float: right;"><i class="fa fa-plus m-r-10"></i>Add outside product/ Service</a>
                </div>
              </div>
              <div class="row">
                <div class="table-responsive products">

                        <table id="invoiceTable" class="table table-bordered table-striped"  name="invoiceTable">
                            <thead>
                              <tr>
                                  <th class="sn">#</th>
                                  <th class="model">Name</th>
                                  <th class="s-n">S/N</th>
                                  <th class="qty">QTY</th>
                                  <th class="unit">Unit Price (BDT)</th>
                                  <th class="total">Line Total (BDT)</th>
                                  <th class="action">Action</th>
                              </tr>

                            </thead>
                            <tbody id="tbody">
                                <tr>
                                  <td class="sn">#</td>
                                  <td class="model">Name</td>
                                  <td class="s-n">S/N</td>
                                  <td class="qty">QTY</td>
                                  <td class="unit"><input type="number" min="1" max="1" style="width:100%" value="1" name="qty"></td>
                                  <td class="total">Line</td>
                                  <td class="action"><a href="javascript:void(0)" data-toggle="tooltip" data-original-title="Remove" onclick="removeRow(this)"> <i class="fa fa-trash text-danger m-r-10"></i> </a></td>
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
                         <button type="submit" class="btn btn-info waves-effect pull-right m-r-10" name="invoice" value="active">Generate</button>
                </div>
             </div> 
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-header bg-info">
                <h4 class="m-b-0 text-white">Customer & Payments</h4></div>
            <div class="card-body">
                <div class="row">

                  <div class="bg-danger w-100 p-10">
                    <h6 class="m-b-0 text-white">Customer Info</h6>
                  </div>

                    <div class="col-sm-12">

                        <label>Select Customer</label>
                        <select class="select2 form-control custom-select" style="width: 100%; height:36px;"  name="customer_id" onchange="customerInfo(this)">
                            <option value="0">Not registered Customer</option>
                            <optgroup>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->user_name }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-sm-12 p-t-10">
                        <!-- sample modal content -->
                            <button type="button" class="btn btn-info w-100" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add New Customer</button>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10" >        
                        <label>Customer information</label>
                        <div id="customerInfo">
                          
                          <p>Not registered Customer</p>
                          <input type="hidden" name="customer_name" class="form-control" placeholder="Name" value="Note registered">
                          <input type="hidden" name="customer_company_name" class="form-control" placeholder="Company name">
                          <input type="hidden" name="customer_contact" class="form-control"  placeholder="Contact">
                          <textarea placeholder="address" class="form-control" name="customer_address" style="display:none"></textarea>
                        </div>
                    </div>

                  <div class="bg-danger w-100 p-10">
                    <h6 class="m-b-0 text-white">Payment Info</h6>
                  </div>
                    <div class="col-sm-12 p-t-10 p-b-10">
                                <label>Payment Type</label>
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" name="payment_type" onchange="paymentType(this)">                                
                                    <option value="Cash">Cash</option>
                                    <option value="Credit">Credit</option>
                                    <option value="Check">Check</option>
                                </select>
                                <input class="form-control" type="date" value="2011-08-19" name="payment_date" style="display: none;">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10" style="display: none" id="payment">
                         <label>Payment amount</label>
                         <input type="number" name="payment" min="0" class="form-control" value="0" max="0">
                    </div>

                    <div class="col-sm-12 p-t-10 p-b-10">
                         <label>Transaction Note</label>
                         <textarea class="form-control" rows="3" name="payment_note" placeholder="Write some note if any..."></textarea>
                    </div>

                  <div class="bg-danger w-100 p-10">
                    <h6 class="m-b-0 text-white">Shipping Info</h6>
                  </div>
                    <div class="col-sm-12 p-t-10 p-b-10">
                                    <option>Shipping Type</option>
                                <select class="select2 form-control custom-select" style="width: 100%; height:36px;" onchange="shippingInfo(this)" name="delivery_method">
                                    <optgroup>
                                        <option value="From Office">From Office</option>
                                        <option value="Company delivery">Company delivery</option>
                                        <option value="Type 3">Type 3</option>
                                    </optgroup>
                                </select>
                    </div>                    
                    <div class="col-sm-12 p-t-10 p-b-10">        
                        <label>Shipping information</label>
                        <div id="shippingInfo">                          
                          <p>Not applicable</p>
                          <input type="hidden" name="shipping_name" class="form-control" placeholder="Name" value="Not applicable">
                          <input type="hidden" name="shipping_company_name" class="form-control" placeholder="Company name">
                          <input type="hidden" name="shipping_contact" class="form-control"  placeholder="Contact">
                          <textarea placeholder="address" class="form-control" name="shipping_address" style="display:none"></textarea>
                        </div>
                    </div>

                  <div class="bg-danger w-100 p-10">
                    <h6 class="m-b-0 text-white">Sale person</h6>
                  </div>

                    <div class="col-sm-12 p-t-10 p-b-10">        
                        <label>Sale person name</label>
                        <div>                          
                          <input class="form-control" type="text" name="sales_person" placeholder="sales person name">
                        </div>
                    </div>
                    <div class="col-sm-12 p-t-10 p-b-10">
                                <button type="submit" class="btn waves-effect waves-light btn-block btn-info" name="invoice" value="active">Generate</button>
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
                purchase: {
                    id: '',
                    purchase_date: '',
                    amount: '',
                    commission: '',
                    payment: '',
                    due: '',
                    is_active: '1',
                    supplier: {
                        id:'',
                        name: ''
                    }
                },
                currentIndex: 0,
                purchases: [],                
                successMessage:'',
            },
            mounted() {
                var _this = this;
                _this.getAllData();
            },
            methods: {
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

           
                clearData() {
                    var _this = this;
                    _this.errors = [];
                    _this.purchase = {
                        id: '',
                        purchase_date: '',
                        amount: '',
                        commission: '',
                        payment: '',
                        due: '',
                        is_active: '1',
                        supplier:{
                            id:'',
                            name:''
                         
                  
                    
                    }
                        }
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

                    if (!purchase.purchase_date) {
                        _this.errors.push("Purchase date required.");
                        count++;
                    }
                     if (!purchase.amount) {
                        _this.errors.push("Amount required.");
                        count++;
                    }
                    if (!purchase.commission) {
                        _this.errors.push("Commission required.");
                        count++;
                    }

                     if (!purchase.payment) {
                        _this.errors.push("Payment required.");
                        count++;
                    }
                     if (!purchase.due) {
                        _this.errors.push("Due required.");
                        count++;
                    }
                     if (!purchase.supplier.id) {
                        _this.errors.push("Supplier name required.");
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