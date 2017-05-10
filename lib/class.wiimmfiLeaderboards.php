<?php
function get_wiimmfi_top10($num)
{
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL,"http://mariokartwii.race.gs.wiimmfi.de/RaceService/NintendoRacingService.asmx");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '<?xml version="1.0" encoding="UTF-8"?><SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:ns1="http://gamespy.net/RaceService/"><SOAP-ENV:Body><ns1:GetTopTenRankings><ns1:gameid>1687</ns1:gameid><ns1:regionid>0</ns1:regionid><ns1:courseid>'.$num.'</ns1:courseid></ns1:GetTopTenRankings></SOAP-ENV:Body></SOAP-ENV:Envelope>');
curl_setopt($ch,CURLOPT_USERAGENT,'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


$headers = [
	'User-Agent: mkw-ghost-tools by PokeAcer549: http://github.com/PokeAcer549/mkw-ghost-tools',
    'SOAPAction: "http://gamespy.net/RaceService/GetTopTenRankings"'
];

curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$server_output = curl_exec ($ch);

curl_close ($ch);

$xml = simplexml_load_string($server_output); 

return $xml;
}
?>
