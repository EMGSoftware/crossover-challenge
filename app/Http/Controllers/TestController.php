<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Test;
use Auth;

class TestController extends Controller
{
	public function index()
	{
		if (!Auth::user()->is_patient)
		{
			$tests = Test::orderBy('created_at', 'asc')->paginate(4);
			return view('tests.index', compact(['tests']));
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function create()
	{
		return view('tests.create');
	}

	public function store(Request $request)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			Test::create($input);
			return redirect()->route('tests_definitions.index');
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
			if ($test = Test::find($id))
			{
				return view('tests.show', compact(['test']));
			}
			else
			{
				throw new Exception('Test Definition not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function edit($id)
	{
		$test = Test::find($id);
		return view('tests.edit', compact (['test']));
	}

	public function update(Request $request, $id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($test = Test::find($id))
			{
				$input = $request->all();
				if (!isset ($input ['enabled'])) $input ['enabled'] = 0;
				$test->update ($input);
				return redirect()->route('tests_definitions.index');
			}
			else
			{
				throw new Exception('Test Definition not found');
			}
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
			if ($test = Test::find($id))
			{
				$test->delete();
				return redirect()->route('tests_definitions.index');
			}
			else
			{
				throw new Exception('Test not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}
}
