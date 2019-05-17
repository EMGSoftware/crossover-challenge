<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	protected $fillable = [
		'name', 'notes', 'enabled',
	];
	
	public function reports()
	{
		return $this->belongsToMany('App\Report', 'report_tests', 'test_id', 'report_id')->withPivot('result');
	}
	
	public static function boot()
	{
		parent::boot();

		Test::deleting(function($parent)
		{
			$parent->reports()->detach();
			$parent->save();
		});
	}
}
