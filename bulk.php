<?php

require("construct.php");

class TaapiBulk
{
    // Properties
    public $secret;
    public $outputFormat = "objects";
    public $constructs = array();

    function __construct($secret)
    {
        $this->secret = $secret;
        $this->constructs = array();
    }

    /**
     * Reset constructs
     */
    function initConstructs()
    {
        $this->constructs = array();
    }

    /**
     * Set output format [default, objects]
     */
    function setOutputFormat($outputFormat) {
        $this->outputFormat = $outputFormat;
    }

    /**
     * Add a construct
     */
    function addConstruct($construct)
    {
        array_push($this->constructs, $construct);
    }

    /**
     * Execute: calculate indicator values
     */
    function execute()
    {
        $params["secret"] = $this->secret;

        $query = json_encode(array(
            "secret" => $this->secret,
            "outputFormat" => $this->outputFormat,
            "construct" => count($this->constructs) == 1 ? $this->constructs[0] : $this->constructs
        ));

        $result = null;

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.taapi.io/bulk",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ],
        ]);

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
