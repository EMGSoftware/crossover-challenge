<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;

class PatientController extends Controller
{
	public function index()
	{
		if (!Auth::user()->is_patient)
		{
			// Get just the patients
			$patients = User::where('is_patient', 1)->paginate(4);
			return view('patients.index', compact(['patients']));
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function create()
	{
		return view('patients.create');
	}

	public function store(Request $request)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			$input ['passcode'] = bcrypt ($input ['passcode']);
			$input ['is_patient'] = 1;
			User::create($input);
			return redirect()->route('patients.index');
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($patient = User::find ($id))
			{
				return view('patients.show', compact(['patient']));
			}
			else
			{
				throw new Exception('Patient not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function edit($id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($patient = User::find ($id))
			{
				return view('patients.edit', compact(['patient']));
			}
			else
			{
				throw new Exception('Patient not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function update(Request $request, $id)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			$patient = User::find ($id);
			if (!empty($input ['passcode'])) $patient->password = bcrypt ($input ['passcode']);
			$patient->update ($input);
			return redirect()->route('patients.index');
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
			if ($patient = User::find($id))
			{
				$patient->delete();
				return redirect()->route('patients.index');
			}
			else
			{
				throw new Exception('Patient not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}
}
