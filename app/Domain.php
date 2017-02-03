<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{

    /**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'domains';

	// timestamps false
	public $timestamps = false;

	// domains table fields
	protected $fillable = ['sub_domain', 'css', 'client_secret', 'client_id', 'favicon', 'ticket_title', 'fan_title', 'language'];

	// belongsToMany language model
	public function languages()
    {
        return $this->belongsToMany('App\Language' , 'domain_languages');
    }

}
