var containerModal = document.querySelector(".containerModal")
var modal = document.querySelector(".modal")
var modal__conteudo = document.querySelector(".modal__conteudo")
var modal__titulo = document.querySelector(".tituloModal")

function create_modal(tipo__modal){
    containerModal.classList.add("abrirContainerModal")
    modal.classList.add("abrirModal")
    document.body.classList.add("removerScroll")


    switch (tipo__modal){
        case 'confirmação para tornar admin':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idUsuario = event.target.dataset.id;
            var nomeUsuario = event.target.dataset.nome;

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Tornar ${nomeUsuario} administrador(a)?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.textContent = 'Confirmar'
            btnConfirmar.addEventListener("click",function(){tornarUsuarioAdmin(idUsuario)})

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)

            break;
        case 'confirmação para remover de admin':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idUsuario = event.target.dataset.id;
            var nomeUsuario = event.target.dataset.nome;

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Remover ${nomeUsuario} de administrador(a)?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.addEventListener("click", function(){removerUsuarioDeAdmin(idUsuario)})
            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)


            break;
        case 'confirmação para excluir usuario':
            limparModal()
            modal__titulo.textContent = 'Excluir'

            var idUsuario = event.target.dataset.id;
            var nomeUsuario = event.target.dataset.nome;

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Remover ${event.target.dataset.nome} do sistema?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.textContent = 'Confirmar'
            btnConfirmar.addEventListener("click", function(){excluirUsuario(idUsuario)})

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)

            break;
        case 'menu de açoes para usuários da lista':
            var idUsuario = event.target.dataset.id;
            var nomeUsuario = event.target.dataset.nome;
            var emailUsuario = event.target.dataset.email;
            var nivelUsuario = event.target.dataset.nivel;

            modal__titulo.textContent = 'Opções';

            //NOME USUÁRIO
            var h2NomeUsuario = document.createElement('h2')
            h2NomeUsuario.classList.add('nome-usuario');
            h2NomeUsuario.textContent = nomeUsuario;

            //EMAIL USUÁRIO
            var h2EmailUsuario = document.createElement("h2")
            h2EmailUsuario.classList.add('email-usuario')
            h2EmailUsuario.textContent = emailUsuario;

            //NÍVEL USUÁRIO
            var h2NivelUsuario = document.createElement('h2')
            h2NivelUsuario.classList.add('nivel-usuario');
            h2NivelUsuario.textContent = nivelUsuario;

            //NAV
            var nav = document.createElement('nav')
            nav.classList.add('navAcoesUsuarios')

            //BOTÃO NIVEL
            var btnNivel = document.createElement('button')
            btnNivel.classList.add('btnAcoesResponsivo')
            btnNivel.dataset.nome = nomeUsuario;
            btnNivel.dataset.id = idUsuario;
            if(nivelUsuario == 'admin'){
                btnNivel.textContent = 'Remover de admin'
                btnNivel.addEventListener('click', ()=>{ create_modal('confirmação para remover de admin') })
            }else if(nivelUsuario == 'usuario'){
                btnNivel.textContent = 'Tornar admin'
                btnNivel.classList.add('btnTornarAdmin')
                btnNivel.addEventListener('click', ()=>{ create_modal('confirmação para tornar admin') })
            }

            //BOTÃO EXCLUIR
            var btnExcluir = document.createElement('button')
            btnExcluir.classList.add('btnAcoesResponsivo')
            btnExcluir.dataset.nome = nomeUsuario;
            btnExcluir.dataset.id = idUsuario;
            btnExcluir.textContent = 'Excluir'
            btnExcluir.addEventListener('click', ()=>{ create_modal('confirmação para excluir usuario') })
           
            
            modal__conteudo.appendChild(h2NomeUsuario)
            modal__conteudo.appendChild(h2EmailUsuario)
            modal__conteudo.appendChild(h2NivelUsuario)
            modal__conteudo.appendChild(nav)
            nav.appendChild(btnNivel)
            nav.appendChild(btnExcluir)

            break;

        case 'confirmação para excluir noticia':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idNoticia = event.target.dataset.id;

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir publicação permanentemente?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('a')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.setAttribute('href', `src/acoes/deletarPublicacao.php?id=${idNoticia}`)
            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            break;

        case 'confirmação para excluir integrante':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            
            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir integrante ${event.target.dataset.nome} ?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('a')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.setAttribute("href",`src/acoes/removerIntegrante.php?id=${event.target.dataset.id}`)
            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            break;
        

        case 'confirmação para adm excluir comentario':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idComentario = event.target.dataset.idcomentario;
            
            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir comentário de ${event.target.dataset.nome} ?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.addEventListener("click",function(){adminExcluirComentario(idComentario)})

            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            break;

        case 'confirmação para usuario excluir seu comentario':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idComentario = event.target.dataset.idcomentario;

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir seu comentário? ` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.addEventListener("click", function(){excluirComentario(idComentario)})

            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            modal__conteudo.classList.add('conteudoComEspacamento')
            break;

        case 'criar conta para curtir e comentar':
            limparModal()
            modal__titulo.textContent = 'Entre'

            
            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Para curtir e comentar você precisa estar cadastrado!` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnConfirmar = document.createElement('a')
            btnConfirmar.setAttribute("href", 'paginaLogin.php?pagAnterior=publicacao.php')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.classList.add("btnEntrar")

            btnConfirmar.textContent = 'Entrar'

            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            modal__conteudo.classList.add('conteudoComEspacamento')
            break;

        case 'confirmação para excluir imagem':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idImagem = event.target.dataset.idimg 

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir imagem? ` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.addEventListener("click", function(){excluirImagem(idImagem)})

            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            modal__conteudo.classList.add('conteudoComEspacamento')
            break;
        case 'confirmação para excluir video':
            limparModal()
            modal__titulo.textContent = 'Confirmação'

            var idNoticia = event.target.dataset.id;
            var idVideo = event.target.dataset.idvideo

            var h2Titulo = document.createElement('h2')
            h2Titulo.classList.add('pergunta')
            h2Titulo.textContent = `Excluir vídeo permanentemente?` 

            var nav = document.createElement('nav')
            nav.classList.add('nav')
            
            var btnCancelar = document.createElement('button')
            btnCancelar.classList.add('btnCancelar')
            btnCancelar.addEventListener('click', fecharMenu)
            btnCancelar.textContent = 'Cancelar';

            var btnConfirmar = document.createElement('button')
            btnConfirmar.classList.add('btnConfirmar')
            btnConfirmar.addEventListener("click", function(){excluirVideo(idVideo)})
            btnConfirmar.textContent = 'Confirmar'

            nav.appendChild(btnCancelar)
            nav.appendChild(btnConfirmar)
            
            modal__conteudo.appendChild(h2Titulo)
            modal__conteudo.appendChild(nav)
            break;

    }

    //confirmação para tornar admin

    //confirmação para exluir usuario

    //confirmação para remover de admin

    //confirmação para exluir notícia
    
    //confirmação para exluir integrante

    //criar conta ou logar
    
    
}

function fecharMenu(){
    containerModal.classList.remove("abrirContainerModal")
    modal.classList.remove("abrirModal")
    document.body.classList.remove("removerScroll")
    limparModal();
    indicador = false;
}

function limparModal(){
    modal__titulo.innerText = '';
    modal__conteudo.innerText = '';
}


containerModal.addEventListener('click', ()=> {
    if(event.target.classList[0] == 'containerModal'){
        fecharMenu()
    }
})