var input = document.querySelector(".inputComentar")
var btnEnviar = document.querySelector(".btnComentar")

var idPublicacao = document.querySelector(".idPublicacao").value
var idUsuario = document.querySelector(".idUsuario").value
var nivelUsuario = document.querySelector(".nivelUsuario").value

btnEnviar.addEventListener("click", function(){
    event.preventDefault()
    if(btnEnviar.dataset.login == 'deslogado'){
        create_modal('criar conta para curtir e comentar')
    }else if(btnEnviar.dataset.login == 'usuario' || btnEnviar.dataset.login == 'admin'){
        if(validarComentario(input.value)){
            var xhr = new XMLHttpRequest();
            xhr.open("POST", './src/acoes/comentar.php')
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
            xhr.send(`publicacao=${idPublicacao}&mensagem=${input.value}`)
            xhr.addEventListener("load",function(){
                console.log(xhr.responseText)
                escreverComentarios(JSON.parse(xhr.responseText))
                input.value = "";
            });
        }
    }
})
input.addEventListener("click", ()=>{
    if(input.dataset.login == 'deslogado'){
        create_modal('criar conta para curtir e comentar')
    }
})

function validarComentario(comentario){   
    comentarioSemEspacos = comentario.trim();
    if(comentarioSemEspacos.length <= 0){
        return false;
    }else if(comentarioSemEspacos.length >= 500){
        return false;
    }
    return true;
}

buscarComentarios();
function buscarComentarios(){
    var spanId = document.querySelector(".spanId")
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/buscaDeDados/todosComentarios.php')
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`publicacao=${idPublicacao}`)
    xhr.addEventListener("load",function(){
        escreverComentarios(JSON.parse(xhr.responseText))
    });
}

function escreverComentarios(arrayComentarios){
    var divComentarios = document.querySelector(".comentarios")
    divComentarios.innerHTML = ""
    arrayComentarios.forEach(function(comentario){
        var btnExcluirComentario = "";
        if(comentario['usuario'] == idUsuario){
            btnExcluirComentario = 
            `
                <button class='btnExluirComentario material-icons'  onclick='create_modal("confirmação para usuario excluir seu comentario")' data-idComentario=${comentario['id']}>
                delete</button> 
            `            
        }else if(nivelUsuario == 'admin'){
            btnExcluirComentario = 
            `
                <button class='btnExluirComentario material-icons' onclick='create_modal("confirmação para adm excluir comentario")' data-nome='${comentario['nome']}' data-idComentario=${comentario['id']}>
                delete
                </button> 
            `
        }
        divComentarios.innerHTML += `
            <article class="comentario" data-idComentario=${comentario['id']}>
                <div class="comentario__usuario">
                    <i class="material-icons">person</i>
                    ${comentario['nome']}<?php new BtnExcluirComentario($nivelDoUsuario, 'tiago', 5) ?>
                    ${btnExcluirComentario}
                </div>
                <div class="comentario__conteudo">
                    ${comentario['comentario']}
                </div>
            </article>
        `;
    });
    
}