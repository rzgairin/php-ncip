<?php namespace Scriptotek\Ncip\Test;

use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;
use Scriptotek\Ncip\CheckOutRequest;


class CheckOutRequestTest extends \PHPUnit_Framework_TestCase {

	public function testXml() {
		$agencyId = 'k';
		$userId = 'xx00000001';
		$itemId = 'exdoc10002';
		$req = new CheckOutRequest($agencyId, $userId, $itemId);
		$xml = $req->xml();

		$this->assertTrue($req->is('CheckOutItem'));
		$this->assertSelectCount('CheckOutItem', 1, $xml);
		$this->assertContains('<ns1:AgencyId>' . $agencyId . '</ns1:AgencyId>', $xml);
		$this->assertContains('<ns1:UserIdentifierValue>' . $userId . '</ns1:UserIdentifierValue>', $xml);
		$this->assertContains('<ns1:ItemIdentifierValue>' . $itemId . '</ns1:ItemIdentifierValue>', $xml);
	}

}
