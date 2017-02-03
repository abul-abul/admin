<?php namespace App\Contracts;

interface LanguageInterface
{
	/**
	 * Create one language
	 *
	 * @param $data
	 * @return language list
	 */
	public function createOne($data);

	/**
	 * Get all languages
	 *
	 * @param $data
	 * @return language list
	 */
	public function getAll();

	/**
	 * Get one languages
	 *
	 * @param $id
	 * @return language list
	 */
	public function getOne($id);
	/**
	 * Get one languages
	 *
	 * @param $name
	 * @return language list
	 */
	public function getOneByName($name);
	/**
	 * delete one language
	 *
	 * @return language 
	 */
	public function deleteOne($id);

	/**
	 * get language list id and name
	 *
	 * @return name and id 
	 */
	public function getAllList();

	/**
	 * get add langugae to domains
	 * 
	 * @param $languageId , $domainId
	 * @return  domain langugaes list
	 */
	public function getAddLanguageDomain($languageId,$domainId);

	/**
	 * Update one language
	 *
	 *@return language
	 */
	public function editLanguage($id , $params);

}
