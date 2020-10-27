<?php

namespace App\Services;

use App\Contact;

const DATABASE_CLIENTS = [
    array('name'=>'test1','number'=>'123456'),
    array('name'=>'test99','number'=>'666')
];

class ContactService
{

	public static function findByName($name): Contact
	{
		// queries to the db
        foreach(DATABASE_CLIENTS as $client){
            if($name==$client['name']){
                return new Contact($client['name'],$client['number']);
                break;
            }
        }
        return new Contact('','');
	}

	public static function validateNumber(string $number): bool
	{
		if(is_numeric($number)){
            foreach(DATABASE_CLIENTS as $client){
                if($number==$client['number']){
                    return true;
                    break;
                }
            }
            return false;
        }else{
		    return false;
        }


	}
}