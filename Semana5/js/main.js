"use strict";

$(function() {
    $(".w3-check").click(e=>{ // Evento de exibir o campo de senhas
        let senhas = $(".campoSenha");
        senhas.attr("type",(senhas.attr('type')=='password'?'text':'password'));
    });

    $("#cpf").mask("000.000.000-00");

    $(".w3-button").click(e=>{
        // fazer um objeto com todos os dados
        let dadosArr = $(".campoReq");
        let dados = {trocar:{}};
        
        dadosArr.map(index => {
            let campoNome = dadosArr[index].name;
            let campoValor = dadosArr[index].value.trim();

            dados[campoNome] = campoValor;
            // pega os dados que deseja ser editados (tirando novaSenha e novaSenhaRep)
            if(campoValor.length > 0 && campoNome.indexOf("nova") == -1){
                dados['trocar'][campoNome] = true;
            }
        });

        let campoResp = $("#resposta");
        // limpa o campo
        campoResp.html('');
        campoResp.css('color','red');

        if($.isEmptyObject(dados.trocar)){ // nenhum campo preenchido
            campoResp.html("[!] Preencha algum campo de edição");
            return false;
        } else if(dados.trocar.senhaAtual || dados.senhaAtual || dados.novaSenha || dados.novaSenhaRep){
            if(dados.senhaAtual.length == 0){
                campoResp.html("Preencha sua senha atual para altera-la");
                return false;
            } else if(dados.novaSenha.length == 0){
                campoResp.html("Digite a nova senha");
                return false;
            } else if(dados.novaSenhaRep.length == 0){
                campoResp.html("Confirme a nova senha");
                return false;
            }
        }        
        let msgDadosAlterar = Object.keys(dados.trocar).join(', ').trim(', ');

        if(!confirm(`Deseja alterar os seus dados (${msgDadosAlterar}) no sistema?`)){
            alert("Dados não alterados");
            return false;
        }

        dados.senhaAtual = $.md5(dados.senhaAtual);
        dados.novaSenha = $.md5(dados.novaSenha);
        dados.novaSenhaRep = $.md5(dados.novaSenhaRep);

        $.post("edicao.php", dados, retorno=>{
            if(!retorno.valido) {    
                if(!retorno.logado){ // usuario nao está logado
                    window.location.href = "erro.html";
                } else if(retorno.novasSenhasDiferentes){ // novaSenha e novaSenhaRep com valores diferentes
                    campoResp.html("[!] Erro nos campos de Senhas: Senhas diferentes");
                } else if(retorno.mudarSenhasIguais){ // senha nova igual a anterior com valores iguais
                    campoResp.html("[!] A nova senha informada é idêntica a anterior");
                } else if(retorno.senhaAtualIncorreta){ // senha atual errada
                    campoResp.html("[!] Senha do usuário atual incorreta");
                } else if(retorno.emailCadastrado){ // email já cadastrado
                    campoResp.html("[!] Email já cadastrado no sistema");
                } else if(retorno.camposVazios){ // nenhum campo preenchido
                    campoResp.html("[!] Preencha algum valor");
                } else {
                    campoResp.html("[!] Erro durante a edição dos dados. Verifique os campos preenchidos");
                }
            } else {
                campoResp.html(`Edição de ${msgDadosAlterar} feita com sucesso!`);
                campoResp.css('color','green');
            }
        });
    });

    $("body").keyup(key => { // Evento de apertar Enter e enviar formulario 
        if(key.keyCode == 13){ // Verifica se o botão foi o enter
            $(".w3-button").click();
        }
    });
});
