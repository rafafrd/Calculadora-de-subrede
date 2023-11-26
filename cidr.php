<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NerdFix - Conversor CIDR</title>
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

    <form method="POST" action="" onsubmit="return validarCidr(document.getElementById('cidr').value);">
      <div class="input-container">
        <h1 class="title">Conversor CIDR</h1>
        <label for="cidr" class="label">Digite a notação CIDR:</label>
        <input type="text" id="cidr" name="cidr" placeholder="Exemplo: 16" class="input-ip" title="CIDR" required>
        <input type="submit" name="submitCidr" value="Converter para IPv4" class="button">
    </form>

    <form method="POST" action="" onsubmit="return validarMascara(document.getElementById('ipv4').value);">
      <label for="ipv4" class="label">Digite o endereço IPv4:</label>
      <input type="text" id="ipv4" name="ipv4" placeholder="Exemplo: 255.255.0.0" class="input-ip" title="Endereço IP" required>
      <input type="submit" name="submitIpv4" value="Converter para CIDR" class="button">
    </form>
    </div>

    <div class="popup" id="popup">
      <h2><img src="./public/img/erro.svg" alt="Erro" /> Endereço IP ou CIDR inválido!</h2>
      <button id="closePopup" class="button">OK</button>
    </div>

    <div class="result" id="result">
      <p class="msgResultado" id="msgResultado">Seu resultado aparecerá aqui</p>

      <?php

      function ipv4ParaBinario($ipv4){
        # separa o ip em uma array com os octetos
        $octetos = explode('.', $ipv4);
        $binarioOctetos = [];

        # converte eles em binário
        foreach ($octetos as $octeto) {
          $binarioOctetos[] = str_pad(decbin($octeto), 8, '0', STR_PAD_LEFT);
        }

        return implode('.', $binarioOctetos);
      }

      function cidrParaIpv4($cidr){
        # adiciona 1 bit para cada unidade do CIDR, e finaliza com 0 até obter o tamanho final de 32
        $mascara = str_pad(str_repeat('1', $cidr), 32, '0');
        $ipDecimal = [];

        # extrai os octetos da mascara binária e converte para decimal
        for ($i = 0; $i < 4; $i++) {
          $octetoBinario = substr($mascara, $i * 8, 8);
          $ipDecimal[] = bindec($octetoBinario);
        }

        # separa os octetos da mascara binária
        $octetosMascara = str_split($mascara, 8);

        echo "<script>document.getElementById('msgResultado').style.display='none';</script>";
        echo "<b>Máscara em Bits: </b>" . implode('.', $octetosMascara);
        echo "<br><b>Máscara em IPv4: </b>" . implode('.', $ipDecimal);
        echo "<br><b>Notação CIDR:</b> /$cidr";
      }

      function ipv4ParaCidr($ipv4){
        $binario = ipv4ParaBinario($ipv4);

        $contagem = substr_count($binario, '1');

        echo "<script>document.getElementById('msgResultado').style.display='none';</script>";
        echo "<b>Máscara em Bits:</b> $binario";
        echo "<br><b>Máscara em IPv4:</b> $ipv4";
        echo "<br><b>Notação CIDR:</b> /$contagem";
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submitCidr"]) && isset($_POST["cidr"])) {
          $cidr = $_POST["cidr"];
          cidrParaIpv4($cidr);
        } elseif (isset($_POST["submitIpv4"]) && isset($_POST["ipv4"])) {
          $ipv4 = $_POST["ipv4"];
          ipv4ParaCidr($ipv4);
        }
      }

      ?>
    </div>

    <div class="explicacao">
      <h2>O que é Notação CIDR?</h2>
      <p>A notação CIDR (Classless Inter-Domain Routing) é um sistema de notação que permite especificar blocos de endereços IP e suas máscaras de sub-rede de
        forma mais flexível do que a notação de máscara de sub-rede tradicional. Ela é usada para definir sub-redes e alocar endereços IP de maneira eficiente.
        <br><br>A notação CIDR inclui o endereço IP e o número de bits na máscara de sub-rede, separados por uma barra ("/").
        Por exemplo, "192.168.1.0/24" indica que os primeiros 24 bits do endereço IP são a parte da rede, e os 8 bits restantes são a parte do host.
        Isso simplifica o gerenciamento de endereços IP em redes, permitindo a alocação mais precisa de sub-redes e endereços.
      </p>
    </div>

  </main>
  <footer>
    <p>Ajustar tamanho da fonte</p>
    <input type="range" min="10" max="32" value="16" step="2" onchange="document.body.style.fontSize = this.value + 'px';">
    <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
    <script src="./src/script/main.js"></script>
  </footer>
</body>

</html>