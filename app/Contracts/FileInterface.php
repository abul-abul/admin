<?php namespace App\Contracts;

interface FileInterface
{
	/**
	 * Create one file
	 *
	 * @param $data
	 * @return domain list
	 */
	public function createOne($data);

	/**
	 * Get all files by domain_id
	 *
	 * @param $data
	 * @return file list
	 */
	public function getFilesByDomainId($id);

	/**
	 * Get all file
	 *
	 * @return file list
	 */
	public function getAll();

	/**
	 * Get one file
	 *
	 * @return file list 
	 */
	public function getOne($id);
	
	/**
	 * delete one file
	 *
	 * @return file 
	 */
	public function deleteOne($id);
}
