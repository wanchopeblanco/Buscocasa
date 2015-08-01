@extends('layouts.master')

@section('head')
    <title>{{ trans('admin.messages') }} - {{ Settings::get('site_name') }}</title>
@endsection

@section('css')
	@parent
	<style type="text/css">
		.read{
			max-height: 95px;
		}
	</style>
@endsection

@section('content')

<div class="uk-container uk-container-center uk-margin-top">
	<div class="uk-panel">
		<h1>{{ trans('admin.messages') }}</h1>

		@if(isset($listing))
			<h3 class="uk-margin-remove"><i class="uk-text-primary">{{ $listing->title }}</i></h3>
		@endif

		<hr>
	    <div class="">
	        
	    </div>

		<div class="uk-panel uk-margin-top">
			@if(count($appointments) > 0)
				<!-- Order by -->
				<div class="uk-text-right">
					<form action="{{url(Request::path())}}" method="GET" class="uk-form">
					    <select name="order_by" onchange="this.form.submit()">
					    	<option value="">Ordenar por</option>
					    	
					    	@if(Request::get('order_by') == 'id_desc')
					    		<option value="id_desc" selected>Recientes primero</option>
					    	@else
					    		<option value="id_desc">Recientes primero</option>
					    	@endif

					    	@if(Request::get('order_by') == 'id_asc')
					    		<option value="id_asc" selected>Antiguos primero</option>
					    	@else
					    		<option value="id_asc">Antiguos primero</option>
					    	@endif
					    </select>
					</form>
				</div>
				<!-- Order by -->

				<table class="uk-table uk-table-hover uk-table-striped" id="table">
		            <tbody>
		                @foreach($appointments as $appointment)
		                    <tr id="message-{{ $appointment->id }}">
		                        <td style="width:100px"><img src="{{ asset($appointment->listing->image_path()) }}" style="width:100px"></td>
		                        <td style="width:20%"><b class="uk-h4">{{ $appointment->name }}</b><br>{{ $appointment->phone }}</td>
		                        <td>{{ $appointment->email }}</td>
		                        <td>{{ $appointment->comments }}</td>
		                        <td style="width:140px" >
		                        	<div class="uk-flex" style="width:140px">
		                        		<!-- Reply button -->
		                        		@if(Auth::user()->confirmed)
					    					@if(!$appointment->answered)
						    					<button id="answer-{{$appointment->id}}" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-right" onclick="answerMessage({{ $appointment->id }})" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.reply') }}"><i class="uk-icon-reply"></i></button>
						    					<button id="mark-read-{{$appointment->id}}" class="uk-button uk-width-1-1 uk-margin-small-right" onclick="mark({{ $appointment->id }}, 1)" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.mark_as_answered') }}"><i class="uk-icon-check-square-o"></i></button>
						    				@else
						    					<button id="answer-{{$appointment->id}}" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-right" onclick="answerMessage({{ $appointment->id }})" disabled><i class="uk-icon-reply"></i></button>
						    					<button id="mark-read-{{$appointment->id}}" class="uk-button uk-width-1-1 uk-margin-small-right" onclick="mark({{ $appointment->id }}, 1)" disabled><i class="uk-icon-check-square-o"></i></button>
						    				@endif
						    			@else
						    				@if(!$appointment->answered)
						    					<a href="{{ url('admin/user/not_confirmed') }}" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-bottom"><i class="uk-icon-reply"></i></a>
						    					<button id="mark-read-{{$appointment->id}}" class="uk-button uk-width-1-1 uk-margin-small-right" onclick="mark({{ $appointment->id }}, 1)"><i class="uk-icon-check-square-o"></i></button>
						    				@else
						    					<button id="answer-{{$appointment->id}}" class="uk-button uk-button-success uk-width-1-1 uk-margin-small-right" onclick="answerMessage({{ $appointment->id }})" disabled><i class="uk-icon-reply"></i></button>
						    					<button id="mark-read-{{$appointment->id}}" class="uk-button uk-width-1-1 uk-margin-small-right" onclick="mark({{ $appointment->id }}, 1)" disabled><i class="uk-icon-check-square-o"></i></button>
						    				@endif
						    			@endif
						    			<!-- Reply button -->

		                            	<a class="uk-button uk-button-danger uk-width-1-1" onclick="deleteObject({{ $appointment->id }})" data-uk-tooltip="{pos:'top'}" title="{{ trans('admin.delete_message') }}"><i class="uk-icon-remove"></i></a>
		                        	</div>
		                        </td>
		                    </tr>
		              	@endforeach
		            </tbody>
				</table>

				<?php echo $appointments->render(); ?>
			@else
		    	<div class="uk-text-center uk-margin-top">
					<h2 style="color:#95979a" class="uk-text-bold">{{ trans('admin.you_have_no_messages') }}</h2>
					<h3>{{ trans('admin.no_messages_text') }}</h3>

					<div class="uk-grid uk-grid-collapse uk-text-center">
						<div class="uk-width-large-1-5">
							@if(isset($listing))
								<a href="{{ url($listing->pathEdit()) }}"><img src="{{ asset('/images/support/messages/consejo1.png') }}"></a>
							@else
								<img src="{{ asset('/images/support/messages/consejo1.png') }}">
							@endif
						</div>
						<div class="uk-width-large-1-5">
							@if(isset($listing))
								<a href="{{ url($listing->pathEdit().'#7') }}"><img src="{{ asset('/images/support/messages/consejo2.png') }}"></a>
							@else
								<img src="{{ asset('/images/support/messages/consejo2.png') }}">
							@endif
						</div>
						<div class="uk-width-large-1-5">
							@if(isset($listing))
								<a href="{{ url($listing->pathEdit().'#7') }}"><img src="{{ asset('/images/support/messages/consejo3.png') }}"></a>
							@else
								<img src="{{ asset('/images/support/messages/consejo3.png') }}">
							@endif
						</div>
						<div class="uk-width-large-1-5">
							@if(isset($listing))
								<a href="{{ url('/admin/destacar/'.$listing->id) }}"><img src="{{ asset('/images/support/messages/consejo4.png') }}"></a>
							@else
								<img src="{{ asset('/images/support/messages/consejo4.png') }}">
							@endif
						</div>
						<div class="uk-width-large-1-5">
							@if(isset($listing))
								<a href="{{ url('/admin/destacar/'.$listing->id) }}"><img src="{{ asset('/images/support/messages/consejo5.png') }}"></a>
							@else
								<img src="{{ asset('/images/support/messages/consejo5.png') }}">
							@endif
						</div>
					</div>
		    		
		    		<div class="uk-margin-large-top">
		    			<a href="{{ url('/admin/messages?deleted=true') }}">{{ trans('admin.show_deleted_messages') }}</a>
		    		</div>
		    	</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('js')
	<link href="{{ asset('/css/components/tooltip.almost-flat.min.css') }}" rel="stylesheet">
	@parent
	<script src="{{ asset('/js/components/tooltip.min.js') }}"></script>

	<script type="text/javascript">
	    function toggle(source){
	        checkboxes = document.getElementsByName('checkedLine');
	        for(var i=0, n=checkboxes.length;i<n;i++) {
	            checkboxes[i].checked = source.checked;
	        }
	    }

	    function answerMessage(objectID){
	    	UIkit.modal.prompt("{{ trans('admin.answer_message_prompt') }}", '', function(newvalue){
	    		$("#answer-"+objectID).prop('disabled', true);
			    $("#mark-read-"+objectID).prop('disabled', true);
			    // will be executed on submit.
			    $.post("{{ url('/admin/messages') }}/"+objectID+"/answer", {_token: "{{ csrf_token() }}", comments : newvalue}, function(result){
			    	if(result.success){
			    		$("#message-"+objectID).fadeOut(500, function(){ $('table').append( '<tr id="message-'+objectID+'">'+ $(this).html()+ '</tr>')});
			    	}else{
			    		$("#answer-"+objectID).prop('disabled', false);
			    		$("#mark-read-"+objectID).prop('disabled', false);
			    	}
		        });
			}, {row:5, labels:{Ok:'{{trans("admin.send")}}', Cancel:'{{trans("admin.cancel")}}'}});
	    }

	    function mark(objectID, read){
	    	$("#answer-"+objectID).prop('disabled', read);
			$("#mark-read-"+objectID).prop('disabled', read);   	
		    // will be executed on submit.
		    $.post("{{ url('/admin/messages') }}/"+objectID+"/mark", {_token: "{{ csrf_token() }}", mark : read}, function(result){
		    	if(result.success){
		        	$("#message-"+objectID).fadeOut(500, function(){ $('table').append( '<tr id="message-'+objectID+'">'+ $(this).html()+ '</tr>')});
				    $("#answer-"+objectID).prop('disabled', result.mark);
				    $("#mark-read-"+objectID).prop('disabled', result.mark);
				}else{
					if(read){
						$("#answer-"+objectID).prop('disabled', false);
				    	$("#mark-read-"+objectID).prop('disabled', false);
					}else{
						$("#answer-"+objectID).prop('disabled', true);
				    	$("#mark-read-"+objectID).prop('disabled', true);
					}
				}
	        });
	    }

	    function deleteObject(objectID) {
	    	UIkit.modal.confirm("{{ trans('admin.sure') }}", function(){
			    // will be executed on confirm.
			    $("#message-"+objectID).fadeOut(500, function(){ $(this).remove();});

		        $.post("{{ url('/admin/messages') }}/" + objectID, {_token: "{{ csrf_token() }}", _method:"DELETE"}, function(result){
		        	console.log(result);
		            //location.reload();
		        });
			}, {labels:{Ok:'{{trans("admin.yes")}}', Cancel:'{{trans("admin.cancel")}}'}});
	    	
	    }

	    // function deleteObjects() {
     //        var checkedValues = $('input[name="checkedLine"]:checked').map(function() {
     //            return this.value;
     //        }).get();
     //        $.post("{{ url('/admin/appointments/delete') }}", {_token: "{{ csrf_token() }}", ids: checkedValues}, function(result){
     //            location.reload();
     //        });
     //    }
	</script>
@endsection