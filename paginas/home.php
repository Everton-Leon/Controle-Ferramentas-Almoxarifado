<?php 
// Importação da conexão
require_once "../php/db_connect.php"; 
// Iniciando sessão
session_start();

// Verifiacndo se o usuário está logado
if(!isset($_SESSION['logado'])):
    header('Location: ../index.php');
endif;

// Verifica se a sessão mensagem existe
if (isset($_SESSION['mensagem'])): ?>
    <script>
        window.onload = function () {
            alert('<?php echo $_SESSION['mensagem']; ?>')
        }
    </script>
    <?php
endif;
unset($_SESSION['mensagem']);

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxerifado - home</title>  
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="../css/css-bootstrap/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="container-fluid" id="faixa-header">
        <section class="row p-4">
            <div class="col-8 p-2">
                <img class="img-fluid w-25 p-1" src="../img/logo-direcional.png" alt="Logo-Direcional">
            </div>
            <div class="col-4 p-2 text-end">
                <a href="#" class="btn btn-info">Ajuda</a>
                <a href="ferramentas.php" class="btn btn-primary mx-2">Área do Adiministrador</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </section>
    </header> 
    <!-- Área Principal -->
    <main class="container border rounded my-2">
        <section class="row mb-3">
            <div class="col-12 text-center">
                <h3 class="h4 mt-4"><strong>Obra</strong></h3>
                <input type="text" readonly class="form-control-plaintext text-center" id="iobra" name="obra" placeholder="OBRA 369CE - MÃO DE OBRA DIRETA">
            </div>
        </section>
        <form action="../php/cadastro-devolucao.php" method="POST">
        <!-- Linha da Ferramenta -->
        <section class="row border text-center mb-3">
            <div class="col">
                <label for="icodigo-ferramenta">Código Ferramenta</label>
                <input type="text" class="form-control" id="icodigo-ferramenta" name="codigo-ferramenta" placeholder="000000" required pattern="[0-9]+" minlength="6" maxlength="10" onblur="getValoresFerramenta()">
              </div>
              <div class="col">
                <label for="iferramenta">Ferramenta</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="iferramenta" name="ferramenta" required pattern="[0-9]+" minlength="6" maxlength="10" placeholder="Martelete">
              </div>
              <div class="col">
                <label for="ihorario">Data e Hora</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="ihorario" placeholder="06/02/2004">
              </div>
        </section>
        <!-- Linha do Funcionário -->
        <section class="row border text-center mb-3">
            <div class="col">
                <label for="icodigo-funcionario">Código Funcionário</label>
                <input type="text" class="form-control" id="icodigo-funcionario" name="codFunc" placeholder="000000" required onblur="getValoresFuncionario()">
              </div>
              <div class="col">
                <label for="inome">Nome</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="inome" name="nomeFunc" placeholder="João da Silva">
              </div>
              <div class="col">
                <label for="ifuncao">Função</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="ifuncao" name="funcao" placeholder="Pedreiro">
              </div>
        </section>
        <!-- Linha Encarregado -->
        <section class="row border text-center mb-3">
            <div class="col">
                <label for="iencarregado">Encarregado</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="iencarregado" name="encarregado" placeholder="Edinho">
            </div>
            <div class="col">
                <label for="isecao">Seção</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="isecao" name="secao" placeholder="OBRA 369CE - MÃO DE OBRA DIRETA">
            </div>
            <div class="col">
                <label for="ifrente-servico">Frente de Serviço</label>
                <input type="text" readonly class="form-control-plaintext text-center" id="ifrente-servico" name="frente-servico" placeholder="Almoxerife">
            </div>
        </section>
        <!-- Linha Imagens -->
        <section class="row text-center mb-3">
            <div class="col-4">
                <img src="../img/img-ferramenta.png" id="imgFerramenta" class="rounded float-left w-75" alt="Ferramenta">
            </div>
            <div class="col-4" id="div-seta">
                <!-- Seta -->
            </div>
            <div class="col-4">
                <img src="../img/img-funcionario.png" id="imgEfetivo" class="rounded float-right w-75" alt="Efetivo">
            </div>
        </section>
        <section class="row text-center mb-3">
            <div class="col">
                <button type="submit" class="btn btn-primary" id="pegar-ferramenta" name="btn-pegar-ferramenta" disabled>Pegar Ferramenta</button>
                <button type="submit" class="btn btn-primary" id="devolver-ferramenta" name="btn-devolver-ferramenta" disabled>Devolver Ferramenta</button>
            </div>
        </section>
        </form>
    </main>


    <!-- JavaScript -->
    <script src="../js/js-bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/js-bootstrap/bootstrap.min.js"></script>

    <!-- Script com as funções que serão usadas  -->
    <script>

        // Funcão para pegar os dados da ferramenta
        function getValoresFerramenta(){
            // variáveis 
            var codFerramenta = document.getElementById('icodigo-ferramenta').value;
            var nomeFerramenta = document.getElementById('iferramenta');
            var horario = document.getElementById('ihorario');
            var imgFerramenta = document.getElementById('imgFerramenta');
            var status = "";
            var btnPegarFerramenta = document.getElementById('pegar-ferramenta');
            var btnDevolverFerramenta = document.getElementById('devolver-ferramenta');
            var seta = document.createElement('img');
            seta.className = 'rounded float-left w-75';
            document.getElementById('div-seta').innerHTML = "";
            imgFerramenta.src = null;
            
            // cria o objeto XMLHttpRequest
            const xhttp = new XMLHttpRequest();

            // verifica se o codigo não está vazio
            if (!codFerramenta.length == 0) {
                // chama a função quando a requisição estiver pronta
                xhttp.onload = function() { 
                 // Divide a resposta em partes (nome e horário) usando o caractere "|"
                var resposta = this.responseText.split("|");
            
                // verifica se o valor retornada existe no banco de dados 
                if (resposta.length == 1) {
                    alert(resposta[0]);
                    codFerramenta = "";
                    nomeFerramenta.value = ""; // Nome
                    horario.value = ""; // Horário
                    imgFerramenta.src = "";
                } else {
                    // Se não ele atualiza os valores dos inputs com as partes separadas
                    nomeFerramenta.value = resposta[0]; // Nome
                    horario.value = dataHora(); // Horário
                    imgFerramenta.src = resposta[1];
                    status = resposta[2];


                    if(status == "Em campo"){
                        btnDevolverFerramenta.removeAttribute("disabled"); // Ativa o botão de devolver a ferramenta  
                        btnPegarFerramenta.setAttribute("disabled", "true"); // Desativa o botão de pegar a ferramenta

                        // muda a seta
                        seta.src = '../img/seta-voltando.png';
                    }else {
                        btnPegarFerramenta.removeAttribute("disabled"); // Ativa o botão de pegar a ferramenta 
                        btnDevolverFerramenta.setAttribute("disabled", "true"); // Desativa o botão de devolver a ferramenta

                        // muda a seta 
                        seta.src = '../img/seta-indo.png';
                    }

                    document.getElementById('div-seta').appendChild(seta);
                    
                }
                }
                // faz a requisição AJAX - método GET ou POST
                xhttp.open("GET", "../php/mostrar-dados-ferramentas.php?codFerramenta="+codFerramenta);
                xhttp.send();
            }
        }   

        // Função para pegar os valores do banco de dados (efetivo)
        function getValoresFuncionario() {
            // variáveis 
            var codFunc = document.getElementById('icodigo-funcionario').value;
            var nomeFunc = document.getElementById('inome');
            var funcao = document.getElementById('ifuncao');
            var encarregado = document.getElementById('iencarregado');
            var secao = document.getElementById('isecao');
            var obra = document.getElementById('iobra');
            var frenServi = document.getElementById('ifrente-servico');
            var imgEfetivo = document.getElementById('imgEfetivo');

            // cria o objeto XMLHttpRequest
            const xhttp = new XMLHttpRequest();

            if(!codFunc.length == 0){
                // chama a função quando a requisição estiver pronta
                xhttp.onload = function() { 
                 // Divide a resposta em partes (nome e horário) usando o caractere "|"
                var resposta = this.responseText.split("|");

                // verifica se o valor retornada existe no banco de dados 
                if (resposta.length == 1) {
                    alert(resposta[0]);
                    nomeFunc.value = "";
                    funcao.value = "";
                    encarregado.value = "";
                    secao.value = "";
                    frenServi.value = "";
                    imgEfetivo.src = "";
                }else {
                    // Se não ele atualiza os valores dos inputs com as partes separadas
                    nomeFunc.value = resposta[0];
                    funcao.value = resposta[1];
                    encarregado.value = resposta[2];
                    secao.value = resposta[3];
                    obra.value = resposta[3];
                    frenServi.value = resposta[4];
                    imgEfetivo.src = resposta[5];

                    if (imgEfetivo.src === "") {
                        imgEfetivo.src = '../img/e-sem-img.png';
                    }
                }
                }
                // faz a requisição AJAX - método GET ou POST
                xhttp.open("GET", "../php/mostrar-dados-efetivo.php?codFunc="+codFunc);
                xhttp.send();
            }
        }

        // função da data
        function dataHora() {
            const dataAtual = new Date();

            const ano = dataAtual.getFullYear();
            const mes = dataAtual.getMonth() + 1; 
            const dia = dataAtual.getDate();
            const mesFormatado = mes < 10 ? `0${mes}` : mes;
            const diaFormatado = dia < 10 ? `0${dia}` : dia;
            var h = dataAtual.getHours();
            var m = dataAtual.getMinutes();
            var s = dataAtual.getSeconds();
            var horasFormatadas = h < 10 ? `0${h}` : h;
            var minutosFormatados = m < 10 ? `0${m}` : m;
            var segundosFormatados = s < 10 ? `0${s}` : s;

            const dataFormatada = `${diaFormatado}/${mesFormatado}/${ano} ${horasFormatadas}:${minutosFormatados}:${segundosFormatados}`;
            return dataFormatada;
        }
    </script>
</body>
</html>