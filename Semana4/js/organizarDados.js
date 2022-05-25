$("#senha_rep").on("input",()=>{
    let senhaOrig = $("#senha").val();
    let senhaRep = $("#senha_rep").val();
    let infoMsg = $("#senha_info");

    infoMsg.css("font-weight","bold");
    infoMsg.css("font-size","14px");

    if(senhaRep.length == 0){ // Campo senha repetida vazio
        infoMsg.html("");
    } else if(senhaOrig != senhaRep){ // Senhas não batem
        infoMsg.html("[!] Senhas diferentes");
        infoMsg.css("color","red");
    } else { // Senhas iguais
        infoMsg.html("Senhas iguais");
        infoMsg.css("color","green");
    }
});