<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NerdFix - Calculadora IP</title>
  <link rel="icon" href="./public/img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="./public/style/style.css">
  <link rel="stylesheet" href="./public/style/header.css">
  <link rel="stylesheet" href="./public/style/footer.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="nav">
      <a href="./index.php"><img src="./public/img/Logo.png" class="logo" alt="Logo Nerdfix" /></a>
      <div>
        <input type="checkbox" id="menu" >
        <label for="menu" class="label-menu">
          <img src="./public/img/menu.svg" alt="Menu" class="menu-img" />
        </label>
        <ul class="nav-items">
          <a href="./index.php" class="nav-item">Calculadora de IP</a>
          <a href="./classes.php" class="nav-item">Descobrir Classes</a>
          <a href="./cidr.php" class="nav-item">Conversor CIDR</a>
          <a href="./exibirip.php" class="nav-item">Exibir meu IP</a>
        </ul>
      </div>
    </nav>
  </header>

<main>

    <form method="POST" action="" onsubmit="return validarCalculadora(document.getElementById('ip').value, document.getElementById('cidr').value);">
      <h1 class="title">Calculadora de IP</h1>
      <div class="input-container">
        <label for="ip" class="label">Digite o endereço IP:</label>
        <input type="text" id="ip" name="ip" placeholder="Exemplo: 192.168.1.1" class="input-ip">
        <label for="cidr" class="label">Digite a notação CIDR:</label>
        <input type="text" id="cidr" name="cidr" placeholder="Exemplo: 24" class="input-ip">
      </div>
      <input type="submit" value="Calcular" class="button">
    </form>

    <div class="popup" id="popup">
        <h2><img src="./public/img/erro.svg" alt="Erro" /> Endereço IP ou CIDR inválido!</h2>
        <button id="closePopup" class="button">OK</button>
    </div>

    <div class="result" id="result">
    <p class="msgResultado" id="msgResultado">Seu resultado aparecerá aqui</p>

        <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $ipInput = isset($_POST['ip']) ? $_POST['ip'] : '';
                $cidrInput = isset($_POST['cidr']) ? $_POST['cidr'] : '';

                // Certifique-se de que os valores de $ipInput e $cidrInput são válidos
                $ip = explode('.', $ipInput); // Converte o IP em um array
                $cidr = intval($cidrInput);

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
                echo "<script>document.getElementById('msgResultado').style.display='none';</script>";
                echo "Endereço IP: " . implode('.', $ip) . "<br>";
                echo "Máscara: " . long2ip(ip2long('255.255.255.255') << (32 - $cidr)) . " (/$cidr)<br>";
                echo "Endereço de Rede: " . implode('.', $network) . "<br>";
                echo "Broadcast: " . implode('.', $broadcast) . "<br>";
                echo "Primeiro Host: " . implode('.', $firstHost) . "<br>";
                echo "Último Host: " . implode('.', $lastHost) . "<br>";
                echo "Número Máximo de Hosts: " . $maxHosts . "<br>";
            }
        ?>
    </div>

    <div class="explicacao">
        <h2>Calculadora de Sub-Redes</h2>
        <p style="font-size: large;" >Uma calculadora de sub-rede é uma ferramenta essencial para profissionais de redes de computadores e administradores de sistemas. Ela desempenha um papel crucial na gestão e otimização de endereços IP em uma rede, facilitando a criação e manutenção de sub-redes. Vamos explorar como essas calculadoras operam e os motivos pelos quais são fundamentais em ambientes de rede.
        </p>
    </div>

</main>

<footer>
  <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
</footer>
<script src="./src/script/main.js"></script>
</body>
</html>