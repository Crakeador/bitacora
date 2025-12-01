<?php
$ip = "192.168.0.189";
$port = "81";
$user = "admin";
$pass = "Latinamerica135";

$url = "http://$ip:$port/ISAPI/IO/outputs/1/trigger";
$xml = '<IOPortData><outputState>low</outputState></IOPortData>';

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

echo "Barrera desactivada";
?>