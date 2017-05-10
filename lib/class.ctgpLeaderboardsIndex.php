<?php
// CTGP Leaderboard Functions
// Created by PokeAcer; credit when used.

//Needed for every function:


function get_recent_rkg($num)
{
	$json = file_get_contents('http://tt.chadsoft.co.uk/index.json');
	$jsonarray = json_decode($json, true);
	return file_get_contents("http://tt.chadsoft.co.uk" . $jsonarray["recentRecords"][$num]["href"]);
}

function get_recent_rkg_url($num)
{
	$json = file_get_contents('http://tt.chadsoft.co.uk/index.json');
	$jsonarray = json_decode($json, true);
	return "http://tt.chadsoft.co.uk" . $jsonarray["recentRecords"][$num]["href"];
}

function get_recent_rkg_data($num, $type)
{
	$json = file_get_contents('http://tt.chadsoft.co.uk/index.json');
	$jsonarray = json_decode($json, true);
	return $jsonarray["recentRecords"][$num][$type];
}
?>

