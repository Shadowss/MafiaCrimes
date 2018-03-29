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

class bbcode_engine {
var $parsings=array();
var $htmls=array();
function simple_bbcode_tag($tag="")
{

if (! $tag)
{
break;
}
$this->parsings[]="/\[".$tag."\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$tag.">\\1</".$tag.">";
}
function adv_bbcode_tag($tag="",$reptag="")
{

if (!$tag)
{
break;
}

$this->parsings[]="/\[".$tag."\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$reptag.">\\1</".$reptag.">";
}

function simple_option_tag($tag="",$optionval="")
{
      
if ($tag=="" || $optionval=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$tag." ".$optionval."='\\1'>\\2</".$tag.">";
}

function adv_option_tag($tag="",$reptag="",$optionval="")
{
      
if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$reptag." ".$optionval."='\\1'>\\2</".$reptag.">";
}
function adv_option_tag_em($tag="",$reptag="",$optionval="")
{
      
if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$reptag." ".$optionval."='mailto:\\1'>\\2</".$reptag.">";
}

function simp_option_notext($tag="",$optionval="")
{
      
if ($tag=="" || $optionval=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\]/";
$this->htmls[]="<".$tag." ".$optionval."='\\1' />";
}
function adv_option_notext($tag="",$reptag="",$optionval="")
{
      
if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\]/";
$this->htmls[]="<".$reptag." ".$optionval."='\\1' />";
}
function adv_option_notext_em($tag="",$reptag="",$optionval="")
{
      
if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."=(.+?)\]/";
$this->htmls[]="<".$reptag." ".$optionval."='mailto:\\1' >\\1</".$reptag.">";
}

function simp_bbcode_att($tag="",$optionval="")
{

if ($tag=="" || $optionval=="")
{
break;
}
$this->parsings[]="/\[".$tag."\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$tag." ".$optionval."='\\1' />";
}
function adv_bbcode_att($tag="",$reptag="",$optionval="")
{

if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$reptag." ".$optionval."='\\1' />";
}
function adv_bbcode_att_em($tag="",$reptag="",$optionval="")
{

if ($tag=="" || $optionval=="" || $reptag=="")
{
break;
}
$this->parsings[]="/\[".$tag."\](.+?)\[\/".$tag."\]/";
$this->htmls[]="<".$reptag." ".$optionval."='mailto:\\1'>\\1</".$reptag.">";
}


function cust_tag($bbcode="",$html="")
{

if ($bbcode == "" || $html == "")
{
break;
}
$this->parsings[]=$bbcode;
$this->htmls[]=$html;
}

function parse_bbcode($text)
{

$i=0;
while($this->parsings[$i])
{

$text=preg_replace($this->parsings[$i],$this->htmls[$i],$text);
$i++;
}		
return $text;
}
function export_parsings()
{
return $this->parsings;
}
function export_htmls()
{
return $this->htmls;
}
}

?>
