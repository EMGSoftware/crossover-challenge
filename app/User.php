<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'is_patient',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];
	
	public function reports ()
	{
		return $this->hasMany('App\Report', 'patient_id');
	}
	
	public static function boot()
	{
		parent::boot();

		User::deleting(function($parent)
		{
			foreach ($parent->reports as $item) $item->delete();
			$parent->save();
		});
	}
}
