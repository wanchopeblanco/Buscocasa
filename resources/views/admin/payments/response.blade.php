@extends('layouts.master')

@section('head')
    <title>{{ trans('admin.transaction_result') }} - {{ Settings::get('site_name') }}</title>
@endsection

@section('css')
	@parent
@endsection

@section('content')

<div class="uk-container uk-container-center uk-margin-top">
	<div class="uk-panel">
		<h1>{{ trans('admin.transaction_result') }}</h1>

	    <div class="uk-grid">
			
		    <div class="uk-width-2-3">

		    	@if(Request::get('transactionState') == 4)
			    	<img src="{{ asset('/images/support/payments/payment_succeeded.png') }}" style="width:40%;" class="uk-align-center">
			    	<h3 class="uk-margin-remove">{{ trans('admin.payment_response_success_text') }}</h3>

					<!-- Listing preview -->
			    	<a style="text-decoration:none">
						<div class="uk-panel uk-panel-box uk-panel-box-primary uk-margin-remove">
						<!-- Tags start -->
							<img src="{{asset($payment->featuredType->image_path)}}" style="position:absolute; top:0; left:0; max-width:150px">
						<!-- Tags end -->
							<img src="{{ asset(Image::url($listing->image_path(),['mini_image_2x'])) }}" style="width:350px; height:200px; float:left" class="uk-margin-right">
							<h4 class="uk-margin-remove">{{ $listing->title }}</h4>
							{{-- <p style="margin-top:-2px" class="uk-text-muted">{{ $listing->city->name .", ". $listing->direction }}</p> --}}
							<h4 style="margin-top:0px" class="uk-text-primary">${{ money_format('%!.0i', $listing->price) }}</h4>
							<ul style="list-style-type: none;margin-top:-5px" class="uk-text-muted uk-text-small">
								@if($listing->rooms)
								<li><i class="uk-icon-check"></i> {{ $listing->rooms }} {{ trans('admin.rooms') }}</li>
								@endif

								@if($listing->bathrooms)
								<li><i class="uk-icon-check"></i> {{ $listing->bathrooms }} {{ trans('admin.bathrooms') }}</li>
								@endif

								@if($listing->garages)
								<li><i class="uk-icon-check"></i> {{ $listing->garages }} {{ trans('admin.garages') }}</li>
								@endif

								@if($listing->stratum)
								<li><i class="uk-icon-check"></i> {{ trans('admin.stratum') }} {{ $listing->stratum }}</li>
								@endif

								@if($listing->area)
								<li><i class="uk-icon-check"></i> {{ number_format($listing->area, 0, ',', '.') }} mt2</li>
								@endif

								@if($listing->lot_area)
								<li id="lot_area"><i class="uk-icon-check"></i> {{ number_format($listing->lot_area, 0, ',', '.') }} {{ trans('frontend.lot_area') }}</li>
								@endif

								@if((int)$listing->administration != 0)
								<li><i class="uk-icon-check"></i> {{ money_format('$%!.0i', $listing->administration) }} {{ trans('admin.administration_fees') }}</li>
								@endif

							</ul>
						</div>
					</a>
					<!-- Listing preview -->
			    @else
			    	<img src="{{ asset('/images/support/payments/payment_succeeded.png') }}" style="width:40%;" class="uk-align-center">
			    	<h3 class="uk-margin-remove">{{ trans('admin.payment_response_error_text') }}</h3>
			    @endif
		    </div>

	    	<div class="uk-width-1-3">
			@if($signature == Request::get('signature'))
				<h2 class="uk-text-bold">{{ trans('admin.transaction_info') }}</h2>
				<table class="uk-table uk-table-striped uk-table-hover">
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_state') }}</td>
						<td>
							@if(Request::get('transactionState') == 4)
								<b class="uk-text-success uk-h3">{{ trans('admin.transaction_approved') }}</b>
							@elseif(Request::get('transactionState') == 6)
								<b class="uk-text-warning">"{{ trans('admin.transaction_denied') }}</b>
							@elseif(Request::get('transactionState') == 104)
								<b class="uk-text-danger">{{ trans('admin.transaction_error') }}</b>
							@elseif(Request::get('transactionState') == 7)
								<b class="uk-text-bold">{{ trans('admin.transaction_pending') }}</b>
							@else
								{{Request::get('mensaje')}}
							@endif
						</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_description') }}</td>
						<td>{{Request::get('description')}}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_id') }}</td>
						<td>{{Request::get('transactionId')}}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_sale_reference') }}</td>
						<td>{{Request::get('reference_pol')}}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_reference') }}</td>
						<td>{{Request::get('referenceCode')}}</td>
					</tr>
				@if(Request::get('pseBank')) {
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_cus') }}</td>
						<td>{{Request::get('cus')}}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_bank') }}</td>
						<td>{{Request::get('pseBank')}}</td>
					</tr>
				@endif
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_total') }}</td>
						<td>{{ money_format('$%!.1i', Request::get('TX_VALUE')) }}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_currency') }}</td>
						<td>{{Request::get('currency')}}</td>
					</tr>
					<tr>
						<td class="uk-text-bold">{{ trans('admin.transaction_entity') }}</td>
						<td>{{Request::get('lapPaymentMethod')}}</td>
					</tr>
				</table>
			@else
				<h3 class="uk-text-warning">{{ trans('admin.error_validating_signature') }}</h3>
			@endif
			</div>
	    </div>
	</div>
</div>
@endsection

@section('js')
	@parent
@endsection