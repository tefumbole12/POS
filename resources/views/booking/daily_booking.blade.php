@extends('layout.main')
@section('content')
<section>
    <style>
        *{ color-adjust: exact;  -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .red-green{
            background: linear-gradient(red , green);
            color: white;
        }
        .red{
            background: linear-gradient(red , red);
            color: white;
        }
        .green{
            background: linear-gradient(green , green);
            color: white;
        }
    </style>
	<div class="container-fluid">
		<div class="card">
			<div class="card-body">
				{{ Form::open(['route' => ['report.dailyBookingByWarehouse', $year, $month], 'method' => 'post', 'id' => 'report-form']) }}
				<input type="hidden" name="warehouse_id_hidden" value="{{$warehouse_id}}">
				<h4 class="text-center">Booking Calender &nbsp;&nbsp;
				<select class="selectpicker" id="warehouse_id" name="warehouse_id">
					<option value="0">{{trans('file.All Warehouse')}}</option>
					@foreach($lims_warehouse_list as $warehouse)
					<option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
					@endforeach
				</select>
                    <button class="btn btn-default pull-right" onclick="printCalender()">Print</button>
                </h4>
				{{ Form::close() }}

				<div class="table-responsive mt-4">
					<table class="table table-bordered" style="border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6;">
						<thead>
							<tr>
								<th><a class="hide" href="{{url('report/daily_booking/'.$prev_year.'/'.$prev_month)}}"><i class="fa fa-arrow-left"></i> {{trans('file.Previous')}}</a></th>
						    	<th colspan="5" class="text-center">{{date("F", strtotime($year.'-'.$month.'-01')).' ' .$year}}</th>
						    	<th><a class="hide" href="{{url('report/daily_booking/'.$next_year.'/'.$next_month)}}">{{trans('file.Next')}} <i class="fa fa-arrow-right"></i></a></th>
						    </tr>
						</thead>
					    <tbody>
						    <tr>
							    <td><strong>Sunday</strong></td>
							    <td><strong>Monday</strong></td>
							    <td><strong>Tuesday</strong></td>
							    <td><strong>Wednesday</strong></td>
							    <td><strong>Thrusday</strong></td>
							    <td><strong>Friday</strong></td>
							    <td><strong>Saturday</strong></td>
						    </tr>
						    <?php
						    	$i = 1;
						    	$flag = 0;
						    	while ($i <= $number_of_day) {
						    		echo '<tr>';
						    		for($j=1 ; $j<=7 ; $j++){
						    			if($i > $number_of_day)
						    				break;

						    			if($flag){
						    				if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
						    					echo '<td class="'.@$color[$i].'"><p style="color:red"><strong>'.$i.'</strong></p>';
						    				else
						    					echo '<td  class="'.@$color[$i].'"><p><strong>'.$i.'</strong></p>';

                                            $customer_names = '';
                                            if(isset($booking_data_array[$i])){
                                                foreach ($booking_data_array[$i] as $customer) {
                                                    $customer_names .= $customer . '<br>';
                                                }
                                                if($customer_names != '') {
                                                    echo '<strong>'.trans("file.Customer Name").'</strong><br><span>'.$customer_names.'</span>';
                                                }
                                            }

						    				echo '</td>';
						    				$i++;
						    			}
						    			elseif($j == $start_day){
						    				if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
						    					echo '<td  class="'.@$color[$i].'"><p style="color:red"><strong>'.$i.'</strong></p>';
						    				else
						    					echo '<td  class="'.@$color[$i].'"><p><strong>'.$i.'</strong></p>';

                                            $customer_names = '';
						    				if(isset($booking_data_array[$i])){
                                                foreach ($booking_data_array[$i] as $customer) {
                                                    $customer_names .= $customer . '<br>';
                                                }
                                                if($customer_names != '') {
                                                    echo '<strong>'.trans("file.Customer Name").'</strong><br><span>'.$customer_names.'</span>';
                                                }
						    				}

						    				echo '</td>';
						    				$flag = 1;
						    				$i++;
						    				continue;
						    			}
						    			else {
						    				echo '<td></td>';
						    			}
						    		}
						    	    echo '</tr>';
						    	}
						    ?>
					    </tbody>
                        <tfoot>
                            <tr>
                                <th>Paid</th>
                                <td><span class="red" style="padding: 10px 30px"></span></td>
                                <th>Non-Paid</th>
                                <td><span class="green" style="padding: 10px 30px"></span></td>
                                <th>Paid-Unpaid</th>
                                <td><span class="red-green" style="padding: 10px 30px"></span></td>
                            </tr>
                        </tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">

    function printCalender(){
        event.preventDefault();
        $(".side-navbar").hide();
        $("#report-form").hide();
        $(".hide").hide();
        print();
        $(".side-navbar").show();
        $("#report-form").show();
        $(".hide").show();
    }
	$("ul#booking").siblings('a').attr('aria-expanded','true');
    $("ul#booking").addClass("show");
    $("ul#booking #booking-report-menu").addClass("active");

	$('#warehouse_id').val($('input[name="warehouse_id_hidden"]').val());
	$('.selectpicker').selectpicker('refresh');

	$('#warehouse_id').on("change", function(){
		$('#report-form').submit();
	});
</script>
@endsection
