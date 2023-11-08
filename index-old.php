<?php

$host = [10, 122, 17, 10];
$cidr = 30;

function cidrParaIpv4($cidr) {
    $ipBits = array();
    $ipDecimal = array();

    for ($i = 0; $i < $cidr; $i++) {
        if ($i % 8 == 0) {
            // Adicione um novo item na matriz quando o índice for múltiplo de 8
            $ipBits[] = '1';
        } else {
            // Adicione "1" à posição existente
            $ipBits[count($ipBits) - 1] .= '1';
        }
    }

    # verifica se o array tem 4 itens e adiciona e não tiver
    while (sizeof($ipBits) < 4) {
        array_push($ipBits, '');
    }

    # verifica se o item do array tem 8 caracteres e adiciona o 0 caso não houver
    for ($i = 0; $i < count($ipBits); $i++) {
        while (strlen($ipBits[$i]) < 8) {
            $ipBits[$i] .= "0";
        }

        # faz a conversão para inteiro depois para decimal
        $inteiro = intval($ipBits[$i]);
        $decimal = bindec($inteiro);
        $ipDecimal[$i] = $decimal;
    }

    return $ipDecimal;
}

// Exemplo de valores para o array $ipDecimal
$maskIpv4 = cidrParaIpv4($cidr);

// Inicializa o array $possibleHosts
$possibleHosts = [];

// Itera sobre cada item do array $maskIpv4
foreach ($maskIpv4 as $value) {
    // Calcula o valor para o novo array
    $result = 255 - $value;
    
    // Adiciona o resultado ao array $possibleHosts
    $possibleHosts[] = $result;
}

// Exibe o array $possibleHosts
// echo "<br>Possible hosts:";
// print_r($possibleHosts);

########################################################################

// Valores iniciais para o array $broadcast

// TODO: fazer a conversao do host digitado pelo broadcast em array
$broadcast = $host;

// Loop para atualizar o array $broadcast
for ($i = 0; $i < count($possibleHosts); $i++) {
    if ($possibleHosts[$i] !== 0) {
        $broadcast[$i] = $possibleHosts[$i];
    }
}

// Exibe o array $broadcast atualizado
echo "<br>Broadcast:";
print_r($broadcast);

########################################################################

// Inicializa o array $network
$network = [];

// Loop para calcular os valores em $network
for ($i = 0; $i < count($broadcast); $i++) {
    $network[] = $broadcast[$i] - $possibleHosts[$i];
}

// Exibe o array $network
echo "<br>Network:";
print_r($network);

#######################################################################

// Cálculo para obter o total de hosts
$totalHosts = pow(2, (32 - $cidr)) - 2;

echo "<br>Número máximo de hosts: $totalHosts";

#######################################################################

// Criação do array $hostMin
$hostMin = $network;
$hostMin[count($hostMin) - 1] += 1; // Acrescenta 1 ao último item

// Criação do array $hostMax
$hostMax = [];
for ($i = 0; $i < count($network); $i++) {
    $hostMax[] = $network[$i] + $possibleHosts[$i]; // Soma os valores correspondentes
}
$hostMax[count($hostMax) - 1] -= 1; // Diminui 1 ao último item

// Exibe os arrays $hostMin e $hostMax
echo "<br>hostMin: ";
print_r($hostMin);
echo "<br>hostMax: ";
print_r($hostMax);


######################################################################
echo "<br><br>--------------------";
echo "<br>Endereço: $host[0].$host[1].$host[2].$host[3]";
echo "<br>Máscara: $maskIpv4[0].$maskIpv4[1].$maskIpv4[2].$maskIpv4[3] (/$cidr)";
echo "<br>Rede: $network[0].$network[1].$network[2].$network[3]";
echo "<br>Primeiro Host: $hostMin[0].$hostMin[1].$hostMin[2].$hostMin[3]";
echo "<br>Último host: $hostMax[0].$hostMax[1].$hostMax[2].$hostMax[3]";
echo "<br>Broadcast: $broadcast[0].$broadcast[1].$broadcast[2].$broadcast[3]";
echo "<br>Número de hosts possíveis: $totalHosts";

?>
