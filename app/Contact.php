<?php

namespace App;


class Contact
{
	private $name = '';
	private $number= '';
	function __construct($name,$number)
	{
		# code...
        $this->name = $name;
        $this->number = $number;
	}

	public function getNumber(){
	    return $this->number;
    }
}