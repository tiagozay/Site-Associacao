class DateHelper
{
    static formataData(data)
    {
        const dia = ("0"+data.getDate()).slice(-2);
        const mes = ("0"+(data.getMonth()+1)).slice(-2);
        const ano = data.getFullYear();

        return `${dia}/${mes}/${ano}`;
    }

    static formataDataComHorario(data)
    {
        const dia = ("0"+data.getDate()).slice(-2);
        const mes = ("0"+(data.getMonth()+1)).slice(-2);
        const ano = data.getFullYear();
        const hora = data.getHours();
        const minuto = data.getMinutes();

        return `${dia}/${mes}/${ano} ${hora}:${minuto}`;
    }

    static removeHorarioDaData(stringData)
    {
        let dataArr = stringData.split(" ");

        return dataArr[0];
    }

}