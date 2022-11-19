function excluirUsuario(id)
{
    const confirmacao = confirm("Deseja excluír este usuário?");

    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/excluirUsuario.php', `id=${id}`)
        .then(res => res.text())
        .then( () => {
            new MensagemLateralService("Usuário excluído com sucesso.");

            buscaUsuarios();
        })
        .catch(() => {
            new MensagemLateralService("Erro ao excluír usuário.");
        })

}