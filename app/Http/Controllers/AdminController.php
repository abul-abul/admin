<?php 

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Domain\DomainCreateRequest;
use App\Http\Requests\Domain\DomainUpdateRequest;
use App\Http\Requests\Files\FileCreateRequest;

use App\Contracts\DomainInterface;
use App\Contracts\FileInterface;
use App\Contracts\LanguageInterface;

use Session;
use File;
use Validator;
use Config;

class AdminController extends BaseController
{


    // fan server
    public $fan_ftp_conn;
    public $fan_base_path;

    // ticket4 server
    public $ticket_ftp_conn;
    public $ticket_base_path;
    
    public function __construct()
    {
        // fan4 server connect and login
        $fan_ftp_server = config('fan4.fan_ftp_server');
        $fan_ftp_username = config('fan4.fan_ftp_username');
        $fan_ftp_userpass = config('fan4.fan_ftp_userpass');
        $this->fan_base_path = config('fan4.fan_base_path');
        $this->fan_ftp_conn = ftp_connect($fan_ftp_server) or die("Could not connect to ftp_server");
        $fanLogin = ftp_login($this->fan_ftp_conn, $fan_ftp_username, $fan_ftp_userpass);
        
        // ticket4 server connect and login
        $ticket_ftp_server = config('ticket4.ticket_ftp_server');
        $ticket_ftp_username = config('ticket4.ticket_ftp_username');
        $ticket_ftp_userpass = config('ticket4.ticket_ftp_userpass');
        $this->ticket_ftp_conn = ftp_connect($ticket_ftp_server) or die("Could not connect to ticket_ftp_server");
        $this->ticket_base_path = config('ticket4.ticket_base_path');
        $ticketLogin = ftp_login($this->ticket_ftp_conn, $ticket_ftp_username, $ticket_ftp_userpass);


    }

    /**
     * Has Access Login
     *
     * @return response
     */

    public function hasAccess()
    {
        if (!Session::has('log')) {
            return false;
        } else {
            return true;
        }
    }


   /**
     * The login page
     *
     * GET /admin
     */
    public function getLogin()
    {
        return view('admin.login-admin.login');
    }

     /**
     * Log the admin in
     *
     * POST /admin
     * @param Request $request
     */
    public function postLogin(Request $request)
    {
        $login = $request->get('login');
        $password = $request->get('password');
        if($login == config('login.login') && $password == config('login.password')){
            Session::put('log','log_pas');
        } else {
            return redirect()->back();
        }
        return redirect()->action('AdminController@getDashboard');
    }

     /**
     * Log the admin out
     *
     * GET /logout
     */
    public function getLogout()
    {
        Session::forget('log');
        return redirect()->action('AdminController@getLogin');
    }

    /**
     * Render dashboard view for admin.
     * GET /admin-dashboard
     *
     * @return view
     */
    public function getDashboard()
    {
        $access = $this->hasAccess();
        if ($access) {
            $data = [
                'authUser' => 'admin',
            ];
            return view('admin.dashboard' , $data);
        } else {
            return redirect()->action('AdminController@getLogin');
        }   
    }

