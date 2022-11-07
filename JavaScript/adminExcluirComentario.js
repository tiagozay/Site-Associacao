var idPublicacao = document.querySelector(".idPublicacao").value

function adminExcluirComentario(idComentario)
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/adminExcluirComentario.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`publicacao=${idPublicacao}&idComentario=${idComentario}`)
    xhr.addEventListener("load", function(){
        fecharMenu();
        buscarComentarios();
    })
}