<?php
namespace helpers;

class SoapClientClass
{
	const SOAPURL = 'http://10.210.135.11:7171/vivacell/SelfCareAPI?wsdl'; 
	public static function call($method = null,$data  = []){
		
		 try {
                $client = new \SoapClient(self::SOAPURL, array(
                              'version' => SOAP_1_1
                      ));
					  
					  

                      $result = $client->__soapCall($method, [$data]);


                      if (is_soap_fault($result)) {
                              throw new Exception('Failed to get data');
                      } else {
						    echo '<pre>';print_r($result);echo'</pre>';
                             // $data = $result->ExchangeRatesByDateResult;
                      }
                      
                     
              } catch (Exception $e) {
                      $error = 'Message: ' . $e->getMessage() . "\nTrace:" . $e->getTraceAsString();
              }
	}
}