    /**
     * add domain  view 
     * GET /admin/add-domain
     *
     * @return view
     */
    public function getAddDomain(LanguageInterface $langRepo)
    {
        $access = $this->hasAccess();    
        if ($access) {
            $languages = $langRepo->getAll();
            $lang = array();
            foreach ($languages as $language) {
                $lang[$language->name] = $language->name;
            }
            $data = [
                'lang' => $lang,
            ];
            return view('admin.domain.domain-add',$data);  
        } else {
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     * add domain in storage
     *
     * POST /admin/add-domain
     * @param DomainRequest $request
     * @param DomainInterface $domainRepo
     */
    public function postAddDomain(Request $request, DomainInterface $domainRepo)
    {
        $access = $this->hasAccess();
        if ($access) {

            // get all inputs $data to create domain
            $data['sub_domain'] = $request->get('sub_domain');
            $data['client_id'] = $request->get('client_id');
            $data['client_secret'] = $request->get('client_secret');
            $data['ticket_title'] = $request->get('ticket_title');
            $data['fan_title'] = $request->get('fan_title');
            $data['css'] = $request->get('css');
            $data['language'] = $request->get('language');

            // upload css file
            if ($request['css']) {

                // if not null css file
                $data['css'] = $request->file('css')->getClientOriginalName();
                $path = public_path(). '/assets/domains/' .$data['sub_domain'];
                $request->file('css')->move($path , $data['css']);
            } else {

                // default css file
                $path = public_path().'/assets/domains/'.$data['sub_domain'];
                $normalize = public_path().'/assets/normalize' ;
                $files = File::files($normalize);
                File::makeDirectory($path, $mode = 0777, $recursive = false);
                File::copyDirectory($normalize, $path, $options = null);
                $data['css'] = 'normalize.css';
            }
        
            // path to  fan4 server upload
            $fan4Path = public_path(). '/assets/domains/' .$data['sub_domain'].'/'.$data['css'];
            
            // admin upload favicon file 
            $data['favicon'] = $request->file('favicon')->getClientOriginalName();
            $path = public_path(). '/assets/domains/' .$data['sub_domain'];
            $request->file('favicon')->move($path , $data['favicon']);

            // path to ticket server upload
            $ticket4Path = public_path(). '/assets/domains/' .$data['sub_domain'].'/'.$data['favicon'];

            // put and create direction to fan4 server 
            ftp_pasv($this->fan_ftp_conn, true);
            ftp_mkdir($this->fan_ftp_conn , $this->fan_base_path.'/public/assets/domains/'.$data['sub_domain']) ;
            ftp_put($this->fan_ftp_conn , $this->fan_base_path.'/public/assets/domains/'.$data['sub_domain'].'/'.$data['css'] , $fan4Path , FTP_ASCII);       
            ftp_put($this->fan_ftp_conn , $this->fan_base_path.'/public/assets/domains/'.$data['sub_domain'].'/'.$data['favicon'] , $ticket4Path , FTP_ASCII) ;
            
            // put and create direction to  ticket server 
            ftp_pasv($this->ticket_ftp_conn, true);
            ftp_mkdir($this->ticket_ftp_conn , $this->ticket_base_path.'/public/assets/domains/'.$data['sub_domain']) ;
            ftp_put($this->ticket_ftp_conn , $this->ticket_base_path.'/public/assets/domains/'.$data['sub_domain'].'/'.$data['css'] , $fan4Path , FTP_ASCII);
            ftp_put($this->ticket_ftp_conn , $this->ticket_base_path.'/public/assets/domains/'.$data['sub_domain'].'/'.$data['favicon'] , $ticket4Path , FTP_ASCII) ;
            
            // create domain
            $domainRepo->createOne($data);

            // return domain list page
            return redirect()->action('AdminController@getDomainList');
        } else {

            // return to login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
	 * Get list of all domains.
	 * GET admin/domain/domian-list
	 *
	 * @param DomainInterface $domainRepo
	 * @return response
	 */
    public function getDomainList(DomainInterface $domainRepo, LanguageInterface $langRepo)
    {
        $access = $this->hasAccess();
        if ($access) {
            $domainList = $domainRepo->getAll();
            $languages = $langRepo->getAll();
            $lang = array();
            foreach ($languages as $language) {
                $lang[$language->name] = $language->name;
            }
        	$data = [
                'domains' => $domainList,
                'lang'    => $lang,
            ];
        	return view('admin.domain.domain-list' , $data);
        } else {
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     * 
     * fan server delete directory
     *
     * @param  string $directory
     * @return response
     */
    private function fanFtpDeleteDirectory($directory)
    {
        ftp_pasv($this->fan_ftp_conn, true);
        ftp_chdir($this->fan_ftp_conn, $directory);
        $files = ftp_nlist($this->fan_ftp_conn, ".");
        foreach ($files as $file) {
            ftp_delete($this->fan_ftp_conn, $file);
        }
        ftp_rmdir($this->fan_ftp_conn, $directory);

        return true;
    }

    /**
     * 
     * ticket server delete directory
     *
     * @param  string $directory
     * @return response
     */
    private function ticketFtpDeleteDirectory($directory)
    {   
        
        ftp_pasv($this->ticket_ftp_conn, true);
        
        ftp_chdir($this->ticket_ftp_conn, $directory);
        $files = ftp_nlist($this->ticket_ftp_conn, ".");
        foreach ($files as $file)
        {
            ftp_delete($this->ticket_ftp_conn, $file);
        }
        ftp_rmdir($this->ticket_ftp_conn, $directory);
        return true;
    }

    /**
     * Get list of all domains.
     * GET admin/delete-domain
     *
     * @param DomainInterface $domainRepo
     * @return response
     */
    public function deleteDomain($id, DomainInterface $domainRepo)
    {
        $access = $this->hasAccess();

        if ($access) {
            $domain = $domainRepo->getOne($id);
            $subDomain = $domain->sub_domain;
            if ($domain) {

                // delete domain
                $deletDomain = $domainRepo->deleteOne($id);
                if ($deletDomain) {
                    
                    // admin path()
                    $path =  public_path().'/assets/domains/'.$subDomain;
                    File::deleteDirectory($path);

                    // fan4 server delete Directory 
                    $this->fanFtpDeleteDirectory( $this->fan_base_path.'/public/assets/domains/'.$subDomain);

                    // tickets server delete Directory 
                    $this->ticketFtpDeleteDirectory($this->ticket_base_path.'/public/assets/domains/'.$subDomain);

                } else {
                    return redirect()->back();
                }   
            } else {
                return redirect()->back();
            }
            return redirect()->action('AdminController@getDomainList');
        } else {
            return redirect()->action('AdminController@getLogin');
        }    
    }

    /**
     *  Edit domain value
     *  Post admin/modal-value
     *
     *  @param DomainInterface $domainRepo
     *  @return response
     */
    public function ajaxEdit($id , DomainInterface $domainRepo)
    {
        $access = $this->hasAccess();
        if ($access) {
            $domain = $domainRepo->getOne($id);
            $dataArray = [
                    'domain' => $domain,
                ];
        return response()->json($dataArray);    
        } else {
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *  Edit domain
     *  Post admin/modal-update-value
     *
     *  @param DomainService $result
     *  @return response
     */
    public function editDomain($id ,Request $request , DomainInterface $domainRepo, LanguageInterface $langRepo )
    {   
        $access = $this->hasAccess();
        if ($access) {

            // before update domains file data
            $beforeUpdateDomain = $domainRepo->getOne($id);
            $beforeUpdateSubDomain = $beforeUpdateDomain->sub_domain;
            $beforeUpdateCss = $beforeUpdateDomain->css;
            $beforeUpdateFavicon = $beforeUpdateDomain->favicon;

            // get updated domain files 
            $inputs = $request->all();
            $data['sub_domain'] = $inputs['sub_domain'];
            $data['client_id'] = $inputs['client_id'];
            $data['client_secret'] = $inputs['client_secret'];
            $data['fan_title'] = $inputs['fan_title'];
            $data['ticket_title'] = $inputs['ticket_title'];
            $data['language'] = $inputs['language'];
            if ($data['language'] != $beforeUpdateDomain->language) 
            {
                $langs = $beforeUpdateDomain->languages()->get();
                $relayLang = $langRepo->getOneByName($beforeUpdateDomain->language);
                foreach ($langs as  $val) 
                {
                    if($val->name == $data['language'])
                    {  
                        $beforeUpdateDomain->languages()->detach($val->id);
                        $beforeUpdateDomain->languages()->attach($relayLang->id);
                    }
                }
            }
            // if uploadined css file
            if ($request['css']) {
               $data['css'] = $inputs['css']->getClientOriginalName();
            }

            // if uploaded favicon file
            if ($request['favicon']) {
                $data['favicon'] = $inputs['favicon']->getClientOriginalName();
            }          
            
            // edit domain
            $editDomain = $domainRepo->editDomain($id , $data);

            if ($editDomain) {
               
               // after update domain  
               $afterUpdateDomain = $domainRepo->getOne($id); 
               $afterUpdateSubDomain = $afterUpdateDomain->sub_domain;
               $afterUpdateCss = $afterUpdateDomain->css;
               $afterUpdateFavicon = $afterUpdateDomain->favicon;

               // if subdomain name updated
               if ($afterUpdateSubDomain != $beforeUpdateSubDomain) {

                    // admin path()
                    $beforeUpdatePath =  public_path(). '/assets/domains/'. $beforeUpdateSubDomain;
                    $afterUpdatePath =  public_path(). '/assets/domains/'. $afterUpdateSubDomain;
                    rename($beforeUpdatePath, $afterUpdatePath);

                    // fan4  server base_path()
                    ftp_pasv($this->fan_ftp_conn, true);
                    $beforeUpdateFan4Path =  $this->fan_base_path.'/public/assets/domains/'.$beforeUpdateSubDomain;
                    $afterUpdateFan4Path =  $this->fan_base_path.'/public/assets/domains/'. $afterUpdateSubDomain;
                    ftp_rename($this->fan_ftp_conn , $beforeUpdateFan4Path, $afterUpdateFan4Path);

                    // tickets server base_path()
                    ftp_pasv($this->ticket_ftp_conn, true);
                    $beforeUpdateTicketPath =  $this->ticket_base_path.'/public/assets/domains/'.$beforeUpdateSubDomain;
                    $afterUpdateTicketPath =  $this->ticket_base_path.'/public/assets/domains/'. $afterUpdateSubDomain;
                    ftp_rename($this->ticket_ftp_conn , $beforeUpdateTicketPath, $afterUpdateTicketPath);

               } else {

                    // admin path()
                    $beforeUpdatePath =  public_path(). '/assets/domains/'. $afterUpdateSubDomain;
                    $afterUpdatePath =  public_path(). '/assets/domains/'. $afterUpdateSubDomain;

                    // fan4  server base_path()
                    $beforeUpdateFan4Path =  $this->fan_base_path.'/public/assets/domains/'.$beforeUpdateSubDomain;
                    $afterUpdateFan4Path =  $this->fan_base_path.'/public/assets/domains/'. $afterUpdateSubDomain;

                    // tickets server base_path()
                    $beforeUpdateTicketPath =  $this->ticket_base_path.'/public/assets/domains/'.$beforeUpdateSubDomain;
                    $afterUpdateTicketPath =  $this->ticket_base_path.'/public/assets/domains/'. $afterUpdateSubDomain;
               }

               if ($request['css']) {
                   if($afterUpdateCss != $beforeUpdateCss){

                        // admin path()
                        $beforeCss = $afterUpdatePath . '/' . $beforeUpdateCss;
                        $afterCss = $afterUpdatePath . '/' . $afterUpdateCss;
                        
                        File::delete($beforeCss);
                        $request->file('css')->move($afterUpdatePath , $data['css']);

                        // fan4  server edit files base_path()
                        $beforeFan4Css = $afterUpdateFan4Path .'/'. $beforeUpdateCss;
                        $afterFan4Css = $afterUpdateFan4Path . '/'.$afterUpdateCss;

                        $fan4Path = $afterUpdatePath.'/'.$data['css'];
                        
                        ftp_pasv($this->fan_ftp_conn, true);
                        ftp_delete($this->fan_ftp_conn, $beforeFan4Css);
                        ftp_put($this->fan_ftp_conn , $afterUpdateFan4Path . '/' .$data['css'] , $fan4Path , FTP_ASCII);
                        // $request->file('css')->move($afterUpdateFan4Path , $data['css']);

                        // tickets server edit base_path()
                        $beforeTicketCss = $afterUpdateTicketPath .'/'. $beforeUpdateCss;
                        $afterTicketCss = $afterUpdateTicketPath . '/'.$afterUpdateCss;

                        ftp_pasv($this->ticket_ftp_conn, true);
                        ftp_delete($this->ticket_ftp_conn, $beforeTicketCss);
                        ftp_put($this->ticket_ftp_conn , $afterUpdateTicketPath . '/' .$data['css'] , $fan4Path , FTP_ASCII);

                   }
                }

                if($request['favicon']){
                   if($afterUpdateFavicon != $beforeUpdateFavicon){

                        // admin path()    
                        $beforeFavicon = $afterUpdatePath .'/'. $beforeUpdateFavicon;
                        $afterFavicon = $afterUpdatePath . '/'.$afterUpdateFavicon;
                        
                        // admin delete
                        File::delete($beforeFavicon);
                        $request->file('favicon')->move($afterUpdatePath , $data['favicon']);
                        
                        // path() to servers 
                        $fan4Path = $afterUpdatePath.'/'.$data['favicon'];

                        // fan4 server path() 
                        $beforeFanFavicon = $afterUpdateFan4Path .'/'. $beforeUpdateFavicon;
                        $afterFanFavicon = $afterUpdateFan4Path . '/'.$afterUpdateFavicon;

                        // fan server delete and put
                        ftp_pasv($this->fan_ftp_conn, true);
                        ftp_delete($this->fan_ftp_conn, $beforeFanFavicon);
                        ftp_put($this->fan_ftp_conn , $afterUpdateFan4Path . '/' .$data['favicon'] , $fan4Path , FTP_ASCII);

                        // tickets server path()
                        $beforeTicketFavicon = $afterUpdateTicketPath .'/'. $beforeUpdateFavicon;
                        $afterTicketFavicon = $afterUpdateTicketPath . '/'.$afterUpdateFavicon;

                        // tickets server delete and put
                        ftp_pasv($this->ticket_ftp_conn, true);
                        ftp_delete($this->ticket_ftp_conn, $beforeTicketFavicon);
                        ftp_put($this->ticket_ftp_conn , $afterUpdateTicketPath . '/' .$data['favicon'] , $fan4Path , FTP_ASCII);
                   }
                }
            }

            // return to back page
            return redirect()->back();
        } else {

            // return to login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *  
     *  create file into public/assets/domain/
     *
     *  @param FileService $data
     *  @return file
     */
    public function postAddFile($id , FileInterface $fileRepo , DomainUpdateRequest $request , DomainInterface $domainRepo)
    {
        // access to login
        $access = $this->hasAccess();
        if ($access) {

            // get domain $id
            $domain = $domainRepo->getOne($id);

            // get domain sub_domain
            $sub_domain = $domain->sub_domain;

            // get all inputs data
            $inputs = $request->all();

            // if not null file
            if ($request->file('file')) {

                // get input file
                $data['file_name'] = $inputs['file']->getClientOriginalName();
                $data['domain_id'] = $id;

                // create file
                $addFile = $fileRepo->createOne($data);

                // admin path()
                $path = public_path(). '/assets/domains/' .$sub_domain;
                $request->file('file')->move($path , $data['file_name']);

                // fan4 and ticket4  server path()
                $fan4Path = public_path(). '/assets/domains/' .$sub_domain . '/'. $data['file_name'];
                
                // fan4 server put
                ftp_pasv($this->fan_ftp_conn, true);
                ftp_put( $this->fan_ftp_conn, $this->fan_base_path .'/public/assets/domains/'.$sub_domain.'/'.$data['file_name'] , $fan4Path , FTP_ASCII);

                // tickets put server
                ftp_pasv($this->ticket_ftp_conn, true);
                ftp_put($this->ticket_ftp_conn , $this->ticket_base_path .'/public/assets/domains/'.$sub_domain.'/'.$data['file_name'] , $fan4Path , FTP_ASCII);

                // return validate to upload
                return redirect()->back()->with('message','Upload successful');
            } else {

                // return back page
                return redirect()->back();
            }
        } else {

                // return to login page
                return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     * get domain files by domain_id
     *  @param $id
     *  @return domain files
     */
    public function domainFiles($id , FileInterface $fileRepo)
    {
        // access to login
        $access = $this->hasAccess();

        if ($access) {

            // get files by domain $id
            $domainFiles = $fileRepo->getFilesByDomainId($id);

            // dataArray
            $data = [
                'files'  => $domainFiles,
                'domainId' => $id,
            ];

            // return $data domain-files view
            return view('admin.domain.domain-files' , $data);
        } else {

            // return login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  Get admin/add-language 
     *  
     *  @return add language 
     */
    public function getAddLanguage()
    {
        // access to login
        $access = $this->hasAccess();
        if ($access) {

            // return to create language page
            return view('admin.language.language-add');
        } else {

            // return to login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  Post admin/add-language 
     *  @param $data
     *  @return language list
     */
    public function postAddLanguage(Request $request , LanguageInterface $langRepo)
    {
        // access to login page
        $access = $this->hasAccess();

        if ($access) {

            // language name to create language
            $langName = $request['name'];

            // dataArray lang  name input
            $dataName['name'] = $request['name'];

            // validation to language name
            $validator = Validator::make(
                [
                    'name' => $langName,
                ],

                [
                    'name' => 'required|min:2|max:2',
                ]
             );

            // validation errors
            if ($validator->fails()) {
               
                // return back page validation errors data 
                return redirect()->back()->withErrors($validator->errors());
            } else {

                //  admin path()
                $langExaplePath = public_path(). '/lang-example' ;
                $files = File::files($langExaplePath);
                $destinationPath = base_path(). '/resources/lang/' . $request['name'];
                
                // if exists language
                if (file_exists($destinationPath)) {

                    // return back page
                    return redirect()->back();
                } else {

                    // create language
                    $createLanguage = $langRepo->createOne($dataName);

                    // admin path() create and copy directory 
                    File::makeDirectory($destinationPath ,  $mode = 0777, $recursive = false);
                    File::copyDirectory($langExaplePath , $destinationPath, $options = null);

                    // fan4 server create and copy directory 
                    ftp_pasv($this->fan_ftp_conn, true);
                    ftp_mkdir($this->fan_ftp_conn , $this->fan_base_path.'/resources/lang/'.$langName);

                    // ticket server create and copy directory 
                    ftp_pasv($this->ticket_ftp_conn, true);
                    ftp_mkdir($this->ticket_ftp_conn , $this->ticket_base_path.'/resources/lang/'.$langName);

                    foreach ($files as  $file) {

                        $arr = explode('/',$file);
                        $fileName = end($arr);

                        // fan4 server put
                        ftp_pasv($this->fan_ftp_conn, true);
                        ftp_put($this->fan_ftp_conn , $this->fan_base_path.'/resources/lang/'.$langName.'/'.$fileName , $file , FTP_ASCII);

                        // put ticket server 
                        ftp_pasv($this->ticket_ftp_conn, true);
                        ftp_put($this->ticket_ftp_conn ,$this->ticket_base_path.'/resources/lang/'.$langName.'/'.$fileName , $file , FTP_ASCII);
                    }
                }
                
                // return language page
                return redirect()->action('AdminController@getLanguageList');
            }  
        } else {

            // if not login return to login page
            return redirect()->action('AdminController@getLogin');
        }

    }

    /**
     *
     *  Get admin/language-list 
     *  @param $data
     *  @return language list
     */
    public function getLanguageList(LanguageInterface $langRepo)
    {
        // if access to login
        $access = $this->hasAccess();
        
        if($access){
            $langNames = $langRepo->getAll();

            $data = [
                'names' => $langNames
            ];

            return view('admin.language.language-list' , $data);
        }else{
            return redirect()->action('AdminController@getLogin');
        }
        
    }

    /**
     *
     *  Get admin/language-download/{id}/{fileName} 
     *  @param $id , $fileName
     *  @return language list
     */
    public function getDownloadLangFile($id , $fileName , LanguageInterface $langRepo)
    {
        $access = $this->hasAccess(); 

        if($access){
            $getLang = $langRepo->getOne($id);
            $langName = $getLang->name;

            // admin base_path()
            $path = base_path(). '/resources/lang/' . $langName . '/' . $fileName . '.php';


            if(file_exists($path)){
                return response()->download($path);
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->action('AdminController@getLogin');
        }
        
        
    }

    /**
     *
     *  Post admin/languageFile-edit/{id} 
     *  @param integer $id 
     *  @return language list
     */
    public function postEditLanguage($id , FileCreateRequest $request , LanguageInterface $langRepo)
    {   
        // access to login
        $access = $this->hasAccess();

        if ($access) {

            // get lang to update
            $getLang = $langRepo->getOne($id);
            $langName = $getLang->name;
            $fileName['name'] = $request['name']->getClientOriginalName();

            // admin base_path()
            $path = base_path(). '/resources/lang/' . $langName. '/' . $fileName['name'] ;
          
            if(file_exists($path)){

                // admin delete old file
                $deleteOldfile =  File::delete($path);
            }

            // admin move file 
            $movePath = base_path(). '/resources/lang/' . $langName;
            $request->file('name')->move($movePath , $fileName['name'] );
            $movePath = $movePath.'/'.$fileName['name'];

            // fan4 move file 
            ftp_pasv($this->fan_ftp_conn, true);
            @ftp_delete($this->fan_ftp_conn, $this->fan_base_path.'/resources/lang/'.$langName.'/'.$fileName['name']);
            ftp_put($this->fan_ftp_conn , $this->fan_base_path.'/resources/lang/'.$langName.'/'.$fileName['name'] , $movePath , FTP_ASCII);


            // tickets move file
            ftp_pasv($this->ticket_ftp_conn, true);
            @ftp_delete($this->ticket_ftp_conn, $this->ticket_base_path .'/resources/lang/'.$langName.'/'.$fileName['name']);
            ftp_put($this->ticket_ftp_conn ,$this->ticket_base_path.'/resources/lang/'.$langName.'/'.$fileName['name'] , $movePath , FTP_ASCII);

            // return back page upload succes message
            return redirect()->back()->with('message','Upload successful');
        }else{

            // return the login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  GET admin/language-en-edit/
     *  @param  string $name
     *  @return language list
     */
    public function getDownloadEnLang($fileName)
    {
        // access to login
        $access = $this->hasAccess(); 

        if ($access) {

            // admin base_path()
            $path = base_path(). '/resources/lang/en/' . $fileName . '.php';

            if (file_exists($path)) {

                // download langugae file
                return response()->download($path);
            } else {

                // return back page
                return redirect()->back();
            }
        } else {

            // retrun login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  Post admin/language-en-update 
     *  @param array $request
     *  @return language list
     */
    public function postUpdateEnLang(FileCreateRequest $request)
    {
        // access to login
        $access = $this->hasAccess();

        if ($access) {
            
            // language edit name
            $fileName['name'] = $request['name']->getClientOriginalName();

            // admin base_path()
            $path = base_path(). '/resources/lang/en/' . $fileName['name'] ;
            
            if (file_exists($path)) {

                // admin delete old file
                $deleteOldfile =  File::delete($path);
            }
            
            // admin move file 
            $movePath = base_path(). '/resources/lang/en';
            $request->file('name')->move($movePath , $fileName['name'] );
            $movePath = $movePath.'/'.$fileName['name'];

            // fan4 server delente and move file 
            ftp_pasv($this->fan_ftp_conn, true);
            @ftp_delete($this->fan_ftp_conn, $this->fan_base_path.'/resources/lang/en/'.$fileName['name']);
            ftp_put($this->fan_ftp_conn , $this->fan_base_path.'/resources/lang/en/'.$fileName['name'] , $movePath , FTP_ASCII);


            // tickets server delete ande move file
            ftp_pasv($this->ticket_ftp_conn, true);
            @ftp_delete($this->ticket_ftp_conn, $this->ticket_base_path .'/resources/lang/en/'.$fileName['name']);
            ftp_put($this->ticket_ftp_conn ,$this->ticket_base_path.'/resources/lang/en/'.$fileName['name'] , $movePath , FTP_ASCII);

            // return back page success message 
            return redirect()->back()->with('message','Upload successful');
        } else {
            
            // return login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  Get admin/language-delete/{id} 
     *  @param integer $id 
     *  @return language list
     */
    public function getDeleteLanguage($id , LanguageInterface $langRepo)
    {
        $access = $this->hasAccess();

        if ($access) {

            // language name
            $langName = $langRepo->getOne($id)->name;

            // delete language
            $deleteLang = $langRepo->deleteOne($id);
            
            // admin base_path()
            $deletePath = base_path(). '/resources/lang/' . $langName;
            File::deleteDirectory($deletePath , $preserve = false);

            // fan4 server move file 
            $this->fanFtpDeleteDirectory($this->fan_base_path.'/resources/lang/'.$langName);
      
            // tickets server move file
            $this->ticketFtpDeleteDirectory($this->ticket_base_path .'/resources/lang/'.$langName);
            
            // return back page
            return redirect()->back();
        } else {

            // return login page
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *  print language value
     *  Post admin/language-modal-valaue/
     *  @param LanguageInterface $domainRepo
     *  @return response
     */
    public function printValueModal($id, LanguageInterface $domainRepo)
    {
        $access = $this->hasAccess();

        if ($access) {

            // language name
            $name = $domainRepo->getOne($id);
            
            $dataArray = [
                    'name' => $name,
                ];
              
            // return json
            return response()->json($dataArray);    
        } else {

            // return  to login page 
            return redirect()->action('AdminController@getLogin');
        }
    }
    
    /**
     * Update language name
     * Post admin/language-update/
     * @param LanguageInterface $languageRepo
     * @return response
     */
    public function editLangName($id, Request $request, LanguageInterface $languageRepo)
    {
        $access = $this -> hasAccess();

        if ($access) {

            // get langugae name to edit
            $langName = $request->get('name');

            // validation to lang name
            $validator = Validator::make(
                [
                    'name' => $langName,
                ],

                [
                    'name' => 'required|min:2|max:2',
                ]
             );

            // return validation errors 
            if ($validator->fails()) {

                return redirect()->back();
            }

            // before update language 
            $beforeUpdateLang = $languageRepo->getOne($id);
            $beforeUpdatename = $beforeUpdateLang->name;
           
            // get lang name to edit 
            $inputs = $request->all();
            $data['name'] = $inputs['name'];

            // edit language name
            $editLanguage = $languageRepo->editLanguage($id , $data);

            if ($editLanguage) {

                //after update language  
                $afterUpdateLang = $languageRepo->getOne($id);
                $afterUpdatename = $afterUpdateLang->name;

                if ($afterUpdatename != $beforeUpdatename) {

                        // admin base_path()
                        $beforeUpdatePath =   base_path() . '/resources/lang/' . $beforeUpdatename;
                        $afterUpdatePath =  base_path() . '/resources/lang/'. $afterUpdatename;
                        rename( $beforeUpdatePath , $afterUpdatePath );  

                        // fan4 base_path()
                        $beforeUpdatePath =  $this->fan_base_path.'/resources/lang/'.$beforeUpdatename;
                        $afterUpdatePath  =  $this->fan_base_path.'/resources/lang/'.$afterUpdatename;
                        ftp_pasv($this->fan_ftp_conn, true);
                        ftp_rename($this->fan_ftp_conn , $beforeUpdatePath , $afterUpdatePath);

                        // tickets base_path()
                        $beforeUpdatePath =  $this->ticket_base_path.'/resources/lang/'.$beforeUpdatename;
                        $afterUpdatePath =  $this->ticket_base_path.'/resources/lang/'.$afterUpdatename;
                        ftp_pasv($this->ticket_ftp_conn, true);
                        ftp_rename($this->ticket_ftp_conn ,$beforeUpdatePath , $afterUpdatePath);
                }

            }

                return redirect()->back();            
        } else {
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  Get admin/domain-lang/{id}
     *  @param integer $id 
     *  @return domain language list
     */
    public function getDomainLanguage($id , LanguageInterface $langRepo , DomainInterface $domainRepo)
    {
        $access = $this -> hasAccess();

        if($access){
            $getAllLang = $langRepo->getAllList();    
            $domainId = $id;
            $subDomain = $domainRepo->getOne($id)->sub_domain;
            $domainLang = $domainRepo->getDomainLangList($id);

            $data = [
                'language'  => $getAllLang,
                'domainId'  => $domainId,
                'subDomain' => $subDomain,
                'domainLangs' => $domainLang,
            ];

            return view('admin.domain.domain-language' , $data);
        }else{
            return redirect()->action('AdminController@getLogin');
        }
        
    }

    /**
     *
     *  Post admin/add-domain-lang/{id}
     *  @param integer $id 
     *  @return domain language list
     */
    public function postAddDomainLang($id, Request $request, LanguageInterface $langRepo, DomainInterface $domainRepo)
    {
        $access = $this -> hasAccess();

        if ($access) {
            
            $languagId = $request['language'];
            $domainId = $id;
            $domain = $domainRepo->getOne($domainId);
            $addLang = $langRepo->getOne($languagId);
            $domainLangs = $domain->languages()->get();
            foreach ($domainLangs as $val)
            {
                if($addLang->name == $val->name)
                    return redirect()->back();
            }

            if($domain->language == $addLang->name)
                return redirect()->back();
            $langRepo->getAddLanguageDomain($languagId, $domainId);

            return redirect()->back();
        } else { 
            return redirect()->action('AdminController@getLogin');
        }
        

    }

    /**
     *
     *  Get admin/delete-domain-lang/{domainId}/{languageId}
     *  @param ineteger $languageId , integer $domainId
     *  @return domain language list
     */
    public function getDeleteDomainLanguage($languageId , $domainId , DomainInterface $domainRepo)
    {
        $access = $this -> hasAccess();

        if ($access) {
            $deleteDomainLang =  $domainRepo->deleteDomainLang($languageId , $domainId);
            if ($deleteDomainLang != 0) {
                return redirect()->back();
            } else {
                return dd('not dellete');
            }
        } else {
            return redirect()->action('AdminController@getLogin');
        }
    }

    /**
     *
     *  get delete domain files
     *  @param integer $fileId , integer $domainId
     *  @return domain files list
     */
    public function getDeleteDomainFiles($fileId , $domainId ,  FileInterface $fileRepo , DomainInterface $domainRepo)
    {
        $access = $this->hasAccess();
                
        if ($access) {
            $domain_file = $fileRepo->getOne($fileId);
            $filesName = $domain_file->file_name;
          
            if ($filesName) {
                $deletFileName = $fileRepo->deleteOne($fileId);
                $domain = $domainRepo->getOne($domainId);
                $subDomain = $domain->sub_domain;
                if ($deletFileName) {

                    // admin public_path()
                    $path =  public_path().'/assets/domains/'. $subDomain .'/'. $filesName;
                    \File::delete($path);

                    // fan4 public_path()
                    ftp_pasv($this->fan_ftp_conn, true);
                    ftp_delete($this->fan_ftp_conn, $this->fan_base_path.'/public/assets/domains/'.$subDomain.'/'.$filesName);

                    // tickets public_path()
                    ftp_pasv($this->ticket_ftp_conn, true);
                    ftp_delete($this->ticket_ftp_conn, $this->ticket_base_path.'/public/assets/domains/'.$subDomain.'/'.$filesName);

                } else {
                    return redirect()->back();
                }   
            } else {
                return redirect()->back();
            }
            return redirect()->back();
        } else {
            return redirect()->action('AdminController@getLogin');
        } 
    }
}

                
