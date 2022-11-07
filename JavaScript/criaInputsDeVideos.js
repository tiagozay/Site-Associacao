var select = document.querySelector("#quantidadeDeVideos")
var inputsVideos = document.querySelector("#inputsVideos")
select.onchange = function(){
    var quantidadeDeInputs = select.value;
    inputsVideos.innerHTML = "";
    for(let i = 1; i <= quantidadeDeInputs; i++){
        inputsVideos.innerHTML += 
        `
        <div class="divLabelEInput">
            <label for="video${i}">
                Video ${i}:
                <input type="text" name="video${i}" id="video${i}" class="inputForm">
            </label>
        </div>

        `
    }
}