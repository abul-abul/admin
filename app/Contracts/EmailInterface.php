<?php namespace App\Contracts;

interface EmailInterface
{
	/**	
	 * @param $path
	 * @param $email
	 *
	 */
	public function send($path, $fromEmail, $toEmail);
}