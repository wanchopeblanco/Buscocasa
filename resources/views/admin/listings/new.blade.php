@extends('layouts.master')

@section('head')
    <title>{{ trans('admin.new_listing') }} - {{ Settings::get('site_name') }}</title>
@endsection

@section('css')
	@parent
@endsection

@section('content')

<div class="uk-container uk-container-center uk-margin-top">
	<div class="uk-panel">
		<h1>{{ trans('admin.new_listing') }}</h1>

	    <hr>
	    
	    <div class="uk-panel">
			<button class="uk-button uk-button-large uk-float-right uk-margin-left uk-width-small-1-1 uk-width-medium-2-10 uk-width-large-1-10" onclick="leave()">{{ trans('admin.close') }}</button>
	        <button form="create_form" type="submit" class="uk-button uk-button-large uk-button-success uk-float-right uk-width-small-1-1 uk-width-medium-3-10 uk-width-large-2-10" onclick="blockUI()">{{ trans('admin.save') }}</button>
	    </div>

		<form id="create_form" class="uk-form uk-form-stacked" method="POST" action="{{ url('/admin/listings') }}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input id="latitude" type="hidden" name="latitude" placeholder="Latitude" value="{{ old('latitude') }}">
	        <input id="longitude" type="hidden" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}">

			<div class="uk-grid uk-margin-top">

				<!-- Left column navbar -->
				<div class="uk-width-large-1-10 uk-width-medium-1-10">
					<ul class="uk-list uk-hidden-small" data-uk-sticky="{boundary: true}">
					    <li data-uk-tooltip="{pos:'left'}" title="{{ trans('admin.steps_1') }}">
					    	<a href="#1" data-uk-smooth-scroll="{offset: 0}"><img src="{{ asset('/images/support/listings/steps/columna/1.png') }}"></a>
					    </li>
					    <li style="margin-top:-20px" data-uk-tooltip="{pos:'left'}" title="{{ trans('admin.steps_2') }}">
					    	<a href="#3" data-uk-smooth-scroll="{offset: 0}"><img src="{{ asset('/images/support/listings/steps/columna/2.png') }}"></a>
					    </li>
					    <li style="margin-top:-20px" data-uk-tooltip="{pos:'left'}" title="{{ trans('admin.steps_3') }}">
					    	<a href="#4" data-uk-smooth-scroll="{offset: 0}"><img src="{{ asset('/images/support/listings/steps/columna/3.png') }}"></a>
					    </li>
					    <li style="margin-top:-20px" data-uk-tooltip="{pos:'left'}" title="{{ trans('admin.steps_4') }}">
					    	<a href="#5" data-uk-smooth-scroll="{offset: 0}"><img src="{{ asset('/images/support/listings/steps/columna/4.png') }}"></a>
					    </li>
					</ul>
				</div>
				<!-- Left column navbar -->

				<!-- Categoria - tipo de publicacion - ubicacion -->
				<div class="uk-width-large-9-10 uk-width-medium-9-10" id="1">
					<div class="uk-panel">
						<h2 class="uk-display-inline uk-text-primary uk-text-bold uk-float-left" style="text-transform: uppercase">{{ trans('admin.listing_data_location') }}</h2>
						<h2 class="uk-display-inline uk-float-right uk-padding-remove uk-margin-remove"><i id="points_main">0</i>/50</h2>
					</div>
					<div class="uk-grid">
						<div class="uk-width-large-1-2">
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.category') }} <i class="uk-text-danger">*</i></label>
						        <div class="uk-form-controls">
						        	<select class="uk-width-large-10-10 uk-form-large" id="category" name="category_id" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.category_tooltip') }}" onchange="calculatePoints('main')">
						                @foreach($categories as $category)
						                	@if(old('category_id') == $category->id)
												<option value="{{ $category->id }}" selected>{{ str_singular($category->name) }}</option>
						                	@else
						                		<option value="{{ $category->id }}">{{ str_singular($category->name) }}</option>
						                	@endif				                	
						                @endforeach
						            </select>
						        </div>
						    </div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.city') }} <i class="uk-text-danger">*</i></label>
						        <div class="uk-form-controls">
						        	<select class="uk-width-large-10-10 uk-form-large" id="city" type="text" name="city_id" onchange="calculatePoints('main')">	
						                @foreach($cities as $city)
						                	@if(old('city_id') == $city->id)
												<option value="{{ $city->id }}" selected>{{ $city->name }} ({{ $city->department->name }})</option>
						                	@else
						                		<option value="{{ $city->id }}">{{ $city->name }} ({{ $city->department->name }})</option>
						                	@endif	
						                @endforeach
					            	</select>
						        </div>
						    </div>

						    <div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.district') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="district" value="{{ old('district') }}" placeholder="{{ trans('admin.district') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.district_tooltip') }}" onchange="calculatePoints('main')">
						    </div>
						</div>

						<div class="uk-width-large-1-2">
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.listing_type') }} <i class="uk-text-danger">*</i></label>
						        <div class="uk-form-controls">
						        	<select class="uk-width-large-10-10 uk-form-large" id="listing_type" name="listing_type" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.listing_type_tooltip') }}" onchange="calculatePoints('main')">
						                @foreach($listingTypes as $listingType)
						                	@if(old('listing_type') == $listingType->id)
												<option value="{{ $listingType->id }}" selected>{{ $listingType->name }}</option>
						                	@else
						                		<option value="{{ $listingType->id }}">{{ $listingType->name }}</option>
						                	@endif	
						                @endforeach
						            </select>
						        </div>
						    </div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.address') }} <i class="uk-text-danger">*</i></label>
								<input class="uk-width-large-10-10 uk-form-large" id="direction" type="text" name="direction" placeholder="{{ trans('admin.address') }}" value="{{ old('direction') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.direction_tooltip') }}" onchange="calculatePoints('main')">
							</div>
						</div>
					</div>
					<!-- Categoria - tipo de publicacion - ubicacion -->


					<!-- Mapa -->
					<div class="uk-margin uk-width-1-1" id="2">
						<p class="uk-text-primary uk-text-bold">{{ trans('admin.select_map_location') }}</p>
						<input class="uk-width-large-5-10 uk-form-large uk-margin-bottom" id="gmap_search" type="text" placeholder="{{ trans('admin.gmap_search') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.gmap_search_tooltip') }}" style="background-color:#fafafa">
						<?php echo $map['html']; ?>
					</div>
					<!-- Mapa -->

					<hr>

					<div class="uk-grid uk-margin-top-remove" id="3">
						<!-- Informacion basica del inmueble -->
						<div class="uk-panel uk-width-1-1 uk-margin-bottom">
							<h2 class="uk-display-inline uk-text-primary uk-text-bold uk-float-left uk-padding-remove uk-margin-remove" style="text-transform: uppercase">{{ trans('admin.listing_basic_information') }}</h2>
							<h2 class="uk-display-inline uk-float-right uk-padding-remove uk-margin-remove"><i id="points_basics">0</i>/150</h2>
						</div>

						<div class="uk-width-large-1-3 uk-width-1-2">
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.price') }} <i class="uk-text-danger">*</i></label>
								<input class="uk-width-large-10-10 uk-form-large" id="price" type="text" name="price" placeholder="{{ trans('admin.price') }}" value="{{ old('price') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.price_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.stratum') }} <i class="uk-text-danger">*</i></label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="stratum" placeholder="{{ trans('admin.stratum') }}" value="{{ old('stratum') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.area') }} <i class="uk-text-danger">*</i></label>
								<input class="uk-width-large-10-10 uk-form-large" id="area" type="text" name="area" placeholder="{{ trans('admin.area') }}" value="{{ old('area') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.area_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.lot_area') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" id="lot_area" type="text" name="lot_area" placeholder="{{ trans('admin.lot_area') }}" value="{{ old('lot_area') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.lot_area_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>
						</div>

						<div class="uk-width-large-1-3 uk-width-1-2">
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.rooms') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="rooms" placeholder="{{ trans('admin.rooms') }}" value="{{ old('rooms') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.bathrooms') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="bathrooms" placeholder="{{ trans('admin.bathrooms') }}" value="{{ old('bathrooms') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.garages') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="garages" placeholder="{{ trans('admin.garages') }}" value="{{ old('garages') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>
						</div>

						<div class="uk-width-large-1-3 uk-width-1-2">
							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.floor') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="floor" placeholder="{{ trans('admin.floor') }}" value="{{ old('floor') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.floor_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.construction_year') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" type="text" name="construction_year" placeholder="{{ trans('admin.construction_year') }}" value="{{ old('construction_year') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.construction_year_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>

							<div class="uk-form-row">
						        <label class="uk-form-label" for="">{{ trans('admin.administration_fees') }}</label>
								<input class="uk-width-large-10-10 uk-form-large" id="administration" type="text" name="administration" placeholder="{{ trans('admin.administration_fees') }}" value="{{ old('administration') }}" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.administration_fees_tooltip') }}" onkeyup="format(this);" onchange="calculatePoints('basics')">
							</div>
						</div>
					</div>
					<!-- Informacion basica del inmueble -->

					<hr>

					<!-- Caracteristicas del inmueble -->
					<div id="4">
						<div class="uk-panel">
							<h2 class="uk-display-inline uk-text-primary uk-text-bold uk-float-left" style="text-transform: uppercase">{{ trans('admin.listing_caracteristics') }}</h2>
							<h2 class="uk-display-inline uk-float-right uk-padding-remove uk-margin-remove"><i id="points_caracteristics">0</i>/150</h2>
						</div>

						<h3>{{ trans('admin.interior') }}</h3>
						<div class="uk-grid">
							@foreach($features as $feature)
								@if($feature->category->id == 1)
									<div class="uk-width-large-1-3 uk-width-1-2">
										@if( old($feature->id) )
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}" checked> {{ $feature->name }}</label>
										@else
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}"> {{ $feature->name }}</label>
										@endif
									</div>
								@endif
							@endforeach
						</div>

						<h3>{{ trans('admin.exterior') }}</h3>
						<div class="uk-grid">
							@foreach($features as $feature)
								@if($feature->category->id == 2)
									<div class="uk-width-large-1-3 uk-width-1-2">
										@if( old($feature->id) )
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}" checked> {{ $feature->name }}</label>
										@else
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}"> {{ $feature->name }}</label>
										@endif
									</div>
								@endif
							@endforeach
						</div>

						<h3>{{ trans('admin.sector') }}</h3>
						<div class="uk-grid">
							@foreach($features as $feature)
								@if($feature->category->id == 3)
									<div class="uk-width-large-1-3 uk-width-1-2">
										@if( old($feature->id) )
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}" checked> {{ $feature->name }}</label>
										@else
											<label><input type="checkbox" onchange="calculatePoints('caracteristics')" name="{{ $feature->id }}"> {{ $feature->name }}</label>
										@endif
									</div>
								@endif
							@endforeach
						</div>
					</div>
					<!-- Caracteristicas del inmueble -->

					<hr>

					<!-- Informacion adicional -->
					<div id="5">
						<div class="uk-panel">
							<h2 class="uk-display-inline uk-text-primary uk-text-bold uk-float-left" style="text-transform: uppercase">{{ trans('admin.listing_description') }}</h2>
							<h2 class="uk-display-inline uk-float-right uk-padding-remove uk-margin-remove"><i id="points_aditional">0</i>/150</h2>
						</div>
						<p class="uk-margin-top-remove">{{ trans('admin.listing_description_help') }}</p>
						<textarea class="uk-width-large-10-10 uk-margin-small-bottom" id="description" rows="5" name="description" maxlength="2000" onkeyup="calculatePoints('description')">{{ old('description') }}</textarea>
					</div>
					<!-- Informacion adicional -->

					<hr>

					<!-- Images -->
					<div>
						<h2 class="uk-text-primary uk-text-bold" style="text-transform: uppercase">{{ trans('admin.images') }}</h2>
						<h3>{{ trans('admin.images_notice') }}</h3>
					</div>
					<!-- Images -->

					<div class="uk-margin-top">
				        <button form="create_form" type="submit" class="uk-button uk-width-1-1 uk-button-large uk-button-success uk-text-bold" onclick="blockUI()">{{ trans('admin.save') }}</button>
				    </div>
			    </div>
			</div>
		</form>

	</div>
