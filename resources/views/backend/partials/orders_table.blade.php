<div class="table-responsive">
	<table class="table table-borderless table-theme" style="width:100%;">
		<thead>
			<tr>
				<th class="checkboxlist text-center" style="width:3%"><input class="tp-check-all checkAll" type="checkbox"></th>
				<th class="text-left" style="width:8%">{{ __('Order#') }}</th>
				<th class="text-left" style="width:8%">{{ __('Order Date') }}</th>
				<th class="text-left" style="width:10%">{{ __('Customer') }} </th>
				<th class="text-left" style="width:10%">{{ __('Store') }}</th>
				<th class="text-center" style="width:8%">{{ __('Subtotal') }}</th>
				<th class="text-center" style="width:5%">{{ __('Tax') }}</th>
				<th class="text-center" style="width:8%">{{ __('Shipping Fee') }}</th>
				<th class="text-center" style="width:8%">{{ __('Total Amount') }}</th>
				<th class="text-center" style="width:9%">{{ __('Payment Method') }}</th>
				<th class="text-center" style="width:9%">{{ __('Payment Status') }}</th>
				<th class="text-center" style="width:9%">{{ __('Order Status') }}</th>
				<th class="text-center" style="width:5%">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@if (count($datalist)>0)
			@php $gtext = gtext(); @endphp
			@foreach($datalist as $row)
			@php
			$sub_total = $row->total_amount;
			$tax = $row->tax;
			$shipping_fee = $row->shipping_fee;
			
			$total_amount = $row->total_amount + $row->tax + $row->shipping_fee;
			
			@endphp
			<tr>
				<td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}" class="tp-checkbox selected_item" type="checkbox"></td>
				<td class="text-left"><a href="{{ route('backend.order', [$row->id]) }}">{{ $row->order_no }}</a></td>
				<td class="text-left">{{ date('d-m-Y', strtotime($row->created_at)) }}</td>

				@if ($row->customer_id != '')
				<td class="text-left">{{ $row->name }}</td>
				@else
				<td class="text-left">{{ __('Guest User') }}</td>
				@endif
				
				<td class="text-left">{{ $row->shop_name }}</td>
				
				@if($gtext['currency_position'] == 'left')
				<td class="text-center">{{ $gtext['currency_icon'] }}{{ NumberFormat($sub_total) }}</td>
				@else
				<td class="text-center">{{ NumberFormat($sub_total) }}{{ $gtext['currency_icon'] }}</td>
				@endif
				
				@if($gtext['currency_position'] == 'left')
				<td class="text-center">{{ $gtext['currency_icon'] }}{{ NumberFormat($tax) }}</td>
				@else
				<td class="text-center">{{ NumberFormat($tax) }}{{ $gtext['currency_icon'] }}</td>
				@endif
				
				@if($gtext['currency_position'] == 'left')
				<td class="text-center">{{ $gtext['currency_icon'] }}{{ NumberFormat($shipping_fee) }}</td>
				@else
				<td class="text-center">{{ NumberFormat($shipping_fee) }}{{ $gtext['currency_icon'] }}</td>
				@endif
				
				@if($gtext['currency_position'] == 'left')
				<td class="text-center">{{ $gtext['currency_icon'] }}{{ NumberFormat($total_amount) }}</td>
				@else
				<td class="text-center">{{ NumberFormat($total_amount) }}{{ $gtext['currency_icon'] }}</td>
				@endif
				
				<td class="text-center">{{ $row->method_name }}</td>
				<td class="text-center"><span class="status_btn pstatus_{{ $row->payment_status_id }}">{{ $row->pstatus_name }}</span></td>
				<td class="text-center"><span class="status_btn ostatus_{{ $row->order_status_id }}">{{ $row->ostatus_name }}</span></td>
				
				<td class="text-center">
					<div class="btn-group action-group">
						<a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{ route('backend.order', [$row->id]) }}">{{ __('View') }}</a>
							<a class="dropdown-item" href="{{ route('frontend.order-invoice', [$row->id, $row->order_no]) }}">{{ __('Invoice') }}</a>
							<a onclick="onDelete({{ $row->id }})" class="dropdown-item" href="javascript:void(0);">{{ __('Delete') }}</a>
						</div>
					</div>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td class="text-center" colspan="13">{{ __('No data available') }}</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
<div class="row mt-15">
	<div class="col-lg-12">
		{{ $datalist->links() }}
	</div>
</div>