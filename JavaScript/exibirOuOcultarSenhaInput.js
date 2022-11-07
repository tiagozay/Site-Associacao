function exibirOuOcultarSenha(idInput){
    var input = document.querySelector(`#${idInput}`)
    if(input.type == 'password'){
        input.type = 'text'
        if(input.dataset.pagina == 'admin'){
            event.target.src = "assets/icons/eye-offPagAdmin.svg"
        }else if(input.dataset.pagina == 'alterarNomeOuSenha'){
            event.target.src = "assets/icons/eyePreto-off.svg"
        }
        else{
            event.target.src = "assets/icons/eye-off.svg"
        }
       
    }else if(input.type == 'text'){
        input.type = 'password'
        if(input.dataset.pagina == 'admin'){
            event.target.src = "assets/icons/eyePagAdmin.svg"
        }else if(input.dataset.pagina == 'alterarNomeOuSenha'){
            event.target.src = "assets/icons/eyePreto - .svg"
        }else{
            event.target.src = "assets/icons/eye.svg"
        }

    }
}
