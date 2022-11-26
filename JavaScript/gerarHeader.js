async function gerarHeader(){
        
    const header = document.querySelector(".divHeader");

    const httpService = new HttpService();

    let res = await httpService.get("back-end/geraHeader.php");

    let conteudoHeader = await res.text();

    header.innerHTML = conteudoHeader;

    configurar();

}