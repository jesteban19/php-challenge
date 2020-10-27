<?php

namespace App;

use App\Interfaces\CarrierInterface;
use App\Services\ContactService;


class Mobile
{

	protected $provider;
	protected $secondaryProvider;
	protected $activePrimaryProvider = true;

	function __construct(CarrierInterface $provider,CarrierInterface  $secondaryProvider=null)
	{
		$this->provider = $provider;
		$this->secondaryProvider = $secondaryProvider;
	}

    protected function getProviderCurrent(){
	    return $this->activePrimaryProvider ? $this->provider  : $this->secondaryProvider;
    }
	public function statusProviderPrimary(bool $active){
	    $this->activePrimaryProvider = $active;
    }


	public function makeCallByName($name = '')
	{
		if( empty($name) ) return;

		$contact = ContactService::findByName($name);

		$this->getProviderCurrent()->dialContact($contact);

		return $this->getProviderCurrent()->makeCall();
	}

	public function makeSMS($name='',$from){
        if( empty($name) ) return;

        $contact = ContactService::findByName($name);

        if(!ContactService::validateNumber($from)) return;
        $this->getProviderCurrent()->dialContact($contact);
        return $this->getProviderCurrent()->makeSMS($from);
    }


}
