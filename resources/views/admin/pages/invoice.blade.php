<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Example 1</title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif;
        }
        
        .page .size-a4 {
            width: 100%
        }
        
        .page .size-a4 .layout-landscape {
            width: 100%
        }
        
        @media print {
            body,
            .page {
                margin: 0;
                box-shadow: 0;
            }
        }
        
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        
        .float-right {
            float: right;
        }

        .pv-0 {
            padding-left: 0;
            padding-right: 0;
        }
        .ph-0 {
            padding-top: 0;
            padding-bottom: 0;
        }
        .w-1 {
            width: 10%;
        }
        .w-2 {
            width: 20%;
        }
        .w-3 {
            width: 30%;
        }
        .w-4 {
            width: 40%;
        }
        .w-5 {
            width: 50%;
        }
        .w-6 {
            width: 60%;
        }
        .w-7 {
            width: 70%;
        }
        .w-8 {
            width: 80%;
        }
        .w-9 {
            width: 90%;
        }
        .w-10 {
            width: 100%;
        }
        .va-top td, .va-top th {
            vertical-align: top;
        }
        .va-middle td, .va-middle th {
            vertical-align: middle;
        }
        .va-bottom td, .va-bottom th {
            vertical-align: bottom;
        }
        
        .content {
            height: 19cm; 
            border: 1px solid #a7a7a7;
        }

        .company-info {
            padding: .1cm .1cm;
        }
        
        .company-title {
            font-family: 'Times New Roman';
            text-align: center;
            font-size: 29px;
            font-weight: 600;
            margin-bottom: 0.3cm;
        }
        
        .company-detail {
            font-family: 'Times New Roman';
            text-align: center
        }
        
        .company-detail p {
            margin: 0;
            font-size: 14px;
        }

        .detail-title {
            width: 200px;
        }

        .invoice {
            text-align: center;
        }

        .invoice-span {
            text-align: center;
            border: 2px solid;
            padding: 8px 12px;
            border-radius: 20px;
        }
        
        .bottom-dashed {
            border-bottom: 2px dashed black;
        }
        
        .bottom-solid {
            border-bottom: 2px solid black;
        }
        
        
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            color: #4a4a4d;
            font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        
        table td, table td * {
            vertical-align: top;
        }
    
        .item-table td {
            font: 12px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        .item-table td, .item-table th {
            border-bottom: 1px solid #a7a7a7;
            border-right: .5px solid #a7a7a7;
            border-top: 1px solid #a7a7a7;
            border-left: .5px solid #a7a7a7;
        }

        .item td {
            height: 1cm;
            padding: 5px;
        }
        .item-serial {
            vertical-align: middle;
            text-align: center;
        }
        .item-description {
            vertical-align: top;
            text-align: left;
        }
        .item-amount {
            vertical-align: middle;
            text-align: right;
        }

        .signature {
            position:fixed; 
            bottom:85
        }
        
        footer {
            color: #a7a7a7;
            width: 100%;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #a7a7a7;
            text-align: center;
        }

        .footer {
            text-align: center;
            font-family: 'Times New Roman';
            font-size: 8px;
        }

    </style>
</head>

<body>
    <div class="page size-a4 layout-landscape">
        <table>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="w-1"></td>
                            <td class="w-8">                                    
                                <div class="company-info">
                                    <div class="company-title">Mr Computer Information</div>
                                    <div class="company-detail">
                                        <p>95, City support market, Shop# 16-17, Ground floor, New Elephant Road, Dhaka -1205</p>
                                        <p>02-9613143, 01712751866, 01861502657</p>
                                        <p>E-mail: abc@hotmail.com.</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-1"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>                    
                    <h3 class="invoice" style="margin:5px 0"> <span class="invoice-span">Invoice</span></h3>
                </td>
            </tr>
            <tr>
                <td>
                    <table class="w-10">
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Company Name</b> <span class="float-right">:</span>
                                        </td>
                                        <td> <b>It Gallery</b></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Address</b> <span class="float-right">:</span>
                                        </td>
                                        <td> Some address</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Mobile</b> <span class="float-right">:</span>
                                        </td>
                                        <td>01779295962</td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Invoice No</b> <span class="float-right">:</span>
                                        </td>
                                        <td> A001NV20001379</td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Ref No</b> <span class="float-right">:</span>
                                        </td>
                                        <td> No ref</td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4 bottom-solid">
                                            <b>Sold By</b> <span class="float-right">:</span>
                                        </td>
                                        <td class="bottom-solid"> Raju</td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Date and time</b> <span class="float-right">:</span>
                                        </td>
                                        <td> Raju</td>
                                    </tr>
                                    <tr>
                                        <td class="ph-0 pv-0 w-4">
                                            <b>Sale Time</b> <span class="float-right">:</span>
                                        </td>
                                        <td> Raju</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                </td>
            </tr>
            <tr>
                <td class="content pv-0 ph-0">
                    <table>                    
                        <tr>
                            <td class="pv-0 ph-0">                                        
                                <table class="item-table">
                                    <thead>
                                        <tr class="va-middle">
                                            <th style="width: 20px;">Sl</th>
                                            <th>Description</th>
                                            <th style="width: 75px;">Warranty</th>
                                            <th style="width: 75px;">Sold Qty</th>
                                            <th style="width: 75px;">Unit Price</th>
                                            <th style="width: 75px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="item">
                                            <td class="item-serial">Sl</td>
                                            <td class="item-description">Description</td>
                                            <td class="item-serial">Warranty</td>
                                            <td class="item-amount">Sold Qty</td>
                                            <td class="item-amount">Unit Price</td>
                                            <td class="item-amount">Amount</td>
                                        </tr>
                                        <tr class="item">
                                            <td class="item-serial">Sl</td>
                                            <td class="item-description">Description</td>
                                            <td class="item-serial">Warranty</td>
                                            <td class="item-amount">Sold Qty</td>
                                            <td class="item-amount">Unit Price</td>
                                            <td class="item-amount">Amount</td>
                                        </tr>
                                        <tr class="item">
                                            <td class="item-serial">Sl</td>
                                            <td class="item-description">Description</td>
                                            <td class="item-serial">Warranty</td>
                                            <td class="item-amount">Sold Qty</td>
                                            <td class="item-amount">Unit Price</td>
                                            <td class="item-amount">Amount</td>
                                        </tr>
                                        <tr class="item">
                                            <td class="item-serial">Sl</td>
                                            <td class="item-description">Description</td>
                                            <td class="item-serial">Warranty</td>
                                            <td class="item-amount">Sold Qty</td>
                                            <td class="item-amount">Unit Price</td>
                                            <td class="item-amount">Amount</td>
                                        </tr>
                                        <tr class="item">
                                            <td class="item-serial">Sl</td>
                                            <td class="item-description">Description</td>
                                            <td class="item-serial">Warranty</td>
                                            <td class="item-amount">Sold Qty</td>
                                            <td class="item-amount">Unit Price</td>
                                            <td class="item-amount">Amount</td>
                                        </tr>
                                    </tbody>
                                </table>    
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td class="w-5">
                                            <h2 style="text-align:center">Due</h2>
                                            <p>Total amount is about hits sis asdflnzxcvks</p>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td class="w-7">Total Amount</td>
                                                    <td class="w-3 item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-7">Add Vat</td>
                                                    <td class="w-3 item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-7">Less Discount</td>
                                                    <td class="w-3 item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-7 bottom-solid">Add Istallation / Service Charges</td>
                                                    <td class="w-3 bottom-solid item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-7" style="text-align: left;">Net Payable Amount</th>
                                                    <th class="w-3 item-amount">value</th>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <br>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px;">
                                <table>
                                    <tr>
                                        <td class="w-5" style=" border:1px solid #a7a7a7">
                                            
                                            <table>
                                                <tr>
                                                    <td class="w-7">Total Amount</td>
                                                    <td class="w-3 item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <td class="w-7 bottom-dashed">Add Istallation / Service Charges</td>
                                                    <td class="w-3 bottom-dashed item-amount">value</td>
                                                </tr>
                                                <tr>
                                                    <th class="w-7" style="text-align: left;">Net Payable Amount</th>
                                                    <th class="w-3 item-amount">value</th>
                                                </tr>
                                            </table>
                                        </td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="signature" style="padding: 0 20px;">
                        <span style="padding: 0 40px; border-top: 1px solid #a7a7a7">Customer Signature</span>
                        <span class="float-right" style="padding: 0 40px; border-top: 1px solid #a7a7a7">Authorised Signature</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    Note
                </td>
            </tr>
        </table>
        <footer>
            Invoice was created on a computer and is not valid without the signature and seal.
        </footer>
    </div>
</body>

</html>