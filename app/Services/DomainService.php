<?php namespace App\Services;

use App\Contracts\DomainInterface;
use App\Domain;

class DomainService implements DomainInterface
{

	/**
	 * Create a new instance of DomainService class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->domain = new Domain();
	}

	/**
	 * Get all domains
	 *
	 * @return domain list
	 */
	public function getAll()
	{
		return $this->domain->get();
	}


	/**
	 * Create one domains
	 *
	 * @param $data
	 * @return domain list
	 */
	public function createOne($data)
	{
		return $this->domain->create($data);
	}

	/**
	 * Get one domain
	 *
	 * @return domain 
	 */
	public function getOne($id)
	{
		return $this->domain->find($id);
	}

	/**
	 * delete one domain
	 *
	 * @return domain 
	 */
	public function deleteOne($id)
	{
		return $this->getOne($id)->delete();
	}

	/**
	 * Get one domain by sub_domain
	 * @param string $sub_domain
	 * @return domain 
	 */
	public function getDomainBySubDomain($sub_domain)
	{
		return $this->domain->where('sub_domain' , $sub_domain)->first();
	}

	/**
	 * Get one domain by userId
	 * @param string $domainId
	 * @return domain 
	 */
	public function getDomainByUserId($domainId)
	{
		return $this->domain->where('id' , '=' , $domainId)->first();
	}

	/**
	 * Update modal value
	 * @param string $params
	 * @return domain
	 */
	public function editDomain($id , $params)
	{
		return $this->getOne($id)->update($params);
	}

	/**
	 * Get one favicon on domain
	 * @param string $subDomain
	 * @return domain
	 */
	public function getFaviconByDomainName($subDomain)
	{
		return $this->domain->where('sub_domain' , '=' , $subDomain)->get();
	}

	/**
     *
     *  get domain languages list 
     *  @param $id
     *  @return language list
     */
	public function getDomainLangList($id)
	{

		return $this->domain->find($id)->languages()->get();
	}

	/**
     *
     *  get delete domain language 
     *  @param $languageId , $domainId
     *  @return language list
     */
	public function deleteDomainLang($languageId , $domainId)
	{
		return $this->domain->find($languageId)->languages()->detach($domainId);
	}
	
	/**
	 * Get one name on language
	 * @param string $id
	 * @return domain
	 */
	 public function postLangModalValue($id)
	 {
	 	return $this->domain->where('name' , '=' , $name)->get();
	 }	
}