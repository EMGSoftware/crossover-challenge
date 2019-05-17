<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;

class OperatorController extends Controller
{
	public function index()
	{
		if (!Auth::user()->is_patient)
		{
			$operators = User::orderBy('name', 'asc')->paginate(4);
			return view('operators.index', compact(['operators']));
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function create()
	{
		return view('operators.create');
	}

	public function store(Request $request)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			$input ['passcode'] = bcrypt ($input ['passcode']);
			$input ['is_patient'] = 0;
			User::create($input);
			return redirect()->route('operators.index');
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function show($id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($operator = User::find ($id))
			{
				return view('operators.show', compact(['operator']));
			}
			else
			{
				throw new Exception('Operator not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function edit($id)
	{
		if ($operator = User::find ($id))
		{
			return view('operators.edit', compact(['operator']));
		}
		else
		{
			throw new Exception('Operator not found');
		}
	}

	public function update(Request $request, $id)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			$operator = User::find ($id);
			if (!empty($input ['passcode'])) $operator->password = bcrypt ($input ['passcode']);
			$operator->update ($input);
			return redirect()->route('operators.index');
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function destroy($id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($operator = User::find($id))
			{
				// The special user Admin can't be deleted
				if ($operator->name != 'Admin')
				{
					$operator->delete();
					return redirect()->route('operators.index');
				}
				else
				{
					throw new Exception('Admin operator cannot be deleted');
				}
			}
			else
			{
				throw new Exception('Operator not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}
}
