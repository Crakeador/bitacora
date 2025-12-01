<?php
$ip = "192.168.0.189";
$port = "81";
$user = "admin";
$pass = "Latinamerica135";

$url = "http://$ip:$port/ISAPI/System/TwoWayAudio/channels/1/open";
$xml = '<TwoWayAudioChannel><enabled>true</enabled></TwoWayAudioChannel>';

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_USERPWD => "$user:$pass",
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_HTTPHEADER => ["Content-Type: application/xml"],
    CURLOPT_POSTFIELDS => $xml,
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($ch);
curl_close($ch);

echo "Audio activado";
?>