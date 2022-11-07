var idPublicacao = document.querySelector(".idPublicacao");
function buscarVideos(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", './src/buscaDeDados/buscarVideos.php');
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`idPublicacao=${idPublicacao.value}`)
    xhr.onload = function(){
        escreverVideos(JSON.parse(xhr.responseText))
    }   
}
buscarVideos()

var gridVideos = document.querySelector(".gridVideos")
function escreverVideos(videos){
    gridVideos.innerHTML = "";
    videos.forEach(function(video){
        gridVideos.innerHTML += `
        <div class="divVideo">
            <button type="button" data-idvideo=${video['id']} onclick="create_modal('confirmação para excluir video')"><i class="material-icons" data-idvideo=${video['id']}>delete</i></button>
            <object>
                <param name="movie" value="${video['urlVideo']}" />
                <embed src="${video['urlVideo']}" type="application/x-shockwave-flash"/>
            </object>
        </div>
        
        
        `
    })
}