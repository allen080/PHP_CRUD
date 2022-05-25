"use strict";

$(function() {
    $(".w3-check").click(()=>{ // Evento de exibir o campo de senhas
        let senhas = $(".campoSenha");
        senhas.attr("type",(senhas.attr('type')=='password'?'text':'password'));
    });

    $("#cpf").mask("000.000.000-00");

    $(".w3-button").click(e=>{
        // fazer um objeto com todos os dados
        let dadosArr = $(".campoReq");
        let dados = {};
        dadosArr.map(index => dados[dadosArr[index].name] = dadosArr[index].value);

        let campoResp = $("#resposta");
        // limpa o campo
        campoResp.html('');
        campoResp.css('color','red');

        if(dados.cpf.trim().length == 0 || dados.senha.trim().length == 0) {
            campoResp.html("Cpf ou Senha inválidos");
            /*campoResp.fadeIn(1000); //mostra o elemento tornando-o opaco, isto é, muda gradualmente a opacidade do elemento
            campoResp.fadeOut(1000);*/
        } else {
            dados.senha = $.md5(dados.senha);
            dados.senha_rep = $.md5(dados.senha_rep);

            $.post("cadastro.php", dados, retorno=>{
                if(!retorno.valido) {                    
                    if(retorno.cpfInvalido){
                        campoResp.html("[!] Formato do CPF inválido");
                    } else if(retorno.senhasDiferentes){
                        campoResp.html("[!] Erro nos campos de Senhas: Senhas diferentes");
                    } else if(retorno.jaCadastrado){
                        campoResp.html("[!] Usuário já cadastrado no sistema");
                    } else {
                        campoResp.html("[!] Erro durante o cadastro. Verifique os campos digitados");
                    }
                } else {
                    campoResp.html("Cadastro Efetuado com Sucesso!");
                    campoResp.css('color','green');
                }
            });
        }
    });

    $("body").keyup(key => { // Evento de apertar Enter e enviar formulario 
        if(key.keyCode == 13){ // Verifica se o botão foi o enter
            $(".w3-button").click();
        }
    });

});

/*let nome = $("#nome").val();
        let email = $("#email").val();
        let cpf = $("#cpf").val();
        let senha = $("#senha").val();
        let senha_rep = $("#senha_rep").val();*/