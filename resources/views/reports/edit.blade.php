@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="title">
						Edit Report
					</span>
				</div>
				<div class="panel-body">
					{{ Form::model($report, ['route' => ['reports.update', $report->id], 'method' => 'PATCH', 'data-toggle' => 'validator', 'role' => 'form', 'class' => 'form']) }}
						<input type="hidden" id="hdn_items_tests" name="hdn_items_tests"/>
						<div class="row">
							<div class="col-sm-3 form-group">
								{{ Form::label('patients', 'Patient:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::select('patients', $patients, $report->patient_id, $attributes = ["id" => "patients", "class" => "selectpicker show-menu-arrow form-control", "data-live-search" => "true", "data-size" => "4", "required" => "required", "data-error" => "This field is mandatory"]) }}
								<span class="help-block with-errors"></span>
							</div>
							<div class="col-sm-9 form-group">
								{{ Form::label('notes', 'Notes:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::textarea('notes', $value = null, $attributes = ["class" => "form-control", "rows" => "3"]) }}
							</div>
						</div>
						<hr/>
						<div class="row">
							<div class="col-sm-3 form-group">
								{{ Form::label('tests', 'Tests:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::select('tests', $tests, null, $attributes = ["id" => "tests", "class" => "selectpicker show-menu-arrow form-control", "data-live-search" => "true", "data-size" => "4"]) }}
								<span class="help-block with-errors"></span>
							</div>
							<div class="col-sm-3 form-group">
								{{ Form::label('result', 'Result:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::text('result', $value = null, $attributes = ["class" => "form-control"]) }}
							</div>
							<div class="col-sm-3 form-group">
								<a class="btn btn-success btn-big btn-add" id="add_test_button"><i class="glyphicon glyphicon-plus"></i></a>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
			                    <table class="table table-bordered table-striped table-sm">
			                        <tbody id="items_tests">
			                        </tbody>
			                    </table>
		                    </div>
						</div>
						<div class="well well-sm">
							<a class="btn btn-primary" href="{{ route('reports.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
							<button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-check"></i> Save</button>
						</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page-js-script')
<script type="text/javascript">
	<?php 
    foreach ($report->tests as $item) 
    { ?>
        add_manual_item ($('#tests'), $('#items_tests'), {{ $item->id }}, '{{ $item->name }}', '{{ $item->pivot->result }}');
    <?php 
    } ?>
	
	$("#add_test_button").on ("click", function () { add_item ($('#tests'), $('#items_tests'), $('#result').val()); $('#result').val(""); });
</script>
@stop
