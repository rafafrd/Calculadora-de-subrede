<?php

$ip = [192, 168, 1, 100];
$cidr = 14;

// Converter o endereço IP em binário
$ipBinary = [];
foreach ($ip as $octet) {
    $ipBinary[] = str_pad(decbin($octet), 8, '0', STR_PAD_LEFT);
}
$ipBinary = implode('', $ipBinary);

// Construir a máscara de sub-rede em binário
$subnetMaskBinary = str_pad(str_repeat('1', $cidr) . str_repeat('0', 32 - $cidr), 32, '0', STR_PAD_LEFT);

// Realizar a operação de "E lógico" para obter o endereço de rede
$networkBinary = '';
for ($i = 0; $i < 32; $i++) {
    $networkBinary .= $ipBinary[$i] & $subnetMaskBinary[$i];
}

// Converter o endereço de rede de binário de volta para decimal
$network = [];
for ($i = 0; $i < 4; $i++) {
    $network[] = bindec(substr($networkBinary, $i * 8, 8));
}

// Calcular o endereço de broadcast
$broadcastBinary = '';
for ($i = 0; $i < 32; $i++) {
    $broadcastBinary .= $ipBinary[$i] | ($subnetMaskBinary[$i] ^ 1);
}
$broadcast = [];
for ($i = 0; $i < 4; $i++) {
    $broadcast[] = bindec(substr($broadcastBinary, $i * 8, 8));
}

// Calcular o primeiro host
$firstHostBinary = substr_replace($networkBinary, '1', -1);
$firstHost = [];
for ($i = 0; $i < 4; $i++) {
    $firstHost[] = bindec(substr($firstHostBinary, $i * 8, 8));
}

// Calcular o último host
$lastHostBinary = substr_replace($broadcastBinary, '0', -1);
$lastHost = [];
for ($i = 0; $i < 4; $i++) {
    $lastHost[] = bindec(substr($lastHostBinary, $i * 8, 8));
}

// Calcular o número máximo de hosts
$maxHosts = pow(2, 32 - $cidr) - 2;

// Exibir os resultados
echo "Endereço IP: " . implode('.', $ip) . "<br>";
echo "Máscara de Sub-rede: " . long2ip(ip2long('255.255.255.255') << (32 - $cidr)) . " (/$cidr)<br>";
echo "Endereço de Rede: " . implode('.', $network) . "<br>";
echo "Broadcast: " . implode('.', $broadcast) . "<br>";
echo "Primeiro Host: " . implode('.', $firstHost) . "<br>";
echo "Último Host: " . implode('.', $lastHost) . "<br>";
echo "Número Máximo de Hosts: " . $maxHosts . "<br>";

?>
