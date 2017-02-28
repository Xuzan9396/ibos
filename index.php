<?php
   /**
 * 生成scv的类
 * @autor xuzan
 * email  gitxuzan@126.com
 * phone  13265000805
 */
   require_once './csv.class.php';
   define('URL', 'http://ibos.com.cn');
   $curl = new CSV(URL);
   $curl->curlField();







