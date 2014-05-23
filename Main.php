<?php

define("FILE_PATH", dirname(__FILE__).DIRECTORY_SEPARATOR);
require_once(FILE_PATH . "TextFormat.php");
Main::$startTime = -1 * microtime(true);
console("Initializing PluginBuilder...");
require_once(FILE_PATH . "PluginBuilder.php");
define("F_NOTICE", FORMAT_UNDERLINE . FORMAT_LIGHT_PURPLE);
define("F_WARNING", FORMAT_UNDERLINE . FORMAT_YELLOW);
define("F_ERROR", FORMAT_UNDERLINE . FORMAT_RED);
define("F_IMPORTANT", FORMAT_UNDERLINE . FORMAT_GREEN);
$console = new Console;
$builder = new Main($console);
$builder->start();
console(F_IMPORTANT . "Stopping...");
// usleep(1e+5);
exit(1);

function console($msg, $eol = true){
	echo TextFormat::toANSI(FORMAT_AQUA . date("H:i:s ") . FORMAT_RESET);
	echo TextFormat::toANSI($msg);
	echo TextFormat::toANSI(FORMAT_RESET);
	echo PHP_EOL;
}

class Console{
	public $stream = null;
	public function __construct(){
		if(!extension_loaded("readline")){
			$this->stream = fopen("php://stdin", "r");
		}
	}
	public function readLines(){
		if($this->stream === null){
			$lines = trim(readline("Enter command. Currently at project no-name"/* . Main::getCurrent()->getName()*/ . PHP_EOL . "/"));
		}
		else{
			$lines = trim(fgets($this->stream));
		}
		return $lines;
	}
}

class Main{
	public $running = true;
	public static $startTime;
	public $current;
	public function __construct(Console $console){
		$this->csl = $console;
	}
	public function start(){
		self::$startTime += microtime(true);
		self::$startTime *= 1000;
		console(F_IMPORTANT . "Done! (" . self::$startTime . " ms)");
		while($this->running){
			$line = $this->csl->readLines();
			if(strlen($line)){
				$this->run(explode(" ", $line));
			}
		}
	}
	public function run($args){
		$cmd = array_shift($args);
		$output = "";
		switch($cmd){
			case "init":
				if(!isset($args[0])){
					console("Usage: /init <name>");
					return;
				}
				console("Initialized new project $name.");
				break;
			case "stop":
			case "quit":
			case "exit":
				$this->running = false;
				break;
		}
		console($output);
	}
	public function getCurrent(){
		return $this->current;
	}
}
