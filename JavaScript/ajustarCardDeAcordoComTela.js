//Código que calcula o tamanho em px que o card da publicação deve ter, de acordo com o tamanho da tela e altera a variável css responsável por guardar o tamanho que é usado em várias partes do código

function calculaEDefinePorcentagem()
{
    let porcentagem = 31.1;
   
    if(window.innerWidth <= 1000){
        porcentagem = 47;
    }

    if(window.innerWidth <= 610){
        porcentagem = 95;
    }

    return porcentagem;

}

calculaEAlteraValorDaLarguraCard();
window.onresize = () => {

    calculaEAlteraValorDaLarguraCard();
}

function calculaEAlteraValorDaLarguraCard()
{
    const porcentagem = calculaEDefinePorcentagem();

    let calculoTamanhoDoCard = (window.innerWidth * porcentagem) / 100;

    document.documentElement.style.setProperty('--larguraCard', calculoTamanhoDoCard+"px");
}
