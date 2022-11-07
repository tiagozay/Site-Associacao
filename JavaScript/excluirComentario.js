var idPublicacao = document.querySelector(".idPublicacao").value

function excluirComentario(idComentario)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/excluirComentarios.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`publicacao=${idPublicacao}&idComentario=${idComentario}`)
    xhr.addEventListener("load", function(){
        fecharMenu();
        buscarComentarios();
    })
}