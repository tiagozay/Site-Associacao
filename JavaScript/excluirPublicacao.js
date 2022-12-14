function excluirPublicacao(event, id)
{
    //Para o event bubbling do JavaScript, pois aí nesse caso, quando clicar no btn de excluír, o método onclick da li seria chamado, redirecionando a página
    event.stopPropagation();

    let confirmacao = confirm("Deseja excluír esta publicação?");
    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/excluirPublicacao.php', `id=${id}`)
    .then( res => res.text() )
    .then( () => {

        new MensagemLateralService("Publicação excluída com sucesso.");

        buscaPublicacoes();
    })
    .catch( (e) => {
        new MensagemLateralService("Não foi possível excluír esta publicação.");
    })
}