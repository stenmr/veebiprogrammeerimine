<?php
class Test
{
    // properties
    private $secretNumber;
    public $publicNumber;

    function __construct($sentValue)
    {
        $this->secretNumber = 10;
        $this->publicNumber = $sentValue * $this->secretNumber;
    }

    function __destruct()
    {
        echo "Klass on valmis";
    }

    public function showValues()
    {
        echo $this->secretNumber . " ja " . $this->publicNumber;
        $this->tellSecret();
    }

    private function tellSecret()
    {
        echo "Klass on peaaegu valma";
    }
}
