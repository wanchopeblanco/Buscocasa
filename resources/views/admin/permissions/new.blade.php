<!-- This is the modal -->
<div id="create_permission_modal" class="uk-modal" data-focus-on="input:first">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <div class="uk-modal-header">
            Create New Permission
        </div>

        <form id="create_form" class="uk-form uk-form-horizontal" method="POST" action="/admin/permissions">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<input class="uk-width-large-10-10 uk-margin-small-bottom uk-form-large" type="text" name="name" placeholder="Name" value="{{ old('name') }}">

			<input class="uk-width-large-10-10 uk-margin-small-bottom uk-form-large" type="text" name="slug" placeholder="Slug" value="{{ old('slug') }}">

			<input class="uk-width-large-10-10 uk-margin-small-bottom uk-form-large" type="text" name="description" placeholder="Description" value="{{ old('description') }}">

			<input class="uk-width-large-10-10 uk-margin-small-bottom uk-form-large" type="text" name="model" placeholder="Model" value="{{ old('model') }}">
		</form>

		<div class="uk-modal-footer">
			<button form="create_form" type="submit" class="uk-button uk-button-primary">Save</button>
	        <a href="" class="uk-button uk-modal-close">Cancel</a>
	    </div>
	    
    </div>
</div>