var btns = document.querySelectorAll(".btnExcluirImagem")
var idPublicacao = document.querySelector(".idPublicacao");
btns.forEach(function(btn){
    btn.addEventListener("click",function(){
        var idImagem = event.target.dataset.idimg;
        
    })
})


function excluirImagem(idImagem){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/excluirImagem.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`id=${idImagem}&idPublicacao=${idPublicacao.value}`)
    xhr.onload = function(){
        fecharMenu()
        buscarImagens()
    }
}
