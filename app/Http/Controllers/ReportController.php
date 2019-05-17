<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Report;
use Codedge\Fpdf\Fpdf\Fpdf;
use Exception;
use Auth;
use App\User;
use App\Test;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as phpmailerException;

class ReportController extends Controller
{
	public function index()
	{
		if (Auth::user()->is_patient)
		{
			// Get just the user's own reports
			$reports = Auth::user()->reports()->orderBy('created_at', 'desc')->paginate(4);
		}
		else
		{
			// Get all the reports
			$reports = Report::orderBy('patient_id', 'asc')->orderBy('created_at', 'desc')->paginate(4);
		}
		return view('reports.index', compact(['reports']));
	}

	public function create()
	{
		$tests = Test::where('enabled', 1)->pluck('name', 'id');
		
		// Only Patients can have Reports associated
		$patients = User::where('is_patient', 1)->pluck('name', 'id');
		return view('reports.create', compact (['tests', 'patients']));
	}

	public function store(Request $request)
	{
		if (!Auth::user()->is_patient)
		{
			$input = $request->all();
			$report = new Report;
			$report->patient_id = $input['patients'];
			$report->save();
	
			if (!empty ($input ['hdn_items_tests']))
			{
				$items = explode ('|', $input ['hdn_items_tests']);
				foreach ($items as $item)
				{
					$item_info = explode ('@', $item);
					if (!empty ($item_info[0]))
					{
						$test = Test::find ($item_info[0]);
						$report->tests()->attach ($test, ['result' => $item_info[1]]);
					}
				}
			}
			return redirect()->route('reports.index');
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function show($id)
	{
		if ($report = Report::find($id))
		{
			// Patients can only see his own Reports, Operators can see any Report
			if ($report->patient->id == Auth::user()->id || !Auth::user()->is_patient)
			{
				return view('reports.show', compact(['report']));
			}
			else
			{
				throw new Exception('Insufficient privileges');
			}
		}
		else
		{
			throw new Exception('Report not found');
		}
	}

	public function edit($id)
	{
		$report = Report::find($id);
		$tests = Test::where('enabled', 1)->pluck('name', 'id');
		$patients = User::where('is_patient', 1)->pluck('name', 'id');
		return view('reports.edit', compact (['tests', 'patients', 'report']));
	}

	public function update(Request $request, $id)
	{
		if (!Auth::user()->is_patient)
		{
			if ($report = Report::find($id))
			{
				// Delete previous PDF in order to keep the report up to date.
				if (file_exists('../pdfs/'.$report->id.'.pdf'))
				{
					unlink('../pdfs/'.$report->id.'.pdf');
				}
				
				$input = $request->all();
				$report->patient_id = $input['patients'];
				$report->save();
	
				// Logic to update the Tests associated with the Report
				$report->tests()->detach();
				if (!empty ($input ['hdn_items_tests']))
				{
					$items = explode ('|', $input ['hdn_items_tests']);
					foreach ($items as $item)
					{
						$item_info = explode ('@', $item);
						if (!empty ($item_info[0]))
						{
							$test = Test::find ($item_info[0]);
							$report->tests()->attach ($test, ['result' => $item_info[1]]);
						}
					}
				}
				return redirect()->route('reports.index');
			}
			else
			{
				throw new Exception('Report not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}

	public function destroy($id)
	{
		// Reports can be deleted just by Operators
		if (!Auth::user()->is_patient)
		{
			if ($report = Report::find($id))
			{
				$report->delete();
				return redirect()->route('reports.index');
			}
			else
			{
				throw new Exception('Report not found');
			}
		}
		else
		{
			throw new Exception('Insufficient privileges');
		}
	}
	
	private function generate_pdf($id)
	{
		if ($report = Report::find($id))
		{
			try
			{
				$fpdf = new Fpdf;
				$fpdf->AddPage();
				$fpdf->SetAutoPageBreak(true);
				$fpdf->SetFont('Arial', 'B', 15);
				$fpdf->Cell(50, 5, 'Patient: '.$report->patient->name, 0, 1);
				$fpdf->Line(10, 17, 200, 17);
				$fpdf->Ln(7);
				$fpdf->SetFont('Arial', '', 13);
				$fpdf->Write(7, $report->notes);
				$fpdf->Ln(14);
				foreach ($report->tests as $test)
				{
					$fpdf->Write(10, 
						$test->name.'          Result: '.
						(empty ($test->pivot->result) ? 'N/A' : $test->pivot->result));
					$fpdf->Ln(7);
					$fpdf->SetFont('Arial', '', 10);
					$fpdf->Write(10, 'Notes: '.$test->notes);
					$fpdf->SetFont('Arial', '', 13);
					$fpdf->Ln(14);
				}
				$fpdf->Output('F', '../pdfs/'.($report->id).'.pdf');
			}
			catch (Exception $e)
			{
				throw new Exception('Unable to generate PDF: '.$e->message());
			}
		}
		else
		{
			throw new Exception('Report not found');
		}
	}
	
	public function download_pdf($id)
	{
		if ($report = Report::find($id))
		{
			// Patients can only download his own Reports, Operators can download any Report
			if ($report->patient->id == Auth::user()->id || !Auth::user()->is_patient)
			{
				if (!file_exists('../pdfs/'.$report->id.'.pdf'))
				{
					$this->generate_pdf($report->id);
				}
				ob_get_clean();
				header('Content-type:application/pdf');
				header('Content-Disposition:attachment;filename=\'Report.pdf\'');
				readfile ('../pdfs/'.$report->id.'.pdf');
			}
			else
			{
				throw new Exception('Insufficient privileges');
			}
		}
		else
		{
			throw new Exception('Report not found');
		}
	}
	
	public function send_pdf($id)
	{
		if ($report = Report::find($id))
		{
			// Patients can only send his own Reports, Operators can send any Report
			if ($report->patient->id == Auth::user()->id || !Auth::user()->is_patient)
			{
				if (!file_exists('../pdfs/'.$report->id.'.pdf'))
				{
					$this->generate_pdf($report->id);
				}
				$mail = new PHPMailer;
				try 
				{
					$mail->isSMTP();
					$mail->CharSet = 'utf-8';
					//$mail->SMTPDebug = 2;
					$mail->Host = env ('MAIL_HOST');
					$mail->SMTPAuth = true;
					$mail->SMTPSecure = 'tls';
					$mail->Port = env ('MAIL_PORT');
					$mail->Username = env ('MAIL_USERNAME');
					$mail->Password = env ('MAIL_PASSWORD');
					$mail->setFrom('lab@crossover.com', 'Crossover');
					$mail->Subject = 'Your Report';
					$mail->MsgHTML('Dear '.$report->patient->name.',<br><br>Attached your <b>Report</b>.<br><br>Best regards,<br>Lab @ Crossover Team');
					$mail->addAddress($report->patient->email, $report->patient->name);
					$mail->addReplyTo('lab@crossover.com', 'Crossover');
					$mail->addAttachment('../pdfs/'.$report->id.'.pdf', 'Report.pdf'); 
					if (!$mail->send())
					{
						throw new Exception ($mail->ErrorInfo);
					}
					return view('reports.sent');
				} 
				catch (phpmailerException $e) 
				{
					throw $e;
				} 
				catch (Exception $e) 
				{
					throw $e;
				}
			}
			else
			{
				throw new Exception('Insufficient privileges');
			}
		}
		else
		{
			throw new Exception('Report not found');
		}
	}
}
