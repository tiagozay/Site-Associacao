function removerAdminDeUsuario(id)
{
    const confirmacao = confirm("Deseja remover este usuário de administrador?");

    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/removerAdminDeUsuario.php', `id=${id}`)
        .then(() => {
            new MensagemLateralService("Usuário alterado com sucesso.");
            buscaUsuarios();
        })
        .catch(() => {
            new MensagemLateralService("Erro ao editar usuário.");
        })
}