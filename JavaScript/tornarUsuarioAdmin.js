function tornarUsuarioAdmin(id)
{
    const confirmacao = confirm("Deseja tornar este usuário administrador?");

    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/tornarUsuarioAdmin.php', `id=${id}`)
        .then(res => res.text())
        .then( () => {
            new MensagemLateralService("Usuário alterado com sucesso.");

            buscaUsuarios();
        })
        .catch((e) => {
            console.log(e);
            new MensagemLateralService("Erro ao editar usuário.");
        })
}