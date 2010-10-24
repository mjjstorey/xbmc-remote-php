<?php

include "topline.php";
include "config.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, $xbmcjsonservice);

//if argument1 is set, clear playlist
if(!empty($_GET['argument1']))
{
  //clear audio playlist
  $data = '{"jsonrpc": "2.0", "method": "AudioPlaylist.Clear", "id": 1}';
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $array = json_decode(curl_exec($ch),true);

  //clear video playlist
  $data = '{"jsonrpc": "2.0", "method": "VideoPlaylist.Clear", "id": 1}';
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  $array = json_decode(curl_exec($ch),true);
}

//show Audio header
echo "<div id=\"content\"><p>";
echo "AudioPlaylist.GetItems:<br><br>";
echo "</p></div>";

//Get audio playlist
echo "<div id=\"utility\"><ul>";
$audioplaylistdata = '{"jsonrpc": "2.0", "method": "AudioPlaylist.GetItems", "id": 1}';
curl_setopt($ch, CURLOPT_POSTFIELDS, $audioplaylistdata);
$audioplaylistarray = json_decode(curl_exec($ch),true);
$audioplaylistresults = $audioplaylistarray['result'];

//print array
//echo "<pre>";
//echo print_r($audioplaylistresults);
//echo "</pre>";

if(!empty($_GET['argument2']))
{
  //get selected song
  $selectedsong = substr($_GET['argument2'], 4);

  //number of songs to skip or go back
  $backorfoward = $audioplaylistresults['current'] - $selectedsong;

  //check if the song playing is selected
  if ($backorfoward != 0)
  {
    //not same song is selected, choose other song
    if ($backorfoward < 0)
    {
      //set forward
      $forwards = (int)substr($backfoward, 1);
      $y = 1;
      while ($forwards >= $y)
      {
        //audio playlist next
        $data = '{"jsonrpc": "2.0", "method": "AudioPlaylist.SkipNext", "id": 1}';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $array = json_decode(curl_exec($ch),true);
      }
    }
    else
    {
      //set backward
      $backwards = $backfoward;
      $y = 1;
      while ($backwards >= $y)
      {
        //audio playlist previous
        $data = '{"jsonrpc": "2.0", "method": "AudioPlaylist.SkipPrevious", "id": 1}';
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $array = json_decode(curl_exec($ch),true);
      }
    }
  }
  else
  {
   //current playing song is selected, do audio playlist rewind
   $data = '{"jsonrpc": "2.0", "method": "AudioPlayer.Rewind", "id": 1}';
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
   $array = json_decode(curl_exec($ch),true);
  }
}

if (array_key_exists('items', $audioplaylistresults))
{
  //get results of playlist
  $results = $audioplaylistresults['items'];

  //count the number of songs in the selection
  $songcount = count($results);

  //put count on zero
  $i = 0;

  foreach ($results as $value)
  {
    //show music files in playlist where argument2 is songid in playlist
    $inhoud = $value['file'];
    echo "<li><a href=getplaylist.php?argument2=song$i>$inhoud</a></li>\n";
    $i++;
  }
}
echo "</ul></div>";

//break
echo "<br>";

//show video header
echo "<div id=\"content\"><p>";
echo "VideoPlaylist.GetItems:<br><br>";
echo "</p></div>";

//Get video playlist
echo "<div id=\"utility\"><ul>";
$videoplaylistdata = '{"jsonrpc": "2.0", "method": "VideoPlaylist.GetItems", "id": 1}';
curl_setopt($ch, CURLOPT_POSTFIELDS, $videoplaylistdata);
$videoplaylistarray = json_decode(curl_exec($ch),true);
$videoplaylistresults = $videoplaylistarray['result'];

//show video play list items
if (array_key_exists('items', $videoplaylistresults))
{
  $results = $videoplaylistresults['items'];
  foreach ($results as $value)
  {
    $inhoud = $value['file'];
    echo "<li><a href=getplaylist.php?argument2=dosomething>$inhoud</a></li>\n";
  }
}
echo "</ul></div>";

//clear audio playlist
echo "<br>";
echo "<div id=\"utility\"><ul>";
echo "<li><a href=getplaylist.php?argument1=clearplaylist>Clear Playlist</a></li>\n";
echo "</ul></div><br><br>";

include "downline.php";

?>

