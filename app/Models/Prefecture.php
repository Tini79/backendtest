<?php

namespace App\Models;

class Prefecture extends \App\Models\Base\Prefecture
{
	protected $fillable = [
		'name',
		'display_name',
		'area_id'
	];

	public function companies()
	{
		return $this->hasMany(Company::class);
	}


	public function postcodes()
	{
		return $this->hasMany(Postcode::class);
	}
}
