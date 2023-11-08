// Função para exibir mensagem de erro e aplicar classe "shake"
function exibirErro(divErro, valido) {
    if (valido == true) {
        console.log("Verificação válida, removendo erro")
        divErro.style.display = "none";
        divErro.classList.remove("shake");
    } else {
        console.log("Verificação inválida, exibindo erro")
        divErro.style.display = "block";
        divErro.classList.add("shake");
    }
}

function validarIp(enderecoIp) {
    var divErro = document.getElementById("mensagemErroIp");
    var valido = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp);
    exibirErro(divErro, valido);
    return valido;
}

function validarMascara(mascara) {
    var divErro = document.getElementById("mensagemErroMascara");
    var valido = /^(255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)\.(0|128|192|224|240|248|252|254|255)$/.test(mascara);
    
    if (valido == true) {
        var pedacos = mascara.split(".");
        var binario = pedacos.map(function (octeto) {
            return parseInt(octeto).toString(2).padStart(8, "0");
        }).join(".");

        valido = /^1*0*1*$/.test(binario.replace(/\./g, ""));
    }

    exibirErro(divErro, valido);
    return valido;
}

function validarCidr(cidr) {
    var divErro = document.getElementById("mensagemErroCidr");
    var valido = cidr >= 1 && cidr <= 30;
    exibirErro(divErro, valido);
    return valido;
}

function validarCalculadora(enderecoIp, cidr) {
    console.log("inicio verifica")
    var divErro = document.getElementById('mensagemErroCalc');

    var ipValido = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp);
    var cidrValido = cidr >= 1 && cidr <= 30;
  
    if (ipValido == true && cidrValido == true){
        console.log("ambos verdadeiros");
        exibirErro(divErro, true);
        return true;
    } else {
        console.log("ambos falsos");
        exibirErro(divErro, false);
        return false;
    }
}