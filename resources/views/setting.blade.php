@extends(backpack_view('blank'))

@php
	$defaultBreadcrumbs = [
	trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
	$crud->entity_name_plural => url($crud->route),
	trans('setting-operation::setting-operation.settings') => false,
	];

	$settings = $crud->model->where('key', $entry)->first();
	$fields = json_decode($settings->fields);

	$newFields = $crud->fields();

	// set fields value
	foreach ($crud->fields() as $key => $value) {
		
		if(isset($fields->{$key})) $newFields[$key]['value'] = $fields->{$key};

		$crud->modifyField($key, $newFields[$key]);
	}

	// if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
	$breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</span>
        <small>{!! $crud->getSubheading() ?? trans('setting-operation::setting-operation.settings') !!}.</small>

        @if ($crud->hasAccess('setting'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')

<div class="row">
	<div class="{{ $crud->get('setting.settingContentClass') ?? 'col-md-12' }}">
		<!-- Default box -->

		@include('crud::inc.grouped_errors')

		  <form method="post"
		  		action="{{ url($crud->route.'/setting/'.$entry) }}"
				@if ($crud->hasUploadFields('create'))
				enctype="multipart/form-data"
				@endif
		  		>
			  {!! csrf_field() !!}
			  {!! method_field('PUT') !!}
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content', [ 'fields' => $newFields, 'action' => 'edit' ])
		      @else
		      	@include('crud::form_content', [ 'fields' => $newFields, 'action' => 'edit' ])
		      @endif

			<div id="saveActions" class="form-group">

				<button type="submit" class="btn btn-success">
					<span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
					<span > {{ trans('setting-operation::setting-operation.save_action') }}</span>
				</button>

				@if(!$crud->hasOperationSetting('showCancelButton') || $crud->getOperationSetting('showCancelButton') == true)
					<a href="{{ $crud->hasAccess('setting') ? url($crud->route) : url()->previous() }}" class="btn btn-default"><span class="la la-ban"></span> &nbsp;{{ trans('backpack::crud.cancel') }}</a>
				@endif
				
			</div>
			
		  </form>
	</div>
</div>

@endsection

