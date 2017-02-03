<?php namespace App\Contracts;

interface DomainInterface
{
	
	/**
	 * Get all domains
	 *
	 * @return domain list
	 */
	public function getAll();

	/**
	 * Create one domains
	 *
	 * @param $data
	 * @return domain list
	 */
	public function createOne($data);

	/**
	 * Get one domain
	 *
	 * @return domain 
	 */
	public function getOne($id);

	/**
	 * delete one domain
	 *
	 * @return domain 
	 */
	public function deleteOne($id);
	
	/**
	 * Get one domain by sub_domain
	 * @param string $sub_domain
	 * @return domain 
	 */
	public function getDomainBySubDomain($sub_domain);
	
	/**
	 * Update modal value
	 * @param  strin $params
	 * @return domain
	 */
	public function editDomain($id , $params);

	/**
     *
     *  get domain languages list 
     *  @param $id
     *  @return language list
     */
	public function getDomainLangList($id);

	/**
     *
     *  get delete domain language 
     *  @param $languageId , $domainId
     *  @return language list
     */	
	public function deleteDomainLang($languageId , $domainId);


}
