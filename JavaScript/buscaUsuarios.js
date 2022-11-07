var idUsuarioQueEstaAcessando = document.querySelector(".idUsuario").value

var selectOrdenarPor = document.querySelector("#ordenarPor");
var ordenarPor = selectOrdenarPor.value
selectOrdenarPor.onchange = function(){
    ordenarPor = selectOrdenarPor.value
    buscaUsuarios()
}
var selectNiveis = document.querySelector("#niveis");
var niveis = selectNiveis.value
selectNiveis.onchange = function(){
    niveis = selectNiveis.value
    buscaUsuarios()
}

var inputBuscar = document.querySelector("#buscar")
var busca = inputBuscar.value
inputBuscar.oninput = function(){
    busca = inputBuscar.value
    buscaUsuarios()
}

var usuarios;

function buscaUsuarios(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./src/buscaDeDados/buscaUsuarios.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`niveis=${niveis}&busca=${busca}&ordem=${ordenarPor}`);
    xhr.onload = function(){
        usuarios = JSON.parse(xhr.responseText)
        escreverUsuarios()
    }
}





var tbody = document.querySelector(".tbody")
var quantidadeDeUsuariosCadastrados = document.querySelector(".quantidadeUsuarios")
function escreverUsuarios(){
    quantidadeDeUsuariosCadastrados.innerHTML = `${usuarios.length} Resultados`
    tbody.innerHTML = ""
    usuarios.forEach(function(usuario){
        var id = usuario['id'];
        var nome = usuario['nome'];
        var email = usuario['email'];
        var nivel = usuario['nivel'];

        var acoesUsuario = ""

        if(id != idUsuarioQueEstaAcessando){
            if(nivel == 'admin'){
                acoesUsuario = `
                    <div class='divAcoesNivel divGenericaBtnAcoes'>
                        <button  onclick='create_modal("confirmação para remover de admin")'  class='btns_acoes_usuarios' data-nome='${nome}' data-id='${id}'>Remover admin</button>
                    </div>
                    <div class='divAcoesExcluir divGenericaBtnAcoes'>
                        <button onclick='create_modal("confirmação para excluir usuario")' class='btns_acoes_usuarios' data-nome='${nome}' data-id='${id}'>Excluir</button>
                    </div>
                `
            }else if(nivel == 'usuario'){
                acoesUsuario = `
                    <div class='divAcoesNivel divGenericaBtnAcoes'>
                        <button onclick='create_modal("confirmação para tornar admin")' class='btns_acoes_usuarios' data-nome='${nome}' data-id='${id}'>Tornar admin</button>
                    </div>
                    <div class='divAcoesExcluir divGenericaBtnAcoes'>
                        <button  onclick='create_modal("confirmação para excluir usuario")' class='btns_acoes_usuarios' data-nome='${nome}' data-id='${id}'>Excluir</button>
                    </div>
                `
            }
        }
        
            tbody.innerHTML += `
            <tr class="tbody__tr">
                <td class="tbody__tr__tdGenerico tbody__tr__tdNome">
                    <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divNome"><p>${nome}</p></div>
                </td>
    
                <td class="tbody__tr__tdGenerico tbody__tr__tdEmail">
                    <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divEmail"><p>${email}</p></div>
                </td>
    
                <td class="tbody__tr__tdGenerico tbody__tr__tdNivel">
                    <div class="tbody__tr__td__divConteudoGenerica">
                        <p>${nivel}</p> 
                    </div>    
                </td>
                <td  class="tbody__tr__tdAcoes">
                    <i class="material-icons btnAbrirModal" onclick="create_modal('menu de açoes para usuários da lista')" data-nome='${nome}' data-nivel='${nivel}' data-email='${email}' data-id='${id}'>menu</i> 
    
                    <div class='containerAcoesItemListaUsuarios id-${id}'>
                        ${acoesUsuario}
                    </div>
    
                </td>
            </tr>
    `
    })
}