</div>

<!-- Email confirmation message sent modal -->
@if(Session::get('new_user'))
	<div id="confirmation_email_modal" class="uk-modal">
	    <div class="uk-modal-dialog">
	        <a href="" class="uk-modal-close uk-close uk-close-alt"></a>
	        <div class="uk-modal-header uk-text-bold">
	        	{{ trans('admin.confirm_email') }}
	        </div>

	        <div class="uk-text-center">
	        	<img src="{{ asset('images/support/user/welcome.png') }}" style="width:80%">

	        	<h3>{{ trans('admin.welcome_new_user') }}</h3>

	        	<a class="uk-button uk-button-large uk-button-success" id="open" href="" target="_blank">{{ trans('admin.open') }}</a>
	        </div>
	    </div>
	</div>
@endif
<!-- Email confirmation message sent modal -->

@endsection

@section('js')
	@parent

	<!-- CSS -->
	<link href="{{ asset('/css/components/form-file.almost-flat.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/components/tooltip.almost-flat.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/components/sticky.almost-flat.min.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" />
	<!-- CSS -->

	<!-- JS -->
    <script src="{{ asset('/js/components/tooltip.min.js') }}"></script>
    <script src="{{ asset('/js/components/sticky.min.js') }}"></script>
	<script src="{{ asset('/js/accounting.min.js') }}"></script>
	<script src="{{ asset('/js/select2.min.js') }}"></script>
	<!-- JS -->

	<script type="text/javascript">
		$(document).ready(function() {
			calculatePoints();

		  	$("#city").select2();

		  	$("#open").html('{{ trans('admin.open') }}'+' '+emailProvider('{{ Auth::user()->email }}'));
		  	$("#open").attr("href", "http://"+emailProvider('{{ Auth::user()->email }}'));

			@if(Session::pull('new_user'))
			  	var modal = UIkit.modal("#confirmation_email_modal");
				modal.show()
			@endif
		});

		function calculatePoints(sender){
			console.log(sender);
			if(sender == 'main' || !sender){
				var $main = $("#points_main");
				var mainPoints = 0;
				var number = 5;

				if($('select[name="category_id"]').val() && $('select[name="category_id"]').val() != ''){
					mainPoints += 50/number;
				}
				if($('select[name="listing_type"]').val() && $('select[name="listing_type"]').val() != ''){
					mainPoints += 50/number;
				}
				if($('select[name="city_id"]').val() && $('select[name="city_id"]').val() != ''){
					mainPoints += 50/number;
				}
				if($('input[name="direction"]').val() && $('input[name="direction"]').val() != ''){
					mainPoints += 50/number;
				}
				if($('input[name="district"]').val() && $('input[name="district"]').val() != ''){
					mainPoints += 50/number;
				}

				$({someValue: $main.html()}).animate({someValue: mainPoints}, {
				    duration: 500,
				    easing:'swing', // can be anything
				    step: function() { // called on every step
				        // Update the element's text with rounded-up value:
				        $main.text(Math.round(this.someValue));
				    }
				});
			}

			if(sender == 'basics' || !sender){
				var $basics = $("#points_basics");
				var basicsPoints = 0;
				var number = $('#3').find('input').length;
				if($('input[name="price"]').val() || $('input[name="price"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="stratum"]').val() && $('input[name="stratum"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="area"]').val() && $('input[name="area"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="lot_area"]').val() && $('input[name="lot_area"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="rooms"]').val() && $('input[name="rooms"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="bathrooms"]').val() && $('input[name="bathrooms"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="garages"]').val() && $('input[name="garages"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="floor"]').val() && $('input[name="floor"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="construction_year"]').val() && $('input[name="construction_year"]').val() != ''){
					basicsPoints += 150/number;
				}
				if($('input[name="administration"]').val() && $('input[name="administration"]').val() != ''){
					basicsPoints += 150/number;
				}

				$({someValue: $basics.html()}).animate({someValue: basicsPoints}, {
				    duration: 500,
				    easing:'swing', // can be anything
				    step: function() { // called on every step
				        // Update the element's text with rounded-up value:
				        $basics.text(Math.round(this.someValue));
				    }
				});
			}

			if(sender == 'caracteristics' || !sender){
				var $caracteristics = $("#points_caracteristics");
				caracteristicsPoints = ($('#4').find('input[type="checkbox"]:checked').length/($('#4').find('input[type="checkbox"]').length*0.5))*150;
				if(caracteristicsPoints > 150){
					caracteristicsPoints = 150;
				}
				$({someValue: $caracteristics.html()}).animate({someValue: caracteristicsPoints}, {
				    duration: 500,
				    easing:'swing', // can be anything
				    step: function() { // called on every step
				        // Update the element's text with rounded-up value:
				        $caracteristics.text(Math.round(this.someValue));
				    }
				});
			}

			if(sender == 'description' || !sender){
				var $el = $("#points_aditional");
				string = $("#description").val();
				aditionalPoints = 0;
				if(string){
					aditionalPoints = (string.length/1000)*150;
				}
				if(aditionalPoints > 150){
					aditionalPoints = 150;
				}
				$({someValue: $el.html()}).animate({someValue: aditionalPoints}, {
				    duration: 500,
				    easing:'swing', // can be anything
				    step: function() { // called on every step
				        // Update the element's text with rounded-up value:
				        $el.text(Math.round(this.someValue));
				    }
				});
			}
		}

		function blockUI(){
	        var modal = UIkit.modal.blockUI('<h3 class="uk-text-center">Guardando inmueble, porfavor espere.</h3><div class="uk-text-center uk-text-primary"><i class="uk-icon-large uk-icon-spinner uk-icon-spin"</i></div>', {center: true});
	    }

	    function leave() {
	    	UIkit.modal.confirm("{{ trans('admin.sure_leave') }}", function(){
			    window.location.replace("{{ url('/admin/listings') }}");
			}, {labels:{Ok:'{{trans("admin.yes")}}', Cancel:'{{trans("admin.cancel")}}'}, center: true});
	    }

		function format(field){
	        field.value = accounting.formatNumber(field.value);
	    }

	    function emailProvider(str){
	    	var afterComma = str.substr(str.indexOf("@") + 1);
	    	return afterComma;
	    }
	</script>

	<!-- Google maps js -->
	<script type="text/javascript">var centreGot = false;</script>
	<?php echo $map['js']; ?>
	<!-- Google maps js -->
@endsection