@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="title">
                        Operators
                    </span>
                    <span class="pull-right">{{ $operators->links() }}</span>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Operations</th>
                        </thead>
                        <tbody>
                        @forelse ($operators as $operator)
                            <tr>
                                <td>
                                    {{ $operator->name }}
                                </td>
                                <td>
                                    {{ $operator->email }}
                                </td>
                                <td class="col-md-3">
                                    <a class="btn btn-small btn-info" href="{{ url('operators/'. $operator->id) }}" title="View Details">
    									<i class="glyphicon glyphicon-eye-open"></i>
    								</a>
    								<a class="btn btn-small btn-warning" href="{{ url('operators/'.$operator->id.'/edit') }}" title="Edit Info">
    									<i class="glyphicon glyphicon-pencil"></i>
    								</a>
    								
    								<a class="btn btn-small btn-danger {{ ($operator->name == 'Admin' ? 'disabled' : '') }}" href="{{ url('operators/' . $operator->id) }}" title="Delete" data-method="delete" data-token="{{csrf_token()}}" data-confirm="Are you sure?">
    								    <i class="glyphicon glyphicon-trash"></i>
    								</a>
    								
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No operators found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
					<a class="btn btn-success pull-right" href="{{ route('operators.create') }}"><i class="glyphicon glyphicon-plus"></i> Add</a>
                </div>
                <div class="panel-footer"></div>
            </div>
        </div>
    </div>
</div>
@endsection
