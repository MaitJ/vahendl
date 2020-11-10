<?php

    class Generic {
        //muutujad, klassis omadused (Properties)
        private $mysecret;
        public $yoursecret;

        function __construct($secretlimit) {
            $this->mysecret = mt_rand(0, $secretlimit);
            $this->yoursecret = mt_rand(0, 100);
            echo "Loositud arvude korrutis on: " . $this->mysecret * $this->yoursecret;
            echo "\n mysecret:" . $this->tellSecret();
        }

        //Funktsioonid, klassis meetodid (methods)
        private function tellSecret() {
            return $this->mysecret;
        }

        public function tellMySecret() {
            return $this->mysecret;
        }

        public function __destruct() {
            echo " __destructi k2ivitus";
        }
    }