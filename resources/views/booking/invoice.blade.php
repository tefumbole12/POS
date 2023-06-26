<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{url('public/logo', $general_setting->site_logo)}}" />
    <title>{{$general_setting->site_title}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        .waterm-mark {
            width: 20%;
            position: absolute;
            top: 40%;
            right: 330px;
            opacity: 0.3;
        }
        * {
            font-size: 14px;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor:pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #6449e7;
            color: #FFF;
            width: 100%;
        }
        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }
        tr {border-bottom: 1px dotted #ddd;}
        td,th {padding: 7px 0;width: 50%;}

        table {width: 100%;}
        tfoot tr th:first-child {text-align: left;}

        .centered {
            text-align: center;
            align-content: center;
        }
        small{font-size:11px;}

        @media print {
            * {
                font-size:12px;
                line-height: 20px;
            }
            td,th {padding: 5px 0;}
            .hidden-print {
                display: none !important;
            }
            @page { margin: 0; } body { margin: 0.5cm; margin-bottom:1.6cm; }
            /*tbody::after {*/
            /*    content: '';*/
            /*    display: block;*/
            /*    page-break-after: always;*/
            /*    page-break-inside: always;*/
            /*    page-break-before: avoid;*/
            /*}*/
            #print-footer {
                bottom: 0;
                }
        }
    </style>
  </head>
<body>

@if($general_setting->invoice_format == 'beyond_a4')
    <style>
        .btn {
            width: 25% !important;
        }
        .btn-info {
            float: right;
        }
        /*.lastPage {*/
        /*    page: last_page;*/
        /*    page-break-before: always; !* Use if your last page is blank, else omit. *!*/
        /*}*/

        /*@media print {*/
        /*    #print-footer {*/
        /*        position: absolute;*/
        /*        bottom: 0;*/
        /*        display: none;*/
        /*    }*/
        /*    @page last_page {*/
        /*        #print-footer {*/
        /*            position: relative;*/
        /*            display: inline-block;*/
        /*            top: 500px*/
        /*        }*/
        /*    }*/
        /*}*/
    </style>
    <img src="{{url('public/logo', $header)}}" style=" width: 100%;">
    <img src="{{url('public/logo', $water_mark)}}" class="waterm-mark">
    <div style="max-width:95vw;margin:0 auto; ">
@else
     <div style="max-width:400px;margin:0 auto; ">
