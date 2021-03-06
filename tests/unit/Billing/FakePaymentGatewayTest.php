<?php

namespace Tests\Unit\Billing;

use Tests\TestCase;
use App\Billing\FakePaymentGateway;

class FakePaymentGatewayTest extends TestCase
{
	use PaymentGatewayContractsTest;

	protected function getPaymentGateway()
	{
		return new FakePaymentGateway;
	}

	/** @test */
	public function running_hook_before_the_first_charge()
	{
	    $paymentGateway = new FakePaymentGateway;
	    $timesCallbackRan = 0;

	    $paymentGateway->beforeFirstCharge(function($paymentGateway) use (&$timesCallbackRan) {
		    $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());
	    	$timesCallbackRan++;
	    	$this->assertEquals(2500, $paymentGateway->totalCharges());
	    });

	    $paymentGateway->charge(2500, $paymentGateway->getValidTestToken());
	    $this->assertEquals(1, $timesCallbackRan);
    	$this->assertEquals(5000, $paymentGateway->totalCharges());
	}
}