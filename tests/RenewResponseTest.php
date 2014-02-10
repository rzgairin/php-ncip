<?php namespace Danmichaelo\Ncip;

use Danmichaelo\QuiteSimpleXMLElement\QuiteSimpleXMLElement;

class RenewResponseTest extends \PHPUnit_Framework_TestCase {

	protected $dummy_response_success = '
 		  <ns1:NCIPMessage xmlns:ns1="http://www.niso.org/2008/ncip">
 		     <ns1:RenewItemResponse>
 		        <ns1:ItemId>
 		           <ns1:ItemIdentifierValue>13k112494</ns1:ItemIdentifierValue>
 		        </ns1:ItemId>
 		        <ns1:DateDue>2013-11-11T00:30:35.247+01:00</ns1:DateDue>
 		        <ns1:Ext>
 		           <ns1:UserOptionalFields>
 		              <ns1:UserLanguage>eng</ns1:UserLanguage>
 		           </ns1:UserOptionalFields>
 		        </ns1:Ext>
 		     </ns1:RenewItemResponse>
 		  </ns1:NCIPMessage>';

	protected $dummy_response_fail = '
 		 <ns1:NCIPMessage xmlns:ns1="http://www.niso.org/2008/ncip">
 		   <ns1:RenewItemResponse>
 		      <ns1:Problem>
 		         <ns1:ProblemType>Maximum renewals exceeded.</ns1:ProblemType>
 		         <ns1:ProblemDetail>Maximum renewals exceeded.</ns1:ProblemDetail>
 		      </ns1:Problem>
 		      <ns1:Ext>
 		         <ns1:UserOptionalFields>
 		            <ns1:UserLanguage>eng</ns1:UserLanguage>
 		         </ns1:UserOptionalFields>
 		      </ns1:Ext>
 		   </ns1:RenewItemResponse>
 		</ns1:NCIPMessage>';

	protected $dummy_response_errorneous = '
		<ns1:NCIPMessage ';

	public function testParseDummySuccessResponse() {
		$dummy_response = new QuiteSimpleXMLElement($this->dummy_response_success);
		$response = new RenewResponse($dummy_response);
		$date1 = new \DateTime('2013-11-11T00:30:35+01:00');

		$this->assertInstanceOf('Danmichaelo\Ncip\RenewResponse', $response);
		$this->assertTrue($response->success);
		$this->assertEquals($response->dueDate->getTimestamp(), $date1->getTimestamp());
	}

	public function testParseDummyFailResponse() {
		$dummy_response = new QuiteSimpleXMLElement($this->dummy_response_fail);
		$response = new RenewResponse($dummy_response);

		$this->assertInstanceOf('Danmichaelo\Ncip\RenewResponse', $response);
		$this->assertFalse($response->success);
	}

	public function testParseNullResponse() {
		$response = new RenewResponse(null);

		$this->assertInstanceOf('Danmichaelo\Ncip\RenewResponse', $response);
		$this->assertFalse($response->success);
		$this->assertEquals('Empty response', $response->error);
	}

}