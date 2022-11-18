function excluirIntegrante(id)
{
    const confirmacao = confirm("Excluír este integrante?");
    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/excluirIntegrante.php', `id=${id}`)
    .then( () => {

        new MensagemLateralService("Integrante excluído com sucesso.");

        buscarIntegrantes();
      
    } )
    .catch( () => {
        new MensagemLateralService("Não foi possível excluír integrante.");
    } )
    
}