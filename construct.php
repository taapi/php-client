<?php

class TaapiConstruct
{
    // Properties
    public $exchange;
    public $symbol;
    public $interval;
    public $indicators = array();

    function __construct($exchange, $symbol, $interval)
    {
        $this->exchange = $exchange;
        $this->symbol = $symbol;
        $this->interval = $interval;
    }

    /**
     * Reset indicators
     */
    function initIndicators()
    {
        $this->indicators = array();
    }

    /**
     * Add an indicator along with parameters
     */
    function addIndicator($indicator, $params = array())
    {
        $params["indicator"] = $indicator;

        array_push($this->indicators, $params);
    }

    /**
     * Generate construct
     */
    function generate() {
        $construct = array(
            "exchange" => $this->exchange,
            "symbol" => $this->symbol,
            "interval" => $this->interval,
            "indicators" => $this->indicators
        );

        return $construct;
    }
}
