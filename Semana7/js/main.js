"use strict";

$(function() {

    consultarUsuarios();

    function consultarUsuarios() {
        $.get("consulta_usuarios.php", function(usuarios) {
            //usuarios = JSON.parse(usuarios);            
            if(!("erro" in usuarios)) {
                let table = $("<table></table>");
                table.attr("class", "w3-table-all");

                let tr1 = $("<tr></tr>");
                let th_cpf = $("<th>CPF</th>");
                let th_nome = $("<th>Nome</th>");
                let th_botao = $("<th>#</th>");

                tr1.append(th_cpf);
                tr1.append(th_nome);
                tr1.append(th_botao);

                table.append(tr1);

                for(let i = 0; i < usuarios.length; i++) {
                    let tr = $(`<tr id="${i}"></tr>`);
                    let td_cpf = $("<td>"+usuarios[i].cpf+"</td>");
                    let td_nome = $("<td>"+usuarios[i].nome+"</td>");
                    let td_botao = $("<td></td>");
                    let botao = $("<button>Apagar</button>");
                    td_botao.append(botao);
                    tr.append(td_cpf);
                    tr.append(td_nome);
                    tr.append(td_botao);
                    table.append(tr);

                    botao.click(e=>{ // clicou em apagar
                        if(confirm(`Deseja apagar o usuário ${usuarios[i].nome}?`)){
                            $.post("apaga_usuario.php", usuarios[i], retorno=>{
                                if(retorno.sucesso){
                                    tr.remove(); // remove a linha da tabela
                                } else {
                                    alert("[!] Erro durante a remoção do usuário");
                                }
                            });
                        }
                    });
                }

                $("main").append(table);
            } else {
                $("main").html("Erro na consulta de usuários");
            }
        });
    }
});