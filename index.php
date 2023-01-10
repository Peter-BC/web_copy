<?php

//echo $_SERVER['REQUEST_URI'];
$index = new index;

$index->besave();

class Index
{
    public function besave() {

      //return;
      $targeturl = 'https://www.ttc110.cn/';
      $index_name = 'index.html';

      echo $this->superSaveFile($targeturl, $index_name);
      //echo 161;exit;
    }

    private function superSaveFile($targeturl, $index_name) {

      $filename = explode('?', $_SERVER['REQUEST_URI'])[0];

      $filename1 = $filename == '/' ? $index_name : $filename;
      //echo $targeturl. $filename;exit;

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

  		//如果倒数第4个数是 .  则认为是文件，需要弹出
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
