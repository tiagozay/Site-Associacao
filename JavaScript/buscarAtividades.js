var inputOrdenarPor = document.querySelector("#ordem")
var ordenarPor = inputOrdenarPor.value
inputOrdenarPor.onchange = ()=>{
    ordenarPor = inputOrdenarPor.value
    buscaAtvidades()
}

var inputAutores = document.querySelector("#autores")
var autores = inputAutores.value
inputAutores.onchange = ()=>{
    autores = inputAutores.value
    buscaAtvidades()
}


var atividades;
buscaAtvidades()
function buscaAtvidades(){
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "./src/buscaDeDados/buscaAtividades.php")
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
    xhr.send(`ordem=${ordenarPor}&autores=${autores}`);
    xhr.onload = function(){
        atividades = JSON.parse(xhr.responseText)
        escreverAtividades()
    }
}    


//Apenas escreve as atividades na lista, buscando dados do array atividades
function escreverAtividades(){
    var tbodyLista = document.querySelector("#lista")
    tbodyLista.innerHTML = ""
    atividades.forEach(function(atividade){
        var autor = atividade['autor']
        var acao = atividade['acao']
        var data = atividade['dataRegistroFormatado'] 
        tbodyLista.innerHTML += `
        <tr class="tbody__tr">
            <td class="tbody__tr__tdGenerico tbody__tr__tdNome">
                <div class="tbody__tr__td__divConteudoGenerica tbody__tr__td__divNome"><p>${autor}</p></div>
            </td>
            <td class="tbody__tr__tdGenerico tbody__tr__tdAcao">
                <div class="tbody__tr__td__divConteudoGenerica">
                    <p>${acao}</p> 
                </div>    
            </td>
            <td class="tbody__tr__tdGenerico tbody__tr__tdData">
                <div class="tbody__tr__td__divConteudoGenerica">
                    <p class="data">${data}</p> 
                </div>    
            </td>
        </tr>
    `

    })
  

}
