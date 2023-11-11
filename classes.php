<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NerdFix - Descobrir Classe IP</title>
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

    <form method="POST" action="" onsubmit="return validarIp(document.getElementById('ip').value);">
      <h1 class="title">Descobrir a Classe do IP</h1>
      <div class="input-container">
        <label for="ip" class="label">Digite o endereço IP:</label>
        <input type="text" id="ip" name="ip" placeholder="Exemplo: 192.168.1.1" class="input-ip">
      </div>
      <input type="submit" value="Descobrir" class="button">
    </form>

    <div class="popup" id="popup">
        <h2><img src="./public/img/erro.svg" alt="Erro" /> Endereço IP inválido!</h2>
        <button id="closePopup" class="button">OK</button>
    </div>

    <div class="result" id="result">
      <!-- TODO: ESTILIZAR O RESULTADO, DEIXAR MAIOR, E CENTRALIZAR NA ALTURA -->
      <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {

              // Verifique se o formulário foi enviado
              if (isset($_POST["ip"])) {

                  # ip digitado pelo usuario
                  $ip = $_POST["ip"];

                  # usando o explode para separar os octetos
                  $octetos = explode('.', $ip);

                  # separando o primeiro octeto e convertendo em numeros inteiros
                  $primeiroOcteto = intval($octetos[0]);

                  # conferindo os ranges para descobrir a classe
                  if ($primeiroOcteto > 0 && $primeiroOcteto < 128) {
                      echo "IP classe A";
                  } elseif ($primeiroOcteto > 127 && $primeiroOcteto < 192) {
                      echo "IP classe B";
                  } elseif ($primeiroOcteto > 191 && $primeiroOcteto < 224) {
                      echo "IP classe C";
                  } elseif ($primeiroOcteto > 223 && $primeiroOcteto < 240) {
                      echo "IP classe D: Range de Multicast";
                  } elseif ($primeiroOcteto > 239 && $primeiroOcteto < 256) {
                      echo "IP classe E: Range reservado para uso futuro";
                  }

              }
          }
      ?>
    </div>

    <div class="explicacao">
      <h2>O que são classes IP?</h2>
      <p>As classes de IP referem-se a uma forma de categorizar endereços IP em redes baseadas na primeira parte do endereço IP, chamada de "octeto". Existem cinco classes de IP: A, B, C, D e E. Aqui está um breve significado de cada uma:
        <br><br><b>Classe A (0.0.0.0 a 127.0.0.0):</b><br> Os endereços da Classe A têm um primeiro octeto no intervalo de 0 a 127. Eles são usados para redes muito grandes e oferecem muitos endereços disponíveis.
        <br><br><b>Classe B (128.0.0.0 a 191.0.0.0):</b><br> Os endereços da Classe B têm um primeiro octeto no intervalo de 128 a 191. Eles são usados para redes de tamanho médio.
        <br><br><b>Classe C (192.0.0.0 a 223.0.0.0):</b><br> Os endereços da Classe C têm um primeiro octeto no intervalo de 192 a 223. Eles são usados para redes menores e oferecem menos endereços disponíveis do que as Classes A e B.
        <br><br><b>Classe D (224.0.0.0 a 239.0.0.0):</b><br> Os endereços da Classe D são usados para multicast, que é a transmissão de dados para vários receptores.
        <br><br><b>Classe E (240.0.0.0 a 255.0.0.0):</b><br> Os endereços da Classe E são reservados para fins experimentais e não são geralmente usados em redes públicas.
        <br><br>Essas classes de IP eram mais relevantes no passado, quando o sistema de endereçamento IP estava em seu estágio inicial. Hoje em dia, o sistema de endereçamento IP é mais flexível com a introdução da <a href="./cidr.php">notação CIDR</a> (Classless Inter-Domain Routing), que permite dividir e alocar endereços de forma mais granular, independentemente das classes. No entanto, a compreensão das classes de IP ainda é útil para entender a estrutura básica do endereçamento IP.
      </p>
    </div>

  </main>
  <footer>
    <!-- <button id="theme-toggle">Alternar Tema</button> -->
    <img src="./public/img/github-original.svg" alt="github" />
    <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
    <script src="./src/script/main.js"></script>
  </footer>
</body>
</html>