var xhr = new XMLHttpRequest();
xhr.open("POST", './src/acoes/salvarTamanhoDeTela.php');
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
xhr.send("tamanho="+window.innerWidth)