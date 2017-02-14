<?php
class AmazonProductAPI
{

    private $public_key     = "AKIAI2TW3MC7KCEC362Q";
    private $private_key    = "32nPZDVn0JACc9Wjt5Jr8NcA6UvKcsgM4LJETIyx";
    private $associate_tag  = "theongoautoof-20";


    // verifies the response from amazon has a title. Thus is a valid response from Amazon.
    private function verifyXmlResponse($response) {
        if ($response === False) {
            throw new Exception("Could not connect to Amazon");
        } else {
            if (isset($response->Items->Item->ItemAttributes->Title)) {
                return ($response);
            } else {
                throw new Exception("Invalid xml response.");
            }
        }
    }

    private function  generate_aws_request($params) {

        $method = "GET";
        $host = "ecs.amazonaws.com"; // must be in lower case...learned that the hard way.
        $uri = "/onca/xml";


        $params["Service"]          = "AWSECommerceService";
        $params["AWSAccessKeyId"]   = $this->public_key;
        $params["AssociateTag"]     = $this->associate_tag;
        $params["Timestamp"]        = gmdate("Y-m-d\TH:i:s\Z");
        $params["Version"]          = "2011-08-01";

        // This has to happen because amazon does it on their end.  Later, we hash
        // this string and it has to match amazon's string
        ksort($params);

        $canonicalized_query = array();

        foreach ($params as $param=>$value) {
            $param = str_replace("%7E", "~", rawurlencode($param));
            $value = str_replace("%7E", "~", rawurlencode($value));
            $canonicalized_query[] = $param."=".$value;
        }

        $canonicalized_query = implode("&", $canonicalized_query);
        $string_to_sign = $method."\n".$host."\n".$uri."\n".$canonicalized_query;
        $signature = base64_encode(hash_hmac("sha256", $string_to_sign, $this->private_key, True));
        $signature = str_replace("%7E", "~", rawurlencode($signature));
        $request = "http://".$host.$uri."?".$canonicalized_query."&Signature=".$signature;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        $xml_response = curl_exec($ch);

        if ($xml_response === False) {
            return False;
        } else {
            $parsed_xml = simplexml_load_string($xml_response);
            return ($parsed_xml === False) ? False : $parsed_xml;
        }
    }


    public function getProductByAsin($asin_code) {
        // if $responseGroup is parameter,
            // if it's an array, convert from array to canonicalized string
            // set it as the value of $parameters["ResponseGroup"];
        $parameters = array("Operation"     => "ItemLookup",
                            "ItemId"        => $asin_code,
                            "IdType"        => "ASIN",
                            "ResponseGroup" => "Images,ItemAttributes"
                      );

        $xml_response = $this->generate_aws_request($parameters);

        return $this->verifyXmlResponse($xml_response);
    }
}
