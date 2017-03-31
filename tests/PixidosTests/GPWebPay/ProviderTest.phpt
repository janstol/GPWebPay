<?php
/**
 * Created by PhpStorm.
 * User: Ondra Votava
 * Date: 31.03.2017
 * Time: 22:42
 */

/**
 * Test: Pixidos\GPWebPay\Provider
 * @testCase PixidosTests\GPWebPay\ProviderTest
 */

namespace PixidosTests\GPWebPay;

use Pixidos\GPWebPay\Provider;
use Pixidos\GPWebPay\Request;
use Pixidos\GPWebPay\Settings;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';

/**
 * Class ProviderTest
 * @package PixidosTests\GPWebPay
 * @author Ondra Votava <ondra.votava@pixidos.com>
 */
class ProviderTest extends GPWebPayTestCase
{
	/** @var  Provider */
	private $provider;

	protected function setUp()
	{
		parent::setUp(); // TODO: Change the autogenerated stub
		$this->prepareContainer();

		/** @var Settings $setting */
		$setting = $this->getContainer()->getByType(Settings::class);
		Assert::type(Settings::class, $setting);

		$this->provider = new Provider($setting);
	}


	public function testCreateRequest()
	{
		$operatin = TestHelpers::createOperation();
		/** @var Request $request */
		$request = $this->provider->createRequest($operatin)->getRequest();

		Assert::type(Request::class, $request);
		$params = $request->getParams();

		Assert::same(203, $params['CURRENCY']);
		Assert::same(123456, $params['ORDERNUMBER']);
	}


	public function testRequestUrl()
	{
		$operatin = TestHelpers::createOperation();
		$this->provider->createRequest($operatin);

		$expectetd = 'https://test.3dsecure.gpwebpay.com/unicredit/order.do?MERCHANTNUMBER=123456789&OPERATION=CREATE_ORDER&ORDERNUMBER=123456&AMOUNT=100000&CURRENCY=203&DEPOSITFLAG=1&URL=http%3A%2F%2Ftest.com&MD=czk&DIGEST=F0F%2Bb%2FyUUGmyzs7rOMXKD06JJ8EJrdit2YT2JaotVM3BaPe2adSk2MR1pmEWBLstKTZu2W4QIdYIgV8W7sKQ8wA96fmzJaCXzk%2BUEGdy2cRGG7u0ghsmuEu%2FR%2FR%2BprjujZx7YoVSPn4g%2FXQ9yVK1Svz23SYKnTOwiBGHd1sb2EHAjoO02o22FlHRP8Z%2F41oABNZt%2BycM7xWX%2Fx3YL01zGY99Mf2ulfe2UYaZ2nJtPa3FHuMPNJGfLPSFvTiIeEGCJ2%2BIkBqc5oTX0MjM8q2BojwSb%2BW%2Fev7N4fusQM%2BV2UjNZrXeMHfJGJkDE3VwNAY0AKaK%2Bcu6NDxHYsNswjyaWg%3D%3D';
		$url = $this->provider->getRequestUrl();
		Assert::same($expectetd, $url);
	}
}

(new ProviderTest())->run();