const spanQuantidade = document.querySelector("#quantidade");

let toggleBoolean_usuarioJaCurtiu;

async function curtirPublicacao(event)
{
    if(!idUsuario){
        alert("Você precisa estar logado para curtir!");
        return;
    }

    //No primeiro click, verifica se o usuário já curtiu. Esta informação que está guardada na variável toggleBoolean_usuarioJaCurtiu e adicionada na hora que ele faz a busca e a escrita da publicação. Se ele já tiver curtido, decrementa a quantidade, escreve e altera o valor do indicar, fazendo com que na próxima vez que clicar caia no else e incremente a quantidade
    if(toggleBoolean_usuarioJaCurtiu){
        publicacaoExibida['quantidadeCurtidas']--;

        escreveQuantidadeDeCurtidas(publicacaoExibida['quantidadeCurtidas']);
        toggleBoolean_usuarioJaCurtiu = false;
    }else{
        publicacaoExibida['quantidadeCurtidas']++;

        escreveQuantidadeDeCurtidas(publicacaoExibida['quantidadeCurtidas']);
        toggleBoolean_usuarioJaCurtiu = true;  
    }

    const httpService = new HttpService();

    let res = await httpService.post(
        'back-end/curtirPublicacao.php',
        `idPublicacao=${idPublicacao}&idUsuario=${idUsuario}`
    );

    let text = await res.text();

    console.log(text);

}

function escreveQuantidadeDeCurtidas(quantidade)
{
    spanQuantidade.innerHTML = `(${quantidade})`;
}