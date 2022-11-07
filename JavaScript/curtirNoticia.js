var btn = document.querySelector(".btnGostei")
var quantidade = btn.querySelector("span");

var idPublicacao = document.querySelector(".idPublicacao").value

btn.addEventListener("click", ()=>{
    if(btn.dataset.login == 'deslogado'){
        create_modal('criar conta para curtir e comentar')
    }else{
        var xhr = new XMLHttpRequest();
        xhr.open("POST", './src/acoes/like.php');
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
        xhr.send(`publicacao=${idPublicacao}`)
        xhr.onload = function(){
            $resposta = JSON.parse(xhr.responseText)
            if(typeof $resposta == 'number'){
                quantidade.innerHTML = xhr.responseText
            }
           
        }
    }
})