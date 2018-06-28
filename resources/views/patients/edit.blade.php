@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					<span class="title">
						Edit Patient Info
					</span>
				</div>
				<div class="panel-body">
					{{ Form::model($patient, ['route' => ['patients.update', $patient->id], 'method' => 'PATCH', 'id' => 'form', 'data-toggle' => 'validator', 'role' => 'form', 'class' => 'form']) }}
						<div class="row">
							<div class="col-sm-12 form-group">
								{{ Form::label('name', 'Name:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::text('name', $value = null, $attributes = ["class" => "form-control", "required" => "required", "data-error" => "This field is mandatory"]) }}
								<span class="help-block with-errors"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 form-group">
								{{ Form::label('email', 'E-mail:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::email('email', $value = null, $attributes = ["class" => "form-control", "required" => "required", "data-error" => "This field is mandatory. Please input a valid e-mail"]) }}
								<span class="help-block with-errors"></span>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 form-group">
								{{ Form::label('passcode', 'Pass code:', $attibutes = ['class' => 'control-label']) }}
								<div class="input-group">
									{{ Form::text('passcode', $value = null, $attributes = ["class" => "form-control", "id" => "passcode", "placeholder" => "If you want to keep the current pass code, leave this field empty"]) }}
									<span class="input-group-btn">
										<button class="btn btn-primary" type="button" id="generate_passcode_button">Generate new code</button>
									</span>
								</div>
								<span class="help-block with-errors"></span>
							</div>
						</div>
						<div class="well well-sm">
							<a class="btn btn-primary" href="{{ route('patients.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
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
	$("#generate_passcode_button").on ("click", function () { $("#passcode").val (Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 15)); });
	
	$('#form').submit(function()
	{
		if ($("#passcode").val().length > 0)
			copyText ($("#passcode"));
	});
	
	function copyText (copyTextarea)
	{
		copyTextarea.select();
		try
		{
			document.execCommand('copy');
			alert ("The pass code was copied to the clipboard");
		}
		catch (e) {
		}
	}
</script>
@stop
