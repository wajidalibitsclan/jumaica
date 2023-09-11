<div class="panel">
	<div class="panel-title"><strong>{{__('List Agent')}}</strong></div>
	<div class="panel-body">
		<div class="form-group-item">
			<div class="g-items-header">
				<div class="row">
					<div class="col-md-12">{{__("User")}}</div>
				</div>
			</div>
			<div class="g-items">
				@if (!empty($row->agent))
					@foreach($row->agent as $key => $item)
						<div class="item" data-number="{{ $key }}">
							<div class="row">
								<div class="col-md-11">
									{!! \App\Helpers\AdminForm::select('list_agent['.$key.']',\Themes\Findhouse\User\Models\User::getListUser($row->id), $item['id'] ?? '', 'dungdt-select2-field') !!}
								</div>
								<div class="col-md-1">
									<span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
								</div>
							</div>
						</div>
					@endforeach
				@endif
			</div>
			<div class="text-right">
				<span class="btn btn-info btn-sm btn-add-item"><i class="icon ion-ios-add-circle-outline"></i> {{__('Add item')}}</span>
			</div>
			<div class="g-more hide">
				<div class="item" data-number="__number__" >
					<div class="row">
						<div class="col-md-11">
							{!! \App\Helpers\AdminForm::select('list_agent[__number__]',\Themes\Findhouse\User\Models\User::getListUser(),'','dungdt-select2-field-lazy',true) !!}
						</div>
						<div class="col-md-1">
							<span class="btn btn-danger btn-sm btn-remove-item"><i class="fa fa-trash"></i></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
