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

if (!extension_loaded('mysql')) {
   if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
       dl('php_mysql.dll');
   } else {
       dl('mysql.so');
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
    $this->persistent=$persistent;
    return 1; //Success.
  }
  function connect()
  {
    if(!$this->host) { $this->host="localhost"; }
    if(!$this->user) { $this->user="root"; }
    if($this->persistent)
    {
      $this->connection_id=mysql_pconnect($this->host, $this->user, $this->pass) or $this->connection_error();
    }
    else
    {
      $this->connection_id=mysql_connect($this->host, $this->user, $this->pass, 1) or $this->connection_error();
    }
    mysql_select_db($this->database, $this->connection_id);
    return $this->connection_id;
  }
  function disconnect()
  {
    if($this->connection_id) { mysql_close($this->connection_id); $this->connection_id=0; return 1; }
    else { return 0; }
  }
  function change_db($database)
  {
    mysql_select_db($database, $this->connection_id);
    $this->database=$database;
  }
  function query($query)
  {
    $this->last_query=$query;
    $this->num_queries++;
    $this->result=mysql_query($this->last_query, $this->connection_id) or $this->query_error();
    return $this->result;
  }
  function fetch_row($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysql_fetch_assoc($result);
  }
  function num_rows($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysql_num_rows($result);
  }
  function insert_id()
  {
    return mysql_insert_id($this->connection_id);
  }
  function connection_error()
  {
    die("<b>FATAL ERROR:</b> Could not connect to database on {$this->host} (".mysql_error().") ");
  }
  
  function query_error()
  {
    die("<b>QUERY ERROR:</b> ".mysql_error()."<br />
    Query was {$this->last_query}");
  }
  function fetch_single($result=0)
  {
    if(!$result) { $result=$this->result; }  
    return mysql_result($result, 0, 0);  
    

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
  function escape($text)
  {
    return mysql_real_escape_string($text, $this->connection_id);
  }
  function affected_rows($conn = NULL)
  {
    return mysql_affected_rows($this->connection_id);
    
  }
  
  
  function anti_inject($campo)
{
    foreach($campo as $key => $val)
    {
        $val = mysql_real_escape_string($val);
        // store it back into the array
        $campo[$key] = $val;
    }
    return $campo; //Returns the the var clean


//the next two lines make sure all post and get vars are filtered through this function
$_POST = anti_inject($_POST);
$_GET = anti_inject($_GET);

  } 

}
?>