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
    <title>Almoxerifado - Efetivo</title>  
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
                    <a id="link-ativo" class="nav-link mb-2" href="#"><span>Efetivo</span></a>
                    <a class="nav-link mb-2" href="nao-devolvidos.php"><span>Não Devolvidos</span></a>
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
                    <h1 class="h1">Efetivo</h1>
                </div>
                <div class="col-4">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-cadastro">Cadastrar Efetivo</button>
                </div>
                <!-- Tabela -->
                </div>
                <div class="row my-3">
                <div class="col-12 table-responsive">
                    <table class="table table-sm table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Função</th>
                                <th>Encarregado</th>
                                <th>Seção</th>
                                <th>Situação</th>
                                <th>Frente de Serviço</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <!-- Puxando os dados do banco de dados e mostrando eles -->
                            <?php
                            $sql = "SELECT * FROM efetivo order by nome";
                            $resultado = mysqli_query($connect, $sql);
                            $cont = 1;
                            while ($dados = mysqli_fetch_array($resultado)):
                            ?>
                            <tr>
                                <td><?php echo $cont; ?></td>
                                <td><?php echo $dados['codigo']; ?></td>
                                <td><?php echo $dados['nome']; ?></td>
                                <td><?php echo $dados['funcao']; ?></td>
                                <td><?php echo $dados['encarregado']; ?></td>
                                <td><?php echo $dados['secao']; ?></td>
                                <td><?php echo $dados['situacao']; ?></td>
                                <td><?php echo $dados['frente_servico']; ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modal-update<?php echo $dados['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                        </svg>
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete<?php echo $dados['id']; ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de Update -->
                            <div class="modal fade" id="modal-update<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Atualizar Efetivo</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulário de Cadastro  -->
                                    <form action="../php/atualizar-efetivo.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                                            <label for="icodigo" class="form-label">Código</label>
                                            <input type="text" class="form-control" id="icodigo" name="codigo" placeholder="000000" required pattern="[0-9]+" minlength="6" maxlength="10" value="<?php echo $dados['codigo']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="inome" class="form-label">Nome</label>
                                            <input type="text" class="form-control" id="inome" name="nome" placeholder="João da Silva" required  minlength="1" value="<?php echo $dados['nome']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ifuncao" class="form-label">Função</label>
                                            <input type="text" class="form-control" id="ifuncao" name="funcao" placeholder="Pedreiro" required  minlength="1" value="<?php echo $dados['funcao']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="iencarregado" class="form-label">Encarregado</label>
                                            <input type="text" class="form-control" id="iencarregado" name="encarregado" placeholder="Edinho" required  minlength="1" value="<?php echo $dados['encarregado']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="isecao" class="form-label">Seção</label>
                                            <input type="text" class="form-control" id="isecao" name="secao" placeholder="OBRA 369CE - MÃO DE OBRA DIRETA" required  minlength="10" value="<?php echo $dados['secao']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="isituacao" class="form-label">Situação</label>
                                            <input type="text" class="form-control" id="isituacao" name="situacao" placeholder="Ativo" required  minlength="1" value="<?php echo $dados['situacao']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ifrente_servico" class="form-label">Frente de Seriço</label>
                                            <input type="text" class="form-control" id="ifrente_servico" name="frente_servico" placeholder="Almoxarife" required  minlength="1" value="<?php echo $dados['frente_servico']; ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label for="ifoto" class="form-label">Imagem da Efetivo</label>
                                            <input class="form-control" type="file" id="ifoto" name="foto">
                                            <input type="hidden" name="nome_imagem" value="<?php echo $dados['imagem_efetivo']; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="btn-atualizar-efetivo">Atualizar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- Fim do Modal de Update -->

                            <!-- Modal de Delete -->
                            <div class="modal fade" id="modal-delete<?php echo $dados['id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Deletar Efetivo</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Certeza que deseja excluir o efetivo <strong><?php echo $dados['nome']; ?></strong>?
                                    <!-- Formulário de Cadastro  -->
                                    <form action="../php/deletar-efetivo.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="btn-deletar-efetivo">Sim</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                            <!-- Fim do Modal de Delete -->

                            <?php $cont++; endwhile; ?>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </section>
    </section>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modal-cadastro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastro de Efetivo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <!-- Formulário de Cadastro  -->
            <form action="../php/cadastrar-efetivo.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="icodigo" class="form-label">Código</label>
                    <input type="text" class="form-control" id="icodigo" name="codigo" placeholder="000000" required pattern="[0-9]+" minlength="6" maxlength="10">
                </div>
                <div class="mb-3">
                    <label for="inome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="inome" name="nome" placeholder="João da Silva" required  minlength="1">
                </div>
                <div class="mb-3">
                    <label for="ifuncao" class="form-label">Função</label>
                    <input type="text" class="form-control" id="ifuncao" name="funcao" placeholder="Pedreiro" required  minlength="1">
                </div>
                <div class="mb-3">
                    <label for="iencarregado" class="form-label">Encarregado</label>
                    <input type="text" class="form-control" id="iencarregado" name="encarregado" placeholder="Edinho" required  minlength="1">
                </div>
                <div class="mb-3">
                    <label for="isecao" class="form-label">Seção</label>
                    <input type="text" class="form-control" id="isecao" name="secao" placeholder="OBRA 369CE - MÃO DE OBRA DIRETA" required  minlength="10">
                </div>
                <div class="mb-3">
                    <label for="isituacao" class="form-label">Situação</label>
                    <input type="text" class="form-control" id="isituacao" name="situacao" placeholder="Ativo" required  minlength="1">
                </div>
                <div class="mb-3">
                    <label for="ifrente_servico" class="form-label">Frente de Seriço</label>
                    <input type="text" class="form-control" id="ifrente_servico" name="frente_servico" placeholder="Almoxarife" required  minlength="1">
                </div>
                <div class="mb-3">
                    <label for="ifoto" class="form-label">Imagem Efetivo</label>
                    <input class="form-control" type="file" id="ifoto" name="foto">
                </div>
                <button type="submit" class="btn btn-primary" name="btn-cadastrar-efetivo">Cadastrar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <!-- JavaScript -->
    <script src="../js/js-bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/js-bootstrap/bootstrap.min.js"></script>
</body>
</html>