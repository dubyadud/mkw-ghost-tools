<?php
// Wiimmfi Competition Library.
// Credit PokeAcer549 when used!

function generate_UUID() {
        return str_replace(
                array('+','/','='),
                array('-','_',''),
                base64_encode(file_get_contents('/dev/urandom', 0, null, -1, 8))
        );
}

function get_competition_text($region, $id) {
// ID check
switch $id {
case ''
	$id = '9999999999999990';
	break;
default:
	break;
}

// ID check
switch $region {
case ''
	$region = 'eu_en';
	break;
default:
	break;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://mariokartwii.race.gs.wiimmfi.de/raceservice/messagedl_".$region.".ashx");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'User-Agent: WiiConnect24/2.0.3.1', // IOS 80, used by Sys Menu 4.3
        'X-Wii-Id: w'.$id
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

// Store in a temp file
$file = fopen('temp.txt', 'w');
fwrite($file, $server_output);
fclose($file);

// Remove all the unwanted lines
$trim = shell_exec('tail -n +27 temp.txt | head -n -521 > temp2.txt');

// Decode base64 into text
$b64 = file_get_contents('temp2.txt');
$utf16be = base64_decode($b64);
$text = mb_convert_encoding($utf16be , 'UTF-8' , 'UTF-16');

// Remove temp files
unlink('temp.txt');
unlink('temp2.txt');

return $text;
}

function get_competition_text($region, $id) {
// ID check
switch $id {
case ''
	$id = '9999999999999990';
	break;
default:
	break;
}

// ID check
switch $region {
case ''
	$region = 'eu_en';
	break;
default:
	break;
}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://mariokartwii.race.gs.wiimmfi.de/raceservice/messagedl_".$region.".ashx");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'User-Agent: WiiConnect24/2.0.3.1', // IOS 80, used by Sys Menu 4.3
        'X-Wii-Id: w'.$id
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

return $server_output;
}

function get_competition_bin($region, $id) {

// ID check
switch $id {
case ''
	$id = '9999999999999990';
	break;
default:
	break;
}

// ID check
switch $region {
case ''
	$region = 'eu_en';
	break;
default:
	break;
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://mariokartwii.race.gs.wiimmfi.de/raceservice/maindl_".$region.".ashx");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'User-Agent: WiiConnect24/2.0.3.1', // IOS 80, used by Sys Menu 4.3
        'X-Wii-Id: w'.$id
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

return $server_output;
}

function save_competition_bin($region, $id) {
$uuid = generate_UUID();

// ID check
switch $id {
case ''
	$id = '9999999999999990';
	break;
default:
	break;
}

// ID check
switch $region {
case ''
	$region = 'eu_en';
	break;
default:
	break;
}


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://mariokartwii.race.gs.wiimmfi.de/raceservice/maindl_".$region.".ashx");
curl_setopt($ch, CURLOPT_POST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    'User-Agent: WiiConnect24/2.0.3.1', // IOS 80, used by Sys Menu 4.3
        'X-Wii-Id: w'.$id
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

$file = fopen($uuid.'.bin', 'w');
fwrite($file, $server_output);
fclose($file);

return $uuid.'.bin';
}