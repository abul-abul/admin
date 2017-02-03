<?php namespace App\Services;

use App\Contracts\FileInterface;
use App\File;

class FileService implements FileInterface
{

	/**
	 * Create a new instance of FileService class
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->file = new File();
	}

	/**
	 * Create one file
	 *
	 * @param $data
	 * @return domain list
	 */
	public function createOne($data)
	{
		return $this->file->create($data);
	}

	/**
	 * Get all files by domain_id
	 *
	 * @param $data
	 * @return file list
	 */
	public function getFilesByDomainId($id)
	{
		return $this->file->where('domain_id' , '=' , $id)->get();
	}

	/**
	 * Get all files
	 * @return file list
	 */
	public function getAll()
	{
		return $this->file->get();
	}
	/**
	 * Get one files
	 * @return file list
	 */
	public function getOne($id)
	{
		return $this->file->find($id);
	}
	/**
	 * delete one file
	 *
	 * @return file 
	 */
	public function deleteOne($id)
	{
		return $this->getOne($id)->delete();
	}
	
}