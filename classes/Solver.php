<?php

    use JetBrains\PhpStorm\NoReturn;

    class Solver
    {
        protected static ?Solver $instance = null;
        public int $day;
        public int $part;
        public bool $testMode;
        public float $start;
        public string $result = '';

        protected function __construct()
        {
            global $argv;
            $this->day = $argv[1];
            $this->part = $argv[2];
            $this->testMode = isset($argv[3]) && $argv[3] === 'test';
        }

        protected function __clone()
        {
        }

        public static function getInstance(): Solver
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        #[NoReturn]
        public function solve(){
            $solver = Solver::getInstance();
            $solver->start = microtime(true);
            include './day'.$solver->day.'/part'.$solver->part.'.php';
            $solver->render();
        }

        public function render()
        {
            $solver = Solver::getInstance();
            echo 'Solution: '.$solver->result;
            echo ' | ';
            echo 'Execution time: '.number_format((microtime(true) - $solver->start)*1000, 4).'ms';
            die;
        }
        public static function stop()
        {
            $solver = Solver::getInstance();
            $solver->render();
        }

        public static function getInput(): string
        {
            $solver = Solver::getInstance();
            return trim(file_get_contents('./day'.$solver->day.'/input'.($solver->testMode ? '_test' : '').'.txt'));
        }

        public static function setResult(string $result){
            $solver = Solver::getInstance();
            $solver->result = $result;
        }

    }
