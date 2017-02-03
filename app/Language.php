<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'languages';
	public $timestamps = false;	

	protected $fillable = [ 'name' ];

	public function domains()
    {
        return $this->belongsToMany('App\Domain' , 'domain_languages');
    }
}
