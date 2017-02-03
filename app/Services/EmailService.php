<?php namespace App\Services;
use App\Contracts\EmailInterface;



class EmailService implements EmailInterface
{

	/**	
	 * send message
	 *
	 * @param $path
	 * @param $fromEmail
	 * @param $toEmail
	 *
	 */
	public function send($path, $fromEmail, $toEmail)
	{
		 Mail::send('emails.'.$path, null, function($message) use ($email)
            {
                $message->from($fromEmail, 'Laravel');
                $message->to($toEmail);
            });
	}
}