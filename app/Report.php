<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $fillable = [
		'patient_id', 'notes',
	];
	
	public function patient()
	{
		return $this->belongsTo('App\User', 'patient_id');
	}
	
	public function tests()
	{
		return $this->belongsToMany('App\Test', 'report_tests', 'report_id', 'test_id')->withPivot('result');
	}
	
	public static function boot()
	{
		parent::boot();

		Report::deleting(function($parent)
		{
			$parent->tests()->detach();
			$parent->save();
		});
	}
}
