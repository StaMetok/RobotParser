<?php

use QL\Contracts\PluginContract;
use QL\QueryList;

class RobotParser implements PluginContract{

	public $url;

public static function install(QueryList $queryList,...$opt)
    {
        //In this method to implement your `bind`
        $queryList->bind($url,function($url){
            // $this is the current QueryList object
          return new CurlMulti($this);;
        });
    }

	public function __construct($url)
    {
    	$url = $url . "/robots.txt";
    	$this->url = $url; 
    }
	public function getRobots()
		{
			$fileOpen = fopen($this->url,"r");
			$robot = null;
			$allRobots = [];
			while (($line = fgets($fileOpen)) != false)
				{
					echo $line . "<br>";
					if (preg_match("/user-agent.*/i", $line) ){
                if($robot != null){
                  array_push($allRobots, $robot);
                }

                $robot = new stdClass();
                $robot->userAgent = [];
                $robot->userAgent = explode(':', $line, 2)[1];
                $robot->disAllow = [];
                $robot->allow = [];


              }
            if (preg_match("/disallow.*/i", $line)){
              array_push($robot->disAllow, explode(':', $line, 2)[1]);
            }
            else if (preg_match("/^allow.*/i", $line)){
              array_push($robot->allow, explode(':', $line, 2)[1]);
           }

			}
			var_dump($line);
				if($robot != null)
				{
            		array_push($allRobots, $robot);
          		}
		}	
		
}
