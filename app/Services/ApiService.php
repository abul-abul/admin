<?php namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Services\DomainService;
use App\Services\UserDomainService;
use Auth;

class ApiService
{

	const APIURL = 'ixpole.com/api/';
    

    /**
     * Token for request
     *
     * @var string
     */
   public $token;
   public $tokenExpiresIn;
   protected $client;
   public $domain;
   public $subDomain;

   public function __construct()
   {
       $this->userDomain = new UserDomainService();
       $this->domain     = new DomainService();
       $this->client     = new Client;
       
       $authUserSubDomain = null;

       if(Auth::user())
       {
           $authUserId = Auth::user()->id;
           $data = $this->userDomain->getAll($authUserId);
           $authUserDomainId = $data->domain_id;
           $domainData = $this->domain->getDomainByUserId($authUserDomainId);
           $authUserSubDomain = $domainData->sub_domain;

       }else{
           $server = explode('.', \Request::server('HTTP_HOST'));
           $subdomain = $server[0];
           $authUserSubDomain = $subdomain;
       }

          $domainConfig = $this->domain->getDomainBySubDomain($authUserSubDomain);
          if($domainConfig == null){
            abort(404);
          }else{
            $clientId = $domainConfig->client_id;
            $clientSecret = $domainConfig->client_secret;
  
          }
          

          $this->generateToken($authUserSubDomain , $clientId , $clientSecret);
      


       
   }


   /**
    * Get a token from the iXpole API
    *
    * @return void
    */
   protected function generateToken($authUserSubDomain , $clientId , $clientSecret)
   {   
       $this->subDomain = $authUserSubDomain;

       if (
           \Session::has('ixpoleToken') &&
           \Session::get('ixpoleToken') != "" &&
           \Session::has('ixpoleTokenExpiresIn') &&
           time() < \Session::get('ixpoleTokenExpiresIn')
       ) {
           $this->token          = \Session::get('ixpoleToken');

           $this->tokenExpiresIn = \Session::get('ixpoleTokenExpiresIn');
       } else {
           try {
                    $response = $this->client->post(
                   'https://'. $authUserSubDomain . '.' . config('ixpole.token_url'), [
                        'body' => [
                           'grant_type'    =>  config('ixpole.grant_type'),
                           'client_id'     =>  $clientId,
                           'client_secret' =>  $clientSecret,
                       ],
                       'verify' => false
                   ]

               );
               $body = json_decode($response->getBody());
               $this->token          = $body->access_token;
               $this->tokenExpiresIn = time() + $body->expires_in;

               session('ixpoleToken', $this->token);
               session('ixpoleTokenExpiresIn', $this->tokenExpiresIn);
           } catch (RequestException $e) {
               abort(404);
           }
       }
    }
    /**
     * Get a complete API url
     *
     * @param  string $path The relative path
     * @return string       The complete API url
     */
    public function getUrl($subdomain, $path)
    {
    	return 'https://' . $subdomain .'.'. self::APIURL.$path;
    }
}