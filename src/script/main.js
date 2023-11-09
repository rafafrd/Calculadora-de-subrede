function exibirPopupErro() {
    const popup = document.getElementById('popup');
    popup.style.display = 'block';
    popup.classList.add('show'); // Adiciona a classe para mostrar com transição
}

function validarIp(enderecoIp) {
    var valido = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp);
    if (valido == false) {
        exibirPopupErro();
    }
    return valido;
}

function validarMascara(mascara) {
    var valido = /^(255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)$/.test(mascara);
    
    if (valido == true) {
        var pedacos = mascara.split(".");
        var binario = pedacos.map(function (octeto) {
            return parseInt(octeto).toString(2).padStart(8, "0");
        }).join(".");

        valido = /^1*0*1*$/.test(binario.replace(/\./g, ""));
    } else {
        exibirPopupErro();
    }

    // exibirErro(divErro, valido);
    return valido;
}

function validarCidr(cidr) {
    var valido = cidr >= 1 && cidr <= 30;
    if (valido == false) {
        exibirPopupErro();
    }
    return valido;
}

function validarCalculadora(enderecoIp, cidr) {
    var ipValido = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp);
    var cidrValido = cidr >= 1 && cidr <= 30;
  
    if (ipValido == true && cidrValido == true){
        return true;
    } else {
        exibirPopupErro();
        return false;
    }
}
  

// Fechar o popup ao clicar no botão "OK"
document.getElementById('closePopup').addEventListener('click', function () {
    const popup = document.getElementById('popup');
    popup.classList.remove('show'); // Remove a classe para ocultar com transição
    setTimeout(() => {
      popup.style.display = 'none'; // Define para 'none' após a transição
    }, 300); // Tempo um pouco mais longo para a transição de saída
  });

// // Adicione um ouvinte de eventos para o botão de alternância
// const themeToggle = document.getElementById("theme-toggle");
// themeToggle.addEventListener("click", toggleTheme);
// console.log("Ouvidor de evento de alternância de tema adicionado");

// // Função para alternar entre os temas
// function toggleTheme() {
//     const body = document.body;
//     body.classList.toggle("dark-theme"); // Adicione ou remova a classe de tema escuro
//     console.log("Tema alternado");
  
//     // Verifique as classes no corpo
//     console.log("Classes no corpo:", body.classList);
//   }