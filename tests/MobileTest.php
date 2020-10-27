<?php

namespace Tests;

use App\Contact;
use App\SMS;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use App\Mobile;
use App\Interfaces\CarrierInterface;
use App\Call;

class ProviderTest implements CarrierInterface{
    private $contact = null;
    public function dialContact(Contact $contact)
    {
        $this->contact= $contact;
    }
    public function makeCall(): Call
    {
        if(empty($this->contact->getNumber)){
            return new Call('');
        }
        return new Call($this->contact->getNumber());
    }

    public function makeSMS($from): SMS
    {
        return new SMS($from,$this->contact->getNumber(),'Lorem ipsum message...');
    }
}

class OtherProviderTest implements CarrierInterface{
    private $contact = null;
    public function dialContact(Contact $contact)
    {
        $this->contact= $contact;
    }
    public function makeCall(): Call
    {
        if(empty($this->contact->getNumber)){
            return new Call('');
        }
        return new Call($this->contact->getNumber());
    }

    public function makeSMS($from): SMS
    {
        /*
        * other provider logic here
        * */
    }
}

class MobileTest extends TestCase
{
	
	/** @test */
	public function it_returns_null_when_name_empty()
	{
		$mobile = new Mobile(new ProviderTest());

		$this->assertNull($mobile->makeCallByName(''));
	}

    /** @test */
	public function it_return_valid_when_name_filled(){
        $mobile = new Mobile(new ProviderTest());

        $this->assertNotNull($mobile->makeCallByName('test1'));
    }

    /** @test */
    public function it_return_not_found_name(){
        $mobile = new Mobile(new ProviderTest());

        $call = $mobile->makeCallByName('test1222');
        $this->assertFalse($call->IsValidCall());
    }

    /** @test */
    public function it_return_success_sms(){
        $mobile = new Mobile(new ProviderTest());
        $sms =$mobile->makeSMS('test1','666');
        $this->assertTrue($sms->send());
    }

    /** @test */
    public function it_return_contact_not_found_sms(){
        $mobile = new Mobile(new ProviderTest());
        $this->assertNull($mobile->makeSMS('test1','0012902'));
    }

    /** @test */
    public function it_return_true_use_other_provider(){
        $mobile = new Mobile(new ProviderTest(),new OtherProviderTest());
        $mobile->statusProviderPrimary(false);
        $this->assertNotNull($mobile->makeCallByName('test1'));
    }

}
