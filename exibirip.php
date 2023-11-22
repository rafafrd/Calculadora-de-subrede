<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NerdFix - Exibir meu IP</title>
  <link rel="icon" href="./public/img/favicon.png" type="image/x-icon">
  <script src="./src/script/main.js"></script>
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

    <!-- TODO: ARRUMAR A COR DO TEXTO PARA BRANCO (PC) E MUDAR PARA AZUL ESCURO NO MOBILE, E CENTRALIZAR ELE TODO -->
    <form>
        <h1 class="title">Exibir meu IP</h1>
        <?php

            $ip = isset($_SERVER['HTTP_CLIENT_IP'])
                ? $_SERVER['HTTP_CLIENT_IP']
                : (isset($_SERVER['HTTP_X_FORWARDED_FOR'])
                ? $_SERVER['HTTP_X_FORWARDED_FOR']
                : $_SERVER['REMOTE_ADDR']);

            $domain = gethostbyaddr($ip);

            echo "<h2>Meu endereço IP público é: <br>$ip</h2>";
            echo "<h2>IP público Reverso: <br>$domain</h2>";

        ?>
    </form>

 

  <!-- TODO: REMOVER O ESPAÇO ACIMA, E CENTRALIZAR O TEXTO -->
  <div class="explicacao">
    <h2>IP Público</h2>
    <p>O endereço IP público é o identificador único da sua conexão com a Internet. 
        Ele funciona como um endereço postal global, permitindo que outros dispositivos o encontrem na rede. 
        <br>Em contraste, o endereço IP local é usado apenas dentro da sua rede local para identificar dispositivos conectados.
    </p>
    <h2><br>IP Reverso</h2>
    <p>O DNS reverso, ou IP reverso, é um processo que mapeia endereços IP de volta para nomes de domínio, 
        desempenhando um papel fundamental na verificação da autenticidade de servidores e serviços na Internet. 
        <br>Ele fornece uma maneira de associar endereços IP a nomes de domínio, auxiliando na segurança de comunicações 
        online e na solução de problemas de rede. É uma ferramenta valiosa para identificar e verificar a procedência de 
        servidores e é amplamente usado em configurações de e-mail e segurança na web.</p>
  </div>

  </main>

  <footer>
    <p>Ajustar tamanho da fonte</p>
    <input type="range" min="10" max="32" value="16" step="2" onchange="document.body.style.fontSize = this.value + 'px';">
    <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
  </footer>
</body>
</html>




