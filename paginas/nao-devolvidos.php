<?php 
// Importação da conexão
require_once "../php/db_connect.php";
// Iniciando sessão
session_start();

// Verifiacndo se o usuário está logado
if(!isset($_SESSION['logado'])):
    header('Location: ../index.php');
endif;

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxarifado - Não Devolvidos</title>  
    <!-- Favicon -->
    <link rel="shortcut icon" href="../img/favicon.png" type="image/x-icon">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="../css/css-bootstrap/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/area-admin.css">
</head>
<body>
    <section class="container-fluid">
        <section class="row vh-100 ">
            <!-- Menu Lateral -->
            <div id="menu-lateral" class="col-2 vh-100 position-fixed">
                <img class="img-fluid mt-4 p-4" src="../img/logo-direcional.png" alt="Logo-Direcional">
                <nav class="nav flex-column mt-4">
                    <a class="nav-link mb-2" href="ferramentas.php"><span>Ferramentas</span></a>
                    <a class="nav-link mb-2" href="efetivo.php"><span>Efetivo</span></a>
                    <a id="link-ativo" class="nav-link mb-2" href="#"><span>Não Devolvidos</span></a>
                    <a class="nav-link mb-2" href="historico.php"><span>Histórico</span></a>
                </nav>
                <div id="div-sair" class="row align-items-end"><a class="col" href="home.php">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="30" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z"/>
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>Voltar</span></a>
                </div>
            </div>
            <!-- Àrea da Tabela -->
            <div class="col-10 offset-2">
                <!-- Cabeçalho -->
                <div class="row align-items-center mt-3">
                <div class="col-8">
                    <h1 class="h1">Não Devolvidos</h1>
                </div>
                <div class="col-4 text-end">
                    <button type="button" class="btn btn-outline-dark" id="btnGerarPDF" onclick="gerarPDF()">Gerar PDF</button>
                </div>
                <!-- Tabela -->
                </div>
                <div class="row my-3">
                <div class="col-12 table-responsive">
                    <table id="table" class="table table-sm table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Código Ferramenta</th>
                                <th>Ferramenta</th>
                                <th>Nome Efetivo</th>
                                <th>Encarregado</th>
                                <th>Frente de Serviço</th>
                                <th>Horário</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <!-- Puxando os dados do banco de dados e mostrando eles -->
                            <?php
                            $sql = "SELECT * FROM nao_devolvidos order by horario";
                            $resultado = mysqli_query($connect, $sql);
                            $cont = 1;
                            while ($dados = mysqli_fetch_array($resultado)):
                            ?>
                            <tr>
                                <td><?php echo $cont; ?></td>
                                <td><?php echo $dados['cod_ferramenta']; ?></td>
                                <td><?php echo $dados['nome_ferramenta']; ?></td>
                                <td><?php echo $dados['nome_func']; ?></td>
                                <td><?php echo $dados['encarregado']; ?></td>
                                <td><?php echo $dados['frente_servico']; ?></td>
                                <td><?php echo date('d/m/Y H:i:s', strtotime($dados['horario'])); ?></td>
                            </tr>                         

                            <?php $cont++; endwhile; ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </section>
    </section>

    <!-- JavaScript -->
    <script src="../js/js-bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/js-bootstrap/bootstrap.min.js"></script>
    <!-- Script biblioteca jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.9/jspdf.plugin.autotable.min.js"></script>
    <script>
        function gerarPDF() {
        var doc = new jsPDF();
        doc.autoTable({
            html: '#table',
            theme: 'grid',
            styles: { fontSize: 8, textColor: [0, 0, 0] }
        });
        doc.save('nao-devolvidos.pdf');
    }
    </script>
</body>
</html>