@endif

    @if(preg_match('~[0-9]~', url()->previous()))
        @php $url = '../../bookings/index'; @endphp
    @else
        @php $url = url()->previous(); @endphp
    @endif
    <div class="hidden-print">
        <table>
            <tr>
                <td><a href="{{$url}}" class="btn btn-info"><i class="fa fa-arrow-left"></i> {{trans('file.Back')}}</a> </td>
                <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i> {{trans('file.Print')}}</button></td>
            </tr>
        </table>
        <br>
    </div>

    <div id="receipt-data">
        <div class="centered">
            @if($general_setting->site_logo)
                <img src="{{url('public/logo', $general_setting->site_logo)}}" height="42" width="50" style="margin:10px 0;filter: brightness(0);">
            @endif

            <h2>{{$lims_biller_data->company_name}}</h2>

            <p>{{trans('file.Address')}}: {{$lims_warehouse_data->address}}
                <br>{{trans('file.Phone Number')}}: {{$lims_warehouse_data->phone}}
            </p>
        </div>
        <p>{{trans('file.Date')}}: {{$lims_sale_data->created_at}}<br>
            {{trans('file.reference')}}: {{$lims_sale_data->reference_no}}<br>
            {{trans('file.customer')}}: {{$lims_customer_data->name}}<br>
            @if(in_array("JE-method", $all_permission))
            {{trans('file.Credit Account')}}: {{@$lims_account_data_cradit->name}} / {{@$lims_account_data_cradit->account_no}} - {{@$lims_account_data_cradit->departments->code}} <br>
            {{trans('file.Debit Account')}}: {{@$lims_account_data_debit->name}} / {{@$lims_account_data_debit->account_no}} - {{@$lims_account_data_debit->departments->code}}
            @endif
        </p>
        <table class="table-data">
            <tbody>
                <?php $total_product_tax = 0;?>
                @foreach($lims_product_sale_data as $key => $product_sale_data)
                <?php
                    if ($product_sale_data->multi_product_batch_id != null) {
                       $multi_product_batch_id =  json_decode($product_sale_data->multi_product_batch_id);
                       $multi_product_batch_qty =  json_decode($product_sale_data->multi_product_batch_qty);
                    }
                    $lims_product_data = \App\Product::find($product_sale_data->product_id);
                    if($product_sale_data->variant_id) {
                        $variant_data = \App\Variant::find($product_sale_data->variant_id);
                        $product_name = $lims_product_data->name.' ['.$variant_data->name.']';
                    }
                    elseif($product_sale_data->product_batch_id) {
                        $product_batch_data = \App\ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                        if (!@$multi_product_batch_id) {
                            $product_name = $lims_product_data->name.' ['.trans("file.Batch No").':'.$product_batch_data->batch_no.']';
                        } else {
                            $product_name = $lims_product_data->name;

                            foreach ($multi_product_batch_id as $key => $batch_id) {
                                $product_batch_data = \App\ProductBatch::select('batch_no')->find($batch_id);
                                $product_name .= ' ['.trans("file.Batch No").':'.$product_batch_data->batch_no . '×' . $multi_product_batch_qty[$key] . ']';
                            }
                        }
                    }
                    else
                        $product_name = $lims_product_data->name;
                ?>
                <tr>
                    <td colspan="2">
                        {{$product_name}}
                        <br>{{$product_sale_data->qty}} x {{number_format((float)($product_sale_data->total / $product_sale_data->qty), 2)}}

                        @if($product_sale_data->tax_rate)
                            <?php $total_product_tax += $product_sale_data->tax ?>
                            [{{trans('file.Tax')}} ({{$product_sale_data->tax_rate}}%): {{$product_sale_data->tax}}]
                        @endif
                    </td>
                    <td>{{$product_sale_data->start}} | {{$product_sale_data->end}}</td>
                    <td style="text-align:right;vertical-align:bottom">{{number_format((float)$product_sale_data->total, 2)}}</td>
                </tr>
                @endforeach

            <!-- <tfoot> -->
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.Total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->total_price, 2)}}</th>
                </tr>
                @if($general_setting->invoice_format == 'gst' && $general_setting->state == 1)
                <tr>
                    <td colspan="3">IGST</td>
                    <td style="text-align:right">{{number_format((float)$total_product_tax, 2)}}</td>
                </tr>
                @elseif($general_setting->invoice_format == 'gst' && $general_setting->state == 2)
                <tr>
                    <td colspan="3">SGST</td>
                    <td style="text-align:right">{{number_format((float)($total_product_tax / 2), 2)}}</td>
                </tr>
                <tr>
                    <td colspan="3">CGST</td>
                    <td style="text-align:right">{{number_format((float)($total_product_tax / 2), 2)}}</td>
                </tr>
                @endif
                @if($lims_sale_data->order_tax)
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.Order Tax')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_tax, 2)}}</th>
                </tr>
                @endif
                @if($lims_sale_data->order_discount)
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.Order Discount')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->order_discount, 2)}}</th>
                </tr>
                @endif
                @if($lims_sale_data->coupon_discount)
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.Coupon Discount')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->coupon_discount, 2)}}</th>
                </tr>
                @endif
                @if($lims_sale_data->shipping_cost)
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.Shipping Cost')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->shipping_cost, 2)}}</th>
                </tr>
                @endif
                <tr>
                    <th colspan="3" style="text-align:left">{{trans('file.grand total')}}</th>
                    <th style="text-align:right">{{number_format((float)$lims_sale_data->grand_total, 2)}}</th>
                </tr>
                <tr>
                    @if($general_setting->currency_position == 'prefix')
                    <th class="centered" colspan="3">{{trans('file.In Words')}}: <span>{{$currency->code}}</span> <span>{{str_replace("-"," ",$numberInWords)}}</span></th>
                    @else
                    <th class="centered" colspan="3">{{trans('file.In Words')}}: <span>{{str_replace("-"," ",$numberInWords)}}</span> <span>{{$currency->code}}</span></th>
                    @endif
                </tr>
            </tbody>
            <!-- </tfoot> -->
        </table>
        <table>
            <tbody>
                @foreach($lims_payment_data as $payment_data)
                <tr style="background-color:#ddd;">
                    <td style="padding: 5px;width:30%">{{trans('file.Paid By')}}: {{$payment_data->paying_method}}</td>
                    <td style="padding: 5px;width:40%">{{trans('file.Amount')}}: {{number_format((float)$payment_data->amount, 2)}}</td>
                    <td style="padding: 5px;width:30%">{{trans('file.Change')}}: {{number_format((float)$payment_data->change, 2)}}</td>
                </tr>
                @endforeach
                <tr><td class="centered" colspan="3">{{trans('file.Thank you for shopping with us. Please come again')}}</td></tr>
                <tr>
                    <td class="centered" colspan="3">
                    <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->reference_no, 'C128') . '" width="300" alt="barcode"   />';?>
                    <br>
                    <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($lims_sale_data->reference_no, 'QRCODE') . '" alt="barcode"   />';?>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- <div class="centered" style="margin:30px 0 50px">
            <small>{{trans('file.Invoice Generated By')}} {{$general_setting->site_title}}.
            {{trans('file.Developed By')}} Faby Developers</strong></small>
        </div> -->
    </div>
</div>
@if($general_setting->invoice_format == 'beyond_a4')
    <div class="lastPage" >
        <img id="print-footer" src="{{url('public/logo', $footer)}}" style=" width: 100%;">
    </div>
@endif
<script type="text/javascript">
    localStorage.clear();
    function auto_print() {
        window.print()
    }
    setTimeout(auto_print, 1000);
</script>

</body>
</html>
