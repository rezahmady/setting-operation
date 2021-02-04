@if ($crud->hasAccess('setting'))
	<a href="{{ url($crud->route.'/setting') }}" class="btn btn-secondary" data-style="zoom-in"><span class="ladda-label"><i class="la la-cog"></i> {{trans('backpack::setting-operation.crud_button')}}</span></a>
@endif