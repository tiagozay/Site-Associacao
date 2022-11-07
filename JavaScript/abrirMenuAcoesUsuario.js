var menu = document.querySelector('.conteudo')
var cards = document.querySelectorAll(".card")
if(menu != null){
    onclick = ()=>{
        if(event.target.classList[0] == 'iconeAbrirMenuConfig' || event.target.classList[0] == 'btnAbrirMenuConfigUser'){
            abrirConfiguracoesUsuario()
        }else{
            if(menu.classList[1]){
                if(menu.classList[1] == 'abrirMenuConfigUsuario'){
                    abrirConfiguracoesUsuario()
                } 
            }
              
        }
    }
}




function abrirConfiguracoesUsuario(){
    menu.classList.toggle('abrirMenuConfigUsuario')
    //Percorre todos os cards de noticias e adiciona ou remove o zindex ao abriri o menu
    cards.forEach(function(card){
        card.classList.toggle('card-com-zindex');
    })
}