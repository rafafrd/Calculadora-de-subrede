// funcao para validar se o endereço ip digitado é valido
function validarIp(enderecoIp) {
    var errorDiv = document.getElementById("mensagemErro");

    if (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(enderecoIp)) {
        errorDiv.style.display = "none"; // Esconde a mensagem de erro se o IP for válido
        errorDiv.classList.remove("shake"); // Remove a classe "shake"
        return true;
    }
    
    // Exibe a mensagem de erro e aplica a classe "shake"
    errorDiv.style.display = "block";
    errorDiv.classList.add("shake");

    return false;
}