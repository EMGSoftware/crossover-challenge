@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			{{ Form::open(['url' => 'tests', 'data-toggle' => 'validator', 'class' => 'form', 'id' => 'form']) }}
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="title">
						Add a Test Definition
					</span>
					<span class="pull-right">
						{{ Form::label('enabled', 'Enabled:', $attibutes = ['class' => 'control-label']) }}&nbsp;
						{{ Form::checkbox('enabled', 1, false) }}
					</span>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12 form-group">
							{{ Form::label('name', 'Name:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::text('name', $value = null, $attributes = ["class" => "form-control", "required" => "required", "data-error" => "This field is mandatory"]) }}
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							{{ Form::label('notes', 'Notes:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::textarea('notes', $value = null, $attributes = ["class" => "form-control", "required" => "required", "data-error" => "This field is mandatory"]) }}
							<span class="help-block with-errors"></span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							
						</div>
					</div>
					<div class="well well-sm">
						<a class="btn btn-primary" href="{{ route('tests_definitions.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
						<button type="submit" class="btn btn-success pull-right"><i class="glyphicon glyphicon-check"></i> Save</button>
					</div>
				</div>
			</div>
			{{ Form::close() }}
		</div>
	</div>
</div>
@endsection
