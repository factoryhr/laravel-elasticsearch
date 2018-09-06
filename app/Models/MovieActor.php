<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 05 Sep 2018 08:29:45 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class MovieActor
 * 
 * @property int $id
 * @property string $name
 * @property int $movie_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 * @property \App\Models\Movie $movie
 *
 * @package App\Models
 */
class MovieActor extends Eloquent
{
	protected $casts = [
		'movie_id' => 'int'
	];

	protected $fillable = [
		'name',
		'movie_id'
	];

	public function movie()
	{
		return $this->belongsTo(\App\Models\Movie::class);
	}
}
