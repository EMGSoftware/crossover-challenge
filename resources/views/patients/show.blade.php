@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<span class="title">
                		Patient Details
                	</span>
                </div>
                <div class="panel-body">
                    <div class="row">
						<div class="col-sm-12 form-group">
							{{ Form::label('name', 'Name:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::text('name', $value = $patient->name, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 form-group">
							{{ Form::label('email', 'E-mail:', $attibutes = ['class' => 'control-label']) }}
							{{ Form::email('email', $value = $patient->email, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
						</div>
					</div>
					<div class="well well-sm">
						<a class="btn btn-primary" href="{{ route('patients.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
