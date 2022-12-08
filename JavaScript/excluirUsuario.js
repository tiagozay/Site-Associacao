function excluirUsuario(id)
{
    const confirmacao = confirm("Deseja excluír este usuário? Todos seus comentários e curtidas serão removidos!");

    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/excluirUsuario.php', `id=${id}`)
        .then(res => res.text())
        .then( () => {
            new MensagemLateralService("Usuário excluído com sucesso.");

            buscaUsuarios();
        })
        .catch((e) => {
            console.log(e);
            new MensagemLateralService("Erro ao excluír usuário.");
        })

}