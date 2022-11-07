window.onresize = ()=>{
    if(window.innerWidth > 495){
        fecharMenuSecoes()
    }
}


var links = document.querySelectorAll(".links")
function fecharMenuSecoes(){
    for(let i = 0; i < links.length; i++){
        links[i].classList.remove('abrirMenu')
    }
}

function abrirFecharMenu(){
    for(let i = 0; i < links.length; i++){
        links[i].classList.toggle('abrirMenu')
    }
    
}

document.onclick = (event)=>{
    if(event.pageY > 350 || event.pageY < 75){
        fecharMenuSecoes()
    }
}