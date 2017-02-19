<?php

namespace helpers;

class SoapClientClass {

    const SOAPURL = 'http://10.210.135.11:7171/vivacell/SelfCareAPI?wsdl';

    public static function call($method = null, $data = []) {

        try {
            $client = new \SoapClient(self::SOAPURL, array(
                'version' => SOAP_1_1
            ));

            \models\Log::save([
                'p_type' => 'SelfCareAPI',
                'p_in_out' => 'input',
                'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                'p_method' => $method,
                'p_file' => __FILE__,
                'p_text' =>\helpers\Json::encode( \helpers\Common::cleanPassword($data)),
                'p_error' => 0
            ]);

            $result = $client->__soapCall($method, [$data]);


            if (is_soap_fault($result)) {
                throw new \SoapFault('Failed to get data');
            } else {
                \models\Log::save([
                    'p_type' => 'SelfCareAPI',
                    'p_in_out' => 'output',
                    'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                    'p_method' => $method,
                    'p_file' => __FILE__,
                    'p_text' => \helpers\Json::encode( \helpers\Common::cleanPassword($result)),
                    'p_error' => 0
                ]);
                return $result;
                // echo '<pre>';print_r($result);echo'</pre>';
                // $data = $result->ExchangeRatesByDateResult;
            }
        } catch (\SoapFault $fault) {
             \models\Log::save([
                    'p_type' => 'SelfCareAPI',
                    'p_in_out' => 'output',
                    'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                    'p_method' => $method,
                    'p_file' => __FILE__,
                    'p_text' => \helpers\Json::encode(array("error_code" => \library\Error::SOAPFAILEDCODE, "error_message" => \library\Error::SOAPFAILEDMESSAGE,'soap_object'=>  print_r($fault))),
                    'p_error' => 0
                ]);
            throw new \Exception(\library\Error::SOAPFAILEDMESSAGE, \library\Error::SOAPFAILEDCODE);
        }
    }

}
