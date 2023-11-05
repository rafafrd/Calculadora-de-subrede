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
      <img src="./public/img/Logo.png" class="logo" alt="Logo Nerdfix" />
      <div>
        <input type="checkbox" id="menu" >
        <label for="menu" class="label-menu">
          <img src="./public/img/menu.svg" alt="Menu" class="menu-img" />
        </label>
        <ul class="nav-items">
          <a href="./src/pages/index.html" class="nav-item">Início</a>
          <a href="./src/pages/classe.html" class="nav-item">Descobrir Classe do IP</a>
          <a href="./src/pages/cidr.html" class="nav-item">Converter CIDR</a>
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

    <div class="result" id="result">

      <!-- TODO: DESCOBRIR PQ O ERRO NAO TA APARECENDO -->
      <!-- QUALQUER COISA COLOCAR SÓ UM ALERT MESMO AO INVES DE PISCAR O ERRO -->
      <div id="mensagemErroIp" class="mensagemErro">Endereço IP inválido!</div>
    
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
                      echo "Range de Multicast";
                  } elseif ($primeiroOcteto > 239 && $primeiroOcteto < 256) {
                      echo "Range reservado para uso futuro";
                  }

              }
          }
      ?>
    </div>

  </main>
  <footer>
    <img src="./public/img/github-original.svg" alt="github" />
    <p>Copyright © 2023 Caio Franson - Rafael Augusto</p>
  </footer>
</body>
</html>