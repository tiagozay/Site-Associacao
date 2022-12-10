<?php
    session_start();

    $_SESSION['nivel'] = 'admin';

    if($_SESSION['nivel'] != 'admin'){
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/reset.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
    rel="stylesheet">

    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/Admin/paginaIntegrante/paginaIntegrante.css">
    <link rel="stylesheet" href="assets/styles/mensagemLateral.css">
    
    <title>Integrantes</title>
</head>
<body>
    <section class="sectionIntegrantes">
        <fieldset>
            <legend>Integrantes</legend>

            <div class="divBtnVoltar">   
                <a href="Admin-pagInicial.php" class="btnVoltarPagIniAdmin"><i class="material-icons">logout</i> Voltar</a>
            </div>
        
            <div class="container">
                <form enctype="multipart/form-data" class="form" id="formulario">
                    <div class="divLabelEInput">
                        <label for="nome">Nome:</label>
                        <input type="text" id="nome" name="nome" class="inputForm">
                        <span class="eror display-none" id='msgErro-nome'></span>
                    </div>
                
                    <div class="divLabelEInput">
                        <label for="cargo">Cargo:</label>
                        <select name="cargo" id="cargo"  class="inputForm">
                            <option disabled selected>SELECIONAR</option>
                            <option value="Presidente">Presidente</option>
                            <option value="Vice presidente">Vice presidente</option>
                            <option value="1º Secretário(a)">1º Secretário(a)</option>
                            <option value="2º Secretário(a)">2º Secretário(a)</option>
                            <option value="1º Tesoureiro(a)">1º Tesoureiro(a)</option>
                            <option value="2º Tesoureiro(a)">2º Tesoureiro(a)</option>
                            <option value="Integrante">Integrante</option>
                        </select>
                        <span class="eror display-none" id='msgErro-cargo'></span>
                    </div>

                    <div class="divLabelEInput">
                        <label for="perfil">Perfil:</label>
                        <input type="file" name="imagem" id="perfil" class="inputPerfil" accept="image/*">
                        <span class="eror display-none" id='msgErro-imagem'></span>
                    </div> 
        
                    <button type="submit">
                        Cadastrar integrante
                        <div class="display-none" id="loaderEnviar"></div>
                    </button>
                </form>

            </div>

            <div class="divListaIntegrantes">

                    <div class="desativarLoader"  id="divLoaderBuscarIntegrantes">
                        <div id="loaderBuscarIntegrantes"></div>
                        Buscando integrantes...
                    </div>
                   
                    <ul id="divListaIntegrantes__lista">
                
                    </ul>
            </div>
        </fieldset>
    </section>
    
    <script src="JavaScript/Services/HttpService.js"></script>
    <script src="JavaScript/Services/MensagemLateralService.js"></script>
    <script src="JavaScript/Services/ImagemService.js"></script>
    <script src="JavaScript/buscaIntegrantesAdmin.js"></script>
    <script src="JavaScript/excluirIntegrante.js"></script>
    <script>

        let formulario = document.querySelector("#formulario");

        async function cadastra()
        {
            let formData = new FormData(formulario);

            const validacao = validaIntegrante(formulario.nome, formulario.cargo, formulario.imagem);

            if(!validacao){
                return;
            }
            
            let loader = document.querySelector("#loaderEnviar");

            loader.classList.remove("display-none");

            let imagemDiminuida = await ImagemService.diminuiTamanhoDeImagem(800, formulario.imagem.files[0]);

            formData.set('imagem', imagemDiminuida);

            const httpService = new HttpService();

            try{
                let res = await httpService.postFormulario(formData, 'back-end/cadastraIntegrante.php');

                let msg = await res.text();

                console.log(msg);

                formulario.reset();

                loader.classList.add("display-none");

                new MensagemLateralService("Integrante cadastrado com sucesso!");

                buscarIntegrantes();
            }catch(e){
                console.log("Caiu no catch: ", e);

                loader.classList.add("display-none");

                new MensagemLateralService("Erro ao cadastrar integrante");
            }

        }

    
    formulario.onsubmit = (event) => {

        event.preventDefault();

        cadastra();

    }

        function abrirMensagemDeErroDoInput(input, mensagem){
            input.focus();

            let msgErro = document.querySelector(`#msgErro-${input.name}`);
            msgErro.classList.remove('display-none');
            msgErro.innerHTML = mensagem;
        }

        function fecharMensagemDeErroDoInput(input){
            let msgErro = document.querySelector(`#msgErro-${input.name}`);
            msgErro.classList.add('display-none');
            msgErro.innerHTML = "";
        }

        function validaIntegrante(campoNome, campoCargo, campoImagem)
        {
            let nome = campoNome.value;
            let cargo = campoCargo.value;
            let imagem = campoImagem.files[0];

            //Faz essa validação, pois se colocarmos apenas required no campo, se eu preencher com espaços vazios acaba passando
            if(nome.trim().length == 0){
                abrirMensagemDeErroDoInput(campoNome, "Preencha o nome.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoNome);
            

            if(cargo == 'SELECIONAR'){
                abrirMensagemDeErroDoInput(campoCargo, "Informe o cargo.");
                return false;
            }
            fecharMensagemDeErroDoInput(campoCargo);


            //Chama a função valida imagem da ImagemService. A mesma lança um erro caso algo esteja incorreto passando o tipo do erro, aí no catch pego ele e chamo a função correspondente de cada mensagem de erro que deve aparecer no input. Caso não tenha erros, as mensagens de erro (caso existam), serão removidas
            try{
                ImagemService.validaImagem(imagem);
                fecharMensagemDeErroDoInput(campoImagem);
            }catch(e){

                let errors = {
                    'imagem_nao_informada' : () => {
                        abrirMensagemDeErroDoInput(campoImagem, "Informe um perfil.");  
                    },
                    'imagem_muito_grande' : () => {
                        abrirMensagemDeErroDoInput(campoImagem, "Imagem muito grande.");
                    },
                    'extensao_de_imagem_invalida' : () =>  {
                        abrirMensagemDeErroDoInput(campoImagem, "Imagem inválida.");
                    }
                };

                errors[e.message]();

                return false;

            }
                
            return true;
        }

    </script>

</body>
</html>