<?php

Class Currency_robot extends CI_Model
{
    // Search info in API
    public function getInfoFromApis()
    {
        $data = [];

        //CurrencyLayer ($)
        array_push($data, $this->getInfoFromCurrencyLayer());

        //Bluelytics (free)
        array_push($data, $this->getInfoFromBluelytics());
        // BLUELYTICS NO ESTA DEVOLVIENDO INFO ACTUALIZADA VER!!!

        //LaNacion
        array_push($data, $this->getInfoFromLaNacion());

        //Geeklab
        array_push($data, $this->getInfoFromGeeklab());

        //Yahoo
        array_push($data, $this->getInfoFromYahoo());

        //Openexchangerates
        array_push($data, $this->getInfoFromOpenexchangerates());

        // Calculate the avg for all resources.
        $avg = $this->calculateAvgFromAllResources($data);

        // Show results
        /*echo "<pre>";
        var_export($data);
        echo "</pre>";
        */
        echo "<pre>";
        echo "<br> ------ RESULTADO -----";
        var_dump($avg);
        echo "</pre>";
    }

    /*
    GET INFO FROM "CURRENCY LAYER API"
    URL: http://apilayer.net
    FREE: True
    UNLIMITED: No, 1000 calls per Month is the limit. :(
    */
    function getInfoFromCurrencyLayer()
    {
        // Get api_key from config and set API Endpoint and access key (and any options of your choice)
        $api = 'currencyLayer';
        $access_key = $this->config->item('currency_apis_keys')[$api];

        // Set URL to be used with curl
        $curl_data['url'] = 'http://apilayer.net/api/live?access_key='.$access_key.'&currencies=USD,ARS,BRL';
        //$curl_data['url'] = 'http://localhost/brasil/json_temp/apilayer.json';

        // Call url from Curl
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'json');

        //Return info
        $data[$api]['source'][$api]['USDARS'] = $exchangeRatesArr['quotes']['USDARS'];
        $data[$api]['source'][$api]['USDBRL'] = $exchangeRatesArr['quotes']['USDBRL'];
        $data[$api]['source'][$api]['source'] = $api;
        $data[$api]['source'][$api]['datetime'] = date("Y-m-d H:i:s");
        $data[$api]['api_url'] = $curl_data['url'];
        return $data;
    }

    /*
    GET INFO FROM "BLUELYTICS"
    URL: http://bluelytics.com.ar/#/
    FREE: True
    UNLIMITED: Yes :)
    */
    function getInfoFromBluelytics()
    {
        // Set the api name
        $api = 'bluelytics';

        // Set URL to be used with curl
        $curl_data['url'] = 'http://api.bluelytics.com.ar/json/last_price';

        // Call url from Curl
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'json');

        // Walk between all sources
        foreach ($exchangeRatesArr as $resource) {
            //Return info
            if ($resource['source'] != 'la_nacion') { //la_nacion está muy desactualizada en esta api, no la tomamos.
                $data[$api]['source'][$resource['source']]['USDARS'] = $resource['value_avg'];
                $data[$api]['source'][$resource['source']]['USDBRL'] = 0;
                $data[$api]['source'][$resource['source']]['datetime'] = date("Y-m-d H:i:s");
            }
        }
        $data[$api]['api_url'] = $curl_data['url'];

        return $data;
    }

    /*
    GET INFO FROM "LA NACION"
    URL: http://contenidos.lanacion.com.ar
    FREE: True
    UNLIMITED: Yes :)
    */
    function getInfoFromLaNacion()
    {
        // Get api_key from config and set API Endpoint and access key (and any options of your choice)
        $api = 'laNacion';

        // Set URL to be used with curl
        $curl_data['url'] = 'http://contenidos.lanacion.com.ar/json/dolar';

        // Call url from Curl
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'jsonp');

        //Return info
        $data[$api]['source'][$api]['USDARS'] = $exchangeRatesArr['CasaCambioVentaValue'];
        $data[$api]['source'][$api]['USDBRL'] = 0;
        $data[$api]['source'][$api]['source'] = $api;
        $data[$api]['source'][$api]['datetime'] = date("Y-m-d H:i:s");
        $data[$api]['api_url'] = $curl_data['url'];
        return $data;
    }

    /*
    GET INFO FROM "GEEKLAB"
    URL: http://ws.geeklab.com.ar
    FREE: True
    UNLIMITED: Yes :)
    */
    function getInfoFromGeeklab()
    {
        // Get api_key from config and set API Endpoint and access key (and any options of your choice)
        $api = 'geeklab';

        // Set URL to be used with curl
        $curl_data['url'] = 'http://ws.geeklab.com.ar/dolar/get-dolar-json.php';

        // Call url from Curl
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'json');

        //Return info
        $data[$api]['source'][$api]['USDARS'] = $exchangeRatesArr['libre'];
        $data[$api]['source'][$api]['USDBRL'] = 0;
        $data[$api]['source'][$api]['source'] = $api;
        $data[$api]['source'][$api]['datetime'] = date("Y-m-d H:i:s");
        $data[$api]['api_url'] = $curl_data['url'];
        return $data;
    }

    /*
    GET INFO FROM "YAHOO"
    URL: http://query.yahooapis.com
    FREE: True
    UNLIMITED: Yes :)
    */
    function getInfoFromYahoo()
    {
        // Get api_key from config and set API Endpoint and access key (and any options of your choice)
        $api = 'yahooapis';

        // Set URL to be used with curl
        $curl_data['url'] = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20(%20%22USDARS%22,%20%22USDBRL%22)&env=store://datatables.org/alltableswithkeys';

        // Call url from Curl
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'xml');

        // Get the values of USDARS and USDBRL
        foreach ($exchangeRatesArr->results->rate as $rate) {
            $currency = (string)$rate->Name;
            $pattern = '/\//i';
            $replacement = '';
            $currency = preg_replace($pattern, $replacement, $currency);
            $results_arr[$currency] = $rate->Rate;
        }

        //Return info
        $data[$api]['source'][$api]['USDARS'] = $results_arr['USDARS'];
        $data[$api]['source'][$api]['USDBRL'] = $results_arr['USDBRL'];
        $data[$api]['source'][$api]['source'] = $api;
        $data[$api]['source'][$api]['datetime'] = date("Y-m-d H:i:s");
        $data[$api]['api_url'] = $curl_data['url'];
        return $data;
    }

    /*
    GET INFO FROM "YAHOO"
    URL: http://query.yahooapis.com
    FREE: True
    UNLIMITED: Yes :)
    */
    function getInfoFromOpenexchangerates()
    {
        // Get api_key from config and set API Endpoint and access key (and any options of your choice)
        $api = 'openexchangerates';
        $access_key = $this->config->item('currency_apis_keys')[$api];

        // Set URL to be used with curl
        $curl_data['url'] = 'https://openexchangerates.org/api/latest.json?app_id=' . $access_key;

        // Call url from Curl
        $isHttps = true;
        $exchangeRatesArr = $this->getInfoCurl($curl_data, 'json', $isHttps);

        //Return info
        $data[$api]['source'][$api]['USDARS'] = $exchangeRatesArr['rates']['ARS'];
        $data[$api]['source'][$api]['USDBRL'] = $exchangeRatesArr['rates']['BRL'];
        $data[$api]['source'][$api]['source'] = $api;
        $data[$api]['source'][$api]['datetime'] = date("Y-m-d H:i:s");
        $data[$api]['api_url'] = $curl_data['url'];
        return $data;
    }

    function getInfoCurl($curl_data, $format, $isHttps = false)
    {
        // Initialize CURL:
        $ch = curl_init($curl_data['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($isHttps) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        // Store the data:
        $curlResults = curl_exec($ch);
        curl_close($ch);

        //Check if response is a jsonp and get only the object
        switch ($format) {
            case 'json':
                // Decode JSON response:
                $exchangeRatesArr = json_decode($curlResults, true);
                break;
            case 'jsonp':
                $matches = array();
                preg_match('/\{.*\}/', $curlResults, $matches);
                $curlResults = $matches[0];
                // Decode JSON response:
                $exchangeRatesArr = json_decode($curlResults, true);
                break;
            case 'xml':
                // Decode XML response:
                $xml = new SimpleXMLElement($curlResults);
                $exchangeRatesArr = $xml;
                break;
            default:
                # code...
                break;
        }

        return $exchangeRatesArr;
    }

    function calculateAvgFromAllResources($data)
    {
        $this->countResourcesARS = 0;
        $this->countResourcesBRL = 0;
        $this->sumARS = 0;
        $this->sumBRL = 0;
        $this->dataAvg = [];
        array_walk_recursive($data, function ($item, $key)
        {
            //echo "<br>$key has $item\n";
            if ($key === 'USDARS'  && $item > 0) {
                $this->countResourcesARS++;
                $this->sumARS += $this->stringToFloatNumberConverter($item);
            } else if ($key === 'USDBRL' && $item > 0) {
                $this->countResourcesBRL++;
                $this->sumBRL += $this->stringToFloatNumberConverter($item);
            }
        });
        $this->countResourcesARS = ($this->countResourcesARS == 0) ? 1 : $this->countResourcesARS;
        $this->countResourcesBRL = ($this->countResourcesBRL == 0) ? 1 : $this->countResourcesBRL;
        $this->dataAvg['ARS'] = ($this->sumARS / $this->countResourcesARS);
        $this->dataAvg['BRL'] = ($this->sumBRL / $this->countResourcesBRL);
        //echo "<br>Ars " . $this->sumARS . ' / ' . $this->countResourcesARS . ' = ' . $this->dataAvg['ARS'] . '<br>';
        //echo "Brl " . $this->sumBRL . ' / ' . $this->countResourcesBRL . ' = ' . $this->dataAvg['BRL'] . '<br>';

        return $this->dataAvg;
    }

    function stringToFloatNumberConverter($string)
    {
        $pattern = '/,/i';
        $replacement = '.';
        $number = (float) preg_replace($pattern, $replacement, $string);

        return $number;
    }
}

?>