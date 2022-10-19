<?php

class TaapiSingle
{
    // Properties
    public $secret;

    function __construct($secret)
    {
        $this->secret = $secret;
    }

    /**
     * Execute: calculate indicator
     */
    function execute($indicator, $exchange, $symbol, $interval, $params = array())
    {
        $params["secret"] = $this->secret;

        $params["exchange"] = $exchange;
        $params["symbol"] = $symbol;
        $params["interval"] = $interval;

        $queryString = http_build_query($params);

        $query = "https://api.taapi.io/$indicator?$queryString";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

        $result = null;

        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Check HTTP status code
        if (!curl_errno($curl)) {
            switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                case 200:  # OK
                    if ($err) {
                        echo "cURL Error #:" . $err;
                    } else {
                        $result = json_decode($response);
                    }
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n", $response;
            }
        }

        curl_close($curl);

        return $result;
    }
}
