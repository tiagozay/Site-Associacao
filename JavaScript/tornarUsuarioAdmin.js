function tornarUsuarioAdmin(id){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/acoes/tornarUsuarioAdmin.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`id=${id}`)
    xhr.onload = function(){
        buscaUsuarios()
    }
    fecharMenu() 
}