function removerAdminDeUsuario(id)
{
    const confirmacao = confirm("Deseja remover este usuário de administrador?");

    if(!confirmacao) return;

    const httpService = new HttpService();

    httpService.post('back-end/removerAdminDeUsuario.php', `id=${id}`)
        .then(res => res.text())
        .then( (msg) => {
            console.log(msg)

            new MensagemLateralService("Usuário alterado com sucesso.");

            buscaUsuarios();
        })
        .catch((msg) => {

            console.log(msg)


            new MensagemLateralService("Erro ao editar usuário.");
        })
}