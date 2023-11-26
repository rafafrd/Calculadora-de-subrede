<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NerdFix - Calculadora de Redes</title>
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
        <input type="checkbox" id="menu">
        <label for="menu" class="label-menu">
          <img src="./public/img/menu.svg" alt="Menu" class="menu-img" />
        </label>
        <ul class="nav-items">
          <a href="./index.php" class="nav-item">Calculadora de Redes</a>
          <a href="./classes.php" class="nav-item">Descobrir Classes</a>
          <a href="./cidr.php" class="nav-item">Conversor CIDR</a>
          <a href="./exibirip.php" class="nav-item">Exibir meu IP</a>
        </ul>
      </div>
    </nav>
  </header>

  <main>

    <form method="POST" action="" onsubmit="return validarCalculadora(document.getElementById('ip').value, document.getElementById('cidr').value);">
      <h1 class="title">Calculadora de Redes</h1>
      <div class="input-container">
        <label for="ip" class="label">Digite o endereço IP:</label>
        <input type="text" id="ip" name="ip" placeholder="Exemplo: 192.168.1.1" class="input-ip" title="Endereço IP" required>
        <label for="cidr" class="label">Digite a notação CIDR:</label>
        <input type="text" id="cidr" name="cidr" placeholder="Exemplo: 24" class="input-ip" title="Notação CIDR" required>
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

      # verifica se a solicitação é do tipo POST, e se as variáveis foram fornecidas
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ipInput = isset($_POST['ip']) ? $_POST['ip'] : '';
        $cidrInput = isset($_POST['cidr']) ? $_POST['cidr'] : '';

        # converte as variáveis para array e inteiro
        $ip = explode('.', $ipInput);
        $cidr = intval($cidrInput);

        # converte o endereço IP em binário
        $ipBinary = [];
        foreach ($ip as $octet) {
          $ipBinary[] = str_pad(decbin($octet), 8, '0', STR_PAD_LEFT);
        }
        $ipBinary = implode('', $ipBinary);

        # converte a máscara em binário
        $subnetMaskBinary = str_pad(str_repeat('1', $cidr) . str_repeat('0', 32 - $cidr), 32, '0', STR_PAD_LEFT);

        # faz a operação de "E lógico" para obter o endereço de rede, resultando em 1 caso ambos bits sejam 1 e 0 caso não
        $networkBinary = '';
        for ($i = 0; $i < 32; $i++) {
          $networkBinary .= $ipBinary[$i] & $subnetMaskBinary[$i];
        }
        # converte o endereço de rede de binário de volta para decimal
        $network = [];
        for ($i = 0; $i < 4; $i++) {
          $network[] = bindec(substr($networkBinary, $i * 8, 8));
        }

        # faz a operação de 'OU lógico' para obter o endereço de broadcast, resultando em 1 caso algum dos bits comparados seja 1, ou 0 se não
        $broadcastBinary = '';
        for ($i = 0; $i < 32; $i++) {
          $broadcastBinary .= $ipBinary[$i] | ($subnetMaskBinary[$i] ^ 1);
        }
        # converte o broadcast para decimal
        $broadcast = [];
        for ($i = 0; $i < 4; $i++) {
          $broadcast[] = bindec(substr($broadcastBinary, $i * 8, 8));
        }

        # calcula o primeiro host substituindo o ultimo bit do endereço de rede por 1
        $firstHostBinary = substr_replace($networkBinary, '1', -1);
        $firstHost = [];
        for ($i = 0; $i < 4; $i++) {
          $firstHost[] = bindec(substr($firstHostBinary, $i * 8, 8));
        }

        # calcula o último host substituindo o ultimo bit do broadcast por 0
        $lastHostBinary = substr_replace($broadcastBinary, '0', -1);
        $lastHost = [];
        for ($i = 0; $i < 4; $i++) {
          $lastHost[] = bindec(substr($lastHostBinary, $i * 8, 8));
        }

        # calcula o número máximo de hosts
        $maxHosts = pow(2, 32 - $cidr) - 2;

        # exibe os resultados
        echo "<script>document.getElementById('msgResultado').style.display='none';</script>";
        echo "<b>Endereço IP: </b>" . implode('.', $ip) . "<br>";
        echo "<b>Máscara: </b>" . long2ip(ip2long('255.255.255.255') << (32 - $cidr)) . " (/$cidr)<br>";
        echo "<b>Endereço de Rede: </b>" . implode('.', $network) . "<br>";
        echo "<b>Broadcast: </b>" . implode('.', $broadcast) . "<br>";
        echo "<b>Primeiro Host: </b>" . implode('.', $firstHost) . "<br>";
        echo "<b>Último Host: </b>" . implode('.', $lastHost) . "<br>";
        echo "<b>Número Máximo de Hosts: </b>" . $maxHosts . "<br>";
      }
      ?>
    </div>

    <div class="explicacao">
      <h2>Calculadora de Redes</h2>
      <p>A calculadora de redes é uma ferramenta que permite obter informações detalhadas sobre uma rede específica a partir de um endereço IP e uma notação CIDR.<br>
        Ela retorna o endereço IP, a máscara de rede, o endereço de rede, o endereço de broadcast, o primeiro e o último host na rede, e o número máximo de hosts que a rede pode ter.<br>
        Esta ferramenta é útil para entender a estrutura e a capacidade de uma rede, seja para fins de gerenciamento de rede, solução de problemas ou aprendizado.
      </p>
    </div>

  </main>

  <footer>
    <p>Ajustar tamanho da fonte</p>
    <input type="range" min="10" max="32" value="16" step="2" onchange="document.body.style.fontSize = this.value + 'px';">
    <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
  </footer>
  <script src="./src/script/main.js"></script>
</body>

</html>