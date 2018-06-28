@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	<span class="title">
                		Test Definition Details
                	</span>
                </div>
                <div class="panel-body">
                    <div class="row">
							<div class="col-sm-12 form-group">
								{{ Form::label('name', 'Name:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::text('name', $value = $test->name, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12 form-group">
								{{ Form::label('notes', 'Notes:', $attibutes = ['class' => 'control-label']) }}
								{{ Form::textarea('notes', $value = $test->notes, $attributes = ["class" => "form-control", "readonly" => "readonly"]) }}
							</div>
						</div>
						<div class="well well-sm">
							<a class="btn btn-primary" href="{{ route('tests_definitions.index') }}"><i class="glyphicon glyphicon-backward"></i> Back</a>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
