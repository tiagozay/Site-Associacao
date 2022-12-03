function configurar()
{
    let menu = document.querySelector('.conteudo');

    if(menu){
        onclick = (event) => {

            if(event.target.classList[0] == 'iconeAbrirMenuConfig' || event.target.classList[0] == 'btnAbrirMenuConfigUser'){
                abrirConfiguracoesUsuario();
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
        
        let cards = document.querySelectorAll(".card");

        //Percorre todos os cards de noticias e adiciona ou remove o zindex ao abrir o menu
        cards.forEach(function(card){
            card.classList.toggle('card-com-zindex');
        })
    }
}

