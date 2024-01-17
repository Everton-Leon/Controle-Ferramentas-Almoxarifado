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
                <a href="ferramentas.php" class="btn btn-primary mx-2">Área do Adiministrador</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </section>
    </header> 
    <!-- Área Principal -->
    <main class="container border rounded my-2">
    <section class="row">
            <div class="col-12 text-end">
                 <a href="#" data-bs-toggle="modal" data-bs-target="#modal-ajuda">
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg> 
                 </a>
            </div>
        </section>
    
        <section class="row mb-3">
            <div class="col-12 text-center">
                <h3 class="h4 "><strong>Obra</strong></h3>
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
                <img src="../img/img-ferramenta.png" id="imgFerramenta" class="rounded border float-left w-75" alt="Ferramenta">
            </div>
            <div class="col-4" id="div-seta">
                <!-- Seta -->
            </div>
            <div class="col-4">
                <img src="../img/img-funcionario.png" id="imgEfetivo" class="rounded border float-right w-75" alt="Efetivo">
            </div>
        </section>
        <section class="row text-center mb-3">
            <div class="col">
                <button type="submit" class="btn btn-primary" id="pegar-ferramenta" name="btn-pegar-ferramenta" disabled>Pegar Ferramenta</button>
                <button type="submit" class="btn btn-primary" id="devolver-ferramenta" name="btn-devolver-ferramenta" disabled>Devolver Ferramenta</button>
            </div>
        </section>
        </form>
        <section class="row text-center mb-3">
            <div class="col" id="camera">           
            </div>
        </section>
    </main>
     <p class="text-center bg-light m-0">Site criado por <a href="https://www.instagram.com/everton.leon7/" target="_blanc">Everton Leon</a>. E-mail para contato: <strong>evertonleon07@gmail.com</strong></p>

    <!-- Modal de Ajuda -->
    <div class="modal fade" id="modal-ajuda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Ajuda</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <p><strong>Bem-vindo ao nosso sistema de controle de ferramentas! Aqui estão algumas informações úteis para ajudar você a usar eficientemente o site:</strong></p>

        <p><strong>1. Registro de Ferramentas:</strong></p>

        <ul>
            <li>Para registrar uma ferramenta, insira o código da ferramenta no primeiro campo de input.</li>
            <li>Assim que você clicar fora da caixa de input, as informações detalhadas da ferramenta serão automaticamente preenchidas nos campos relevantes abaixo.</li>
        </ul>

        <p><strong>2. Registro do Funcionário:</strong></p>

        <ul>
            <li>Da mesma forma, insira o código do funcionário no segundo campo de input.</li>
            <li>Quando você clicar fora da caixa de input, as informações do funcionário serão carregadas nos campos apropriados.</li>
        </ul>

        <p><strong>3. Verificação de Disponibilidade:</strong></p>

        <ul>
            <li>Se a ferramenta estiver marcada como "Disponível" no banco de dados, o botão para pegar a ferramenta será ativado automaticamente.</li>
            <li>Se o status da ferramenta estiver como "Em Campo", o botão para devolver a ferramenta será habilitado.</li>
        </ul>

        <p><strong>4. Uso Eficiente:</strong></p>

        <ul>
            <li>Para uma experiência eficiente, certifique-se de que os códigos da ferramenta e do funcionário estejam corretos antes de confirmar.</li>
            <li>Se você precisar corrigir ou alterar as informações, basta digitar os novos códigos e clicar fora da caixa de input novamente.</li>
        </ul>

        <p><strong>5. Status Atual:</strong></p>

        <ul>
            <li>O status atual da ferramenta (Disponível, Em Campo, etc.) será exibido para sua referência imediata.</li>
            <li>Isso permite que você tome decisões rápidas com base no status atual da ferramenta.</li>
        </ul>

        <p><strong>6. Botões de Ação:</strong></p>

        <ul><li>Quando disponíveis, os botões de "Pegar Ferramenta" e "Devolver Ferramenta" serão liberados automaticamente, dependendo do status da ferramenta.</li></ul>

        <p><strong>Agradeço por utilizar meu sistema de controle de ferramentas. Se houver algo mais em que posso ajudar, não hesite em me informar. Tenha um excelente dia!</strong></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>


    <!-- JavaScript -->
    <script src="../js/js-bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/js-bootstrap/bootstrap.min.js"></script>
    <script src="../js/quagga.min.js"></script>

    <!-- Script com as funções que serão usadas  -->
    <script>
        // Leitor de código de barras
        function lerCodigoDeBarras(){
            Quagga.init({
                inputStream : {
                name : "Live",
                type : "LiveStream",
                target: document.querySelector('#camera')    // Or '#yourElement' (optional)
                },
                decoder : {
                readers : ["code_128_reader"]
                }
            }, function(err) {
                if (err) {
                    console.log(err);
                    return
                }
                console.log("Initialization finished. Ready to start");
                Quagga.start();
            });

            Quagga.onDetected(function (data) {
                console.log(data)
            })
        }


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

                    imgFerramenta.onerror = function() {
                        imgFerramenta.src = "../img/f-sem-img.png";
                    };

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

                    imgEfetivo.onerror = function() {
                        imgEfetivo.src = "../img/e-sem-img.png";
                    };
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