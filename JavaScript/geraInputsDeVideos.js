const select = document.querySelector("#quantidadeDeNovosVideos");

var divInputsVideos = document.querySelector("#divInputsVideos");

select.onchange = function(){

    let quantidadeDeInputs = select.value;

    divInputsVideos.innerHTML = "";

    for(let i = 1; i <= quantidadeDeInputs; i++){
        divInputsVideos.innerHTML += 
        `
        <div class="divLabelEInput">
            <label for="video${i}" id="labelVideo">Video ${i}:</label>
                <input type="text" name="video${i}" id="video${i}" class="inputForm inputVideo">
                <span class="eror display-none" id='msgErro-video${i}'></span>
        </div>

        `
    }
}