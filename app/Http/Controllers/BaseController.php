<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\DomainService;

use Auth;
use Config;

class BaseController extends Controller
{

    public $title;
    public $language;
    public $currentPathWithoutLocale;
    public $locale;
    public $favicon;

    public function __construct()
    {
        
        $domainRepo = new DomainService();
        $this->getFaviconByDomainId($domainRepo);
        $this->missing($domainRepo);
        $this->title    = 'RSCA fan';
        $this->language = config('app.locale');
        $this->domainsLangs = config('app.locales');

        
        $this->currentPathWithoutLocale = substr(implode(\Request::segments() ,  '/') , 3);

        $data = [
           'title'                    => $this->title,
           'language'                 => $this->language,
           'currentPathWithoutLocale' => $this->currentPathWithoutLocale,
           'favicon'                  => $this->getFaviconByDomainId($domainRepo),
            'domainsLangs'             => $this->domainsLangs,
        ];
        view()->share($data);
    }

    /**
     * get favicon img to domain
     */
    public function getFaviconByDomainId($domainRepo)
    {
        $server = explode('.', \Request::server('HTTP_HOST'));
        $subDomains = $server[0];
        $domain = $domainRepo->getDomainBySubDomain($subDomains);
        
        if($domain){
            $favicon = $domain->favicon;
            return $favicon;
        }
        
    }

    /**
     * 404 page not found to subdomain
     */
    public function missing($domainRepo)
    {
        $server = explode('.', \Request::server('HTTP_HOST'));
        $subDomains = $server[0];
        $domain = $domainRepo->getDomainBySubDomain($subDomains);
        if(!$domain){
            return view('errors.404');
        }
    }    
            


}
