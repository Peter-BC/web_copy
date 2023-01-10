<?php

//Author : Peter Shaw
//This code can capture target website and save all resoureces, include .js, .css. etc.
// you just set $taegeturl, and open this page in browser, remember every page please refresh 3 times!

$index = new index;
$index->besave();

class Index
{
    public function besave() {

      $targeturl = 'https://dogecoin.com/';
      echo $this->superSaveFile($targeturl);

    }

    private function superSaveFile($targeturl) {

      $filename = explode('?', $_SERVER['REQUEST_URI'])[0];
      $filename = explode('#', $filename)[0];

      $filename1 = $filename == '/' ? 'index.html' : $filename;

      if (substr($filename1, -1) == '/') {
        $filename1 = $filename1. 'index.html';
      }
      //echo $targeturl. $filename1;exit;

      $retname = $this->createDir($filename1);
      if (is_file($retname)) {
        return file_get_contents($retname);
      }
      if ($retname) {
        $fcon = file_get_contents($targeturl. $filename);
        $fp = fopen($retname, 'w');
        if (!fwrite($fp, $fcon)) {
            return 0;
        }
      }
    }
    private  function createDir($cacheName, $root = '') {
      $root = $root ? $root : str_replace('\\', '/', realpath(dirname(__FILE__)));

  		$cacheName = str_replace('\\', '/', $cacheName);
  		$path = str_replace($root, '', $cacheName);

  		$apath = explode('/', $path);

  		//If the 3, 4, 5, 6th last digit is '.' Is considered to be a file, pop it.
      $sname = '';
  		if (substr(end($apath), -3, 1) === '.' || substr(end($apath), -4, 1) === '.' || substr(end($apath), -5, 1) === '.'|| substr(end($apath), -6, 1) === '.') {
  			$sname = array_pop($apath);
  		}

  		if (is_dir($root. implode('/', $apath))) {
  			return $root. implode('/', $apath) . ($sname ? '/'.$sname : '');
  		}

  		$subPath = array();
  		foreach ($apath as $ph) {
  			$subPath[] = $ph;
  			if (!is_dir($root. implode('/', $subPath))) {

  				if (!mkdir(($root. implode('/', $subPath)), 777)) {
  					exit($root.implode('/', $subPath). ' can`t to create');
  				}
  				@chown(($root. implode('/', $subPath)), 'www');
  			}
  		}
  		return $root. implode('/', $apath) .'/'.$sname;
  	}
  }
