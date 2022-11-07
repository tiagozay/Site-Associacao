var idPublicacao = document.querySelector(".idPublicacao");
function buscarImagens(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/buscarImagensPublicacao.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`idPublicacao=${idPublicacao.value}`)
    xhr.onload = function(){
        escreverImagens(JSON.parse(xhr.responseText))
    }   
}
buscarImagens()

var gridImagens = document.querySelector(".gridImagens")
function escreverImagens(imagens){
    gridImagens.innerHTML = "";
    imagens.forEach(function(imagem){
        gridImagens.innerHTML += `
            <div class="divImg">
                <div class="telaSuperiorImagem">
                    <button type="button" onclick="create_modal('confirmação para excluir imagem')" data-idImg="${imagem['id']}" class="btnExcluirImagem">
                        <i class="material-icons" data-idImg="${imagem['id']}">delete</i>
                    </button>
                </div>
                <img src="assets/imagens_dinamicas/imagens_noticias/${imagem['imagem']}" class="imagem">
            </div>
        `
    })
}