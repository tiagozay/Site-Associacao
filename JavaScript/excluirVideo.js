function excluirVideo(idVideo){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/excluirVideo.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`id=${idVideo}&idPublicacao=${idPublicacao.value}`)
    xhr.onload = function(){
        fecharMenu()
        buscarVideos()
    }
}
