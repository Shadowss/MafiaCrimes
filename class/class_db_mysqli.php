<?php
  
/**************************************************************************************************
| Software Name        : Ravan Scripts Online Mafia Game
| Software Author      : Ravan Soft Tech
| Software Version     : Version 2.0.1 Build 2101
| Website              : http://www.ravan.info/
| E-mail               : support@ravan.info
|**************************************************************************************************
| The source files are subject to the Ravan Scripts End-User License Agreement included in License Agreement.html
| The files in the package must not be distributed in whole or significant part.
| All code is copyrighted unless otherwise advised.
| Do Not Remove Powered By Ravan Scripts without permission .         
|**************************************************************************************************
| Copyright (c) 2010 Ravan Scripts . All rights reserved.
|**************************************************************************************************/

if(!defined('MONO_ON')) { exit; }

if (!extension_loaded('mysqli')) {
   if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
       dl('php_mysqli.dll');
   } else {
       dl('mysqli.so');
   }
}

class database {
  var $host;
  var $user;
  var $pass;
  var $database;
  var $persistent=0;
  var $last_query;
  var $result;
  var $connection_id;
  var $num_queries=0;
  var $start_time;
  function configure($host, $user, $pass, $database, $persistent=0)
  {
    $this->host=$host;
    $this->user=$user;
    $this->pass=$pass;
    $this->database=$database;
    return 1; //Success.
  }
  function connect()
  {
    if(!$this->host) { $this->host="localhost"; }
    if(!$this->user) { $this->user="root"; }
    $this->connection_id=mysqli_connect($this->host, $this->user, $this->pass) or $this->connection_error();
    mysqli_select_db($this->connection_id, $this->database);
    return $this->connection_id;
  }
  function disconnect()
  {
    if($this->connection_id) { mysqli_close($this->connection_id); $this->connection_id=0; return 1; }
    else { return 0; }
  }
  function change_db($database)
  {
    mysqli_select_db($this->connection_id, $database);
    $this->database=$database;
  }
  function query($query)
  {
    $this->last_query=$query;
    $this->num_queries++;
    $this->result=mysqli_query($this->connection_id, $this->last_query) or $this->query_error();
    return $this->result;
  }
  function fetch_row($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysqli_fetch_assoc($result);
  }
  function num_rows($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysqli_num_rows($result);
  }
  function insert_id()
  {
    return mysqli_insert_id($this->connection_id);
  }
  function connection_error()
  {
    die("<b>FATAL ERROR:</b> Could not connect to database on {$this->host} (".mysqli_connect_error().")");
  }
  function query_error()
  {
    die("<b>QUERY ERROR:</b> ".mysqli_error()."<br />
    Query was {$this->last_query}");
  }
  function fetch_single($result=0)
  {
    if(!$result) { $result=$this->result; }
    //Ugly hack here
    mysqli_data_seek($result, 0);
    $temp=mysqli_fetch_array($result);
    return $temp[0];
  }
  function event_add($user, $event)
  {
    //event should be pre-escaped.
    $this->query("INSERT INTO `event` VALUES('', {$user}, '{$event}', unix_timestamp(), 0)");
    $this->query("INSERT INTO `event_log` VALUES('', {$user}, '{$event}', unix_timestamp())");
    $this->query("UPDATE `user` SET new_events=new_events+1 WHERE userid={$user}");
  }
  function mymicro()
  {
    $m=explode(" ", microtime());
    return $m[0]+$m[1];
  }
  function clock_start()
  {
    $this->start_time=$this->mymicro();
  }
  function clock_end()
  {
    $t=$this->mymicro();
    return round($t-$this->start_time, 4);
  }
  function clean_input($in)
  {
    $in=stripslashes($in);
    return str_replace(array("<",">",'"',"'","\n"), array("&lt;","&gt;","&quot;","&#39;","<br />"), $in);
  }
  function clean_input_nohtml($in)
  {
    $in=stripslashes($in);
    return str_replace(array("'"), array("&#39;"), $in);
  }
  function clean_input_nonform($in)
  {
    return addslashes($in);
  }
  function easy_insert($table, $data)
  {
    $query="INSERT INTO `$table` (";
    $i=0;
    foreach($data as $k => $v)
    {
      $i++;
      if($i > 1) { $query.=", "; }
      $query.=$k;
    }
    $query.=") VALUES(";
    $i=0;
    foreach($data as $k => $v)
    {
      $i++;
      if($i > 1) { $query.=", "; }
      $query.="'".addslashes($v)."'";
    }
    $query.=")";
    return $this->query($query);
  }
  function make_integer($str, $positive=1)
  {
  $str = (string) $str;
  $ret = "";
  for($i=0;$i<strlen($str);$i++)
  {
    if((ord($str[$i]) > 47 && ord($str[$i]) < 58) or ($str[$i]=="-" && $positive == 0)) { $ret.=$str[$i]; }
  }
  if(strlen($ret) == 0) { return "0"; }
  return $ret;
  }
  function unhtmlize($text)
  {
    return str_replace("<br />","\n", $text);
  }  


}
?>