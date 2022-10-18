<?php

class Taapi
{
    // Properties
    public $secret;

    function __construct($secret) {
        $this->secret = $secret;
    }

    function execute($indicator, $exchange, $symbol, $interval, $params = array())
    {
        $params["secret"] = $this->secret;

        $params["exchange"] = $exchange;
        $params["symbol"] = $symbol;
        $params["interval"] = $interval;

        $queryString = http_build_query($params);

        $query = "https://api.taapi.io/$indicator?$queryString";
        //echo "The query: '$query'";

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

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $result = json_decode($response);
        }

        return $result;
    }
}
