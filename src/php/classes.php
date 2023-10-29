<!DOCTYPE html>
<html>
<head>
    <title>Descobrir Classe de IP</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js"></script>
</head>
<body>
    <h1>Descobrir Classe de IP</h1>
    <form method="POST" action="" onsubmit="return validarIp(document.getElementById('ip').value);">
        <label for="ip">Digite o endereço IP:</label>
        <input type="text" id="ip" name="ip" placeholder="Exemplo: 192.168.1.1">
        <input type="submit" value="Descobrir">
    </form>

    <div id="message-error" class="message-error">Endereço IP inválido!</div>

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

</body>
</html>
