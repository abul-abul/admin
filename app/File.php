<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';
	public $timestamps = false;

	protected $fillable = [ 'domain_id' , 'file_name' ];
}
