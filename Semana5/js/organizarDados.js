function setInfosTitulo(nome,email,dataNasc){
    $("#infoNome").html(`<strong>Bem vindo(a) ${nome}!</strong>`);
    $("#infoDados").html(`Email atual: <strong>${email}</strong><br/>Data de Nascimento atual: <strong>${dataNasc}</strong>`);
}

$(".campoHeader").css('font-size','18px');

$(".novaSenha").on("input",()=>{
    let senhaOrig = $("#novaSenha").val();
    let senhaRep = $("#novaSenhaRep").val();
    let infoMsg = $("#senha_info");

    infoMsg.css("font-weight","bold");

    if(senhaRep.length == 0 || senhaOrig.length == 0){ // Campo de senha vazio
        infoMsg.html("");
    } else if(senhaOrig != senhaRep){ // Senhas não batem
        infoMsg.html("[!] Senhas diferentes");
        infoMsg.css("color","red");
    } else { // Senhas iguais
        infoMsg.html("Senhas iguais!");
        infoMsg.css("color","green");
    }
});