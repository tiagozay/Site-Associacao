function excluirPublicacao(id)
{
    let confirmacao = confirm("Deseja excluír esta publicação?");
    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/excluirPublicacao.php', `id=${id}`)
    .then( res => res.text() )
    .then( () => {

        new MensagemLateralService("Publicação excluída com sucesso.");

        buscaPublicacoes();
    })
    .catch( () => {
        new MensagemLateralService("Não foi possível exclúir esta publicação.");
    })
}