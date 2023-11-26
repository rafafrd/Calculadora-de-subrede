function exibirPopupErro() {
    const popup = document.getElementById('popup');
    popup.style.display = 'block';
    popup.classList.add('show');
}

function validarIp(enderecoIp) {
    // regex utilizado para conferir os endereços válidos de ip
    var valido = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp);
    if (valido == false) {
        exibirPopupErro();
    }
    return valido;
}

function validarMascara(mascara) {
    // regex utilizado para conferir os endereços válidos de máscara
    var valido = /^(128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)$/.test(mascara);
    if (valido == true) {
        // divide a mascara para uma nova matriz quando um . é encontrado
        var pedacos = mascara.split(".");
        // converte os octetos em binário e junta eles em uma string com no minimo 8 digitos preenchendo com 0 se nao houver
        var binario = pedacos.map(function (octeto) {
            return parseInt(octeto).toString(2).padStart(8, "0");
        }).join(".");

        // regex para conferir se a mascára possui algum 0 entre os 1
        valido = /^1*0*1*$/.test(binario.replace(/\./g, ""));
    } else {
        exibirPopupErro();
    }
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
    if (ipValido == true && cidrValido == true) {
        return true;
    } else {
        exibirPopupErro();
        return false;
    }
}

document.getElementById('closePopup').addEventListener('click', function () {
    // remove o popup de erro quando o botão ok é pressionado
    const popup = document.getElementById('popup');
    popup.classList.remove('show');
    setTimeout(() => {
        popup.style.display = 'none';
    }, 300);
});