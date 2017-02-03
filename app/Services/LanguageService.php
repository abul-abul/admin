<?php namespace App\Services;

use App\Contracts\LanguageInterface;
use App\Language;

class LanguageService implements LanguageInterface
{

	/**
	 * Create a new instance of FileService class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->language = new Language();
	}

	/**
	 * Create one language
	 *
	 * @param $data
	 * @return language list
	 */
	public function createOne($data)
	{
		return $this->language->create($data);
	}

	/**
	 * Get all languages
	 *
	 * @param $data
	 * @return language list
	 */
	public function getAll()
	{
		return $this->language->get();
	}

	/**
	 * Get one languages
	 *
	 * @param $name
	 * @return language list
	 */
	public function getOneByName($name)
	{
		return $this->language->where('name','=',$name)->first();
	}

	/**
	 * Get one languages
	 *
	 * @param $id
	 * @return language list
	 */
	public function getOne($id)
	{
		return $this->language->find($id);
	}

	/**
	 * delete one language
	 *
	 * @return language 
	 */
	public function deleteOne($id)
	{
		return $this->getOne($id)->delete();
	}

	/**
	 * get language list id and name
	 *
	 * @return name and id 
	 */
	public function getAllList()
	{
		return $this->language->lists('name' , 'id');
	}

	/**
	 * get add langugae to domains
	 * 
	 * @param $languageId , $domainId
	 * @return  domain langugaes list
	 */
	public function getAddLanguageDomain($languageId,$domainId)
	{
		return $this->language->find($languageId)->domains()->attach($domainId);
	}


	public function editLanguage($id , $params)
	{
		return $this->getOne($id)->update($params);
	}
}