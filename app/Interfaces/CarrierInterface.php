<?php

namespace App\Interfaces;

use App\Contact;
use App\Call;


interface CarrierInterface
{
	
	public function dialContact(Contact $contact);
	public function makeSMS($from);

	public function makeCall(): Call;
}