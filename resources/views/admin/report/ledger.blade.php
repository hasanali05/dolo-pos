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

    

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Inventory
                    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addNewCategory" aria-hidden="true" style="float: right;">Add new</button> -->
                </h4>
                <div class="row">                  
   
                             
                    <div class="col-3" >             
                        <div class=" row {{ $errors->has('from_date') ? ' has-danger' : '' }}">
               
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label text-right">From</label>
                            <div class="col-sm-9">                     
                                 <input type="date" name="input_from_date"  class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>          
                    </div>
                    <div class="col-3" >             
                        <div class=" row {{ $errors->has('from_date') ? ' has-danger' : '' }}">
                            
                            <label for="inputHorizontalDnger" class="col-sm-3 col-form-label text-right">To</label>
                            <div class="col-sm-9">                     
                                  <input type="date" name="input_to_date"  class="form-control" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>          
                    </div>  
                       
                    <div class="col-3"> 
                        <button class="btn btn-outline-info w-100 action-list">List</button>
                    </div>              
                    <div class="col-3"> 
                        <button class="btn btn-outline-danger  w-100 action-exit">Exit</button>
                    </div> 
                    
                </div> 
            </div>
            <div class="card-body">
                <div class="row">    
                    <div class="col-12 ">    
                        <div class="table-responsive" id="listTable"></div>
                    </div>               
                </div> 
            </div>
        </div>
    </div>
</div>

<form action="javascript:void(0)" method="POST" style="display: none" id="submitForm"> 
    {{ csrf_field() }}
    
    <input type="hidden" name="from_date" value="{{ date('Y-m-d') }}">
    <input type="hidden" name="to_date" value="{{ date('Y-m-d') }}">
    <!-- search list -->
</form>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->



@endsection

@section('custom-js')
 <!-- This is data table -->
    <script src="{{ asset('/template/assets/extra-libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>

    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script>

        $(document).ready(function() {            
            $('.action-exit').on('click', function () {
                $('.content-section').html('');
                $.toast({
                    heading: 'Information',
                    text: 'Your selected section is closed.',
                    position: 'top-right',
                    loaderBg:'#0000ff',
                    icon: 'info',
                    hideAfter: 4500, 
                    stack: 5
                });
            })

            $('input[name="input_from_date"]').on('change', function () {
                $('form input[name="from_date"]').val($(this).val());
            })
            $('input[name="input_to_date"]').on('change', function () {
                $('form input[name="to_date"]').val($(this).val());
            })


            $('.action-list').on('click', function () {
                $('#listTable').html('');
                var myForm = document.getElementById('submitForm');
                formData = new FormData(myForm);

                if(validationPayment(formData)){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.incomeExpense') }}",
                        data:formData,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            incomes = response.incomes; 
                            expenses = response.expenses; 
                            incomeRows = ``;
                            expenseRows = ``;
                            var totalIncome = 0;
                            var totalExpense = 0;
                            incomes.forEach(function(element) {
                                incomeRows += `<tr>
                                        <td style="padding-left:50px" colspan="2">`+element.name+`</td>
                                        <td style="text-align:right">`+element.amount+`</td>
                                    </tr>`;
                                totalIncome += element.amount;
                            });
                            expenses.forEach(function(element) {
                                expenseRows += `<tr>
                                        <td style="padding-left:50px" colspan="2">`+element.name+`</td>
                                        <td style="text-align:right">`+element.amount+`</td>
                                    </tr>`;
                                totalExpense += element.amount;

                            });
                            var profitLoss = `<tr>
                                    <th colspan="3" style="text-align:center"><h1>Loss profit</h1></th>
                                </tr>`;
                            if(totalExpense > totalIncome)
                            {
                                profitLoss = `<tr>
                                    <th colspan="3" style="text-align:center"><h1>Expense over Income : `+(totalExpense - totalIncome)+` </h1></th>
                                </tr>`;
                            } else {
                                profitLoss = `<tr>
                                    <th colspan="3" style="text-align:center"><h1>Income over Expense : `+(totalIncome - totalExpense)+` </h1></th>
                                </tr>`;
                            }
                            $('#listTable').append(`<table id="incomeExpenseTable" class="table table-bordered table-striped" name="incomeExpenseTable">
                                <thead>
                                    <tr>
                                        <th colspan="2" style="text-align:center">Account Head</th>
                                        <th style="text-align:right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th colspan="3" >Incomes</th>
                                </tr>
                                `+incomeRows+`
                                <tr>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total Income</th>
                                        <th style="text-align:right">`+totalIncome+`</th>
                                    </tr>
                                </tr>
                                <tr>
                                    <th colspan="3" align="left">Expenses</th>
                                </tr>
                                `+expenseRows+`
                                <tr>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total Expenses</th>
                                        <th style="text-align:right">`+totalExpense+`</th>
                                    </tr>
                                </tr>`+profitLoss+`   
                                </tbody>
                            </table>`);
                        // incomeExpenseTable = $('table[name="incomeExpenseTable"]').DataTable({
                        //     dom: 'Bfrtip',
                        //     buttons: [ 'pdf', 'print'],
                        //     pageLength: 100
                        //     });                      
                            $.toast({
                                heading: 'Success',
                                text: 'All listed data shown.',
                                position: 'top-right',
                                loaderBg:'#0000ff',
                                icon: 'success',
                                hideAfter: 4500, 
                                stack: 5
                            })
                        },
                        error: function(response) {
                        }
                    });
                }                
            })
        });
    function validationPayment(formData) {
        var count = 0;
        if(formData.get('receipt_id') == '' || formData.get('receipt_id') == 0 )  {
            count++;                
            $.toast({
                heading: 'Error',
                text: 'Please check date receipt no.',
                position: 'top-right',
                loaderBg:'#0000ff',
                icon: 'error',
                hideAfter: 4500, 
                stack: 5
            });
        }
        if(count == 0 ) return true;
        else return false;
    }
    </script>

@endsection

