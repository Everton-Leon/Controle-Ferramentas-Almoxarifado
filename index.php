<?php
// Importação da conexão
require_once "php/db_connect.php";
// Iniciando sessão
session_start();
// Verificação do botão de enviar
if (isset($_POST['btn-entrar'])):
    $erros = array();
    $login = limparInput($_POST['login']);
    $senha = limparInput($_POST['senha']);

    $sql = "SELECT login FROM usuarios WHERE login = '$login'";
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) > 0):
        $senha = md5($senha);

        $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
        $resultado = mysqli_query($connect, $sql);

        if (mysqli_num_rows($resultado) == 1):
            $dados = mysqli_fetch_array($resultado);
            $_SESSION['logado'] = true;
            $_SESSION['id_usuario'] = $dados['id'];
            header('Location: paginas/home.php');
        else:
            $erros[] = "Usuário ou senha incorretos.";
        endif;
    else:
        $erros[] = "Usuário inexistente.";
    endif;
endif;
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almoxerifado - Login</title>  
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="css/css-bootstrap/bootstrap.min.css">
    <!-- CSS -->
    <link rel="stylesheet" href="css/tela-login.css">
</head>
<body>
    <!-- Cabeçalho -->
    <header class="container-fluid border" id="faixa-header">
        <section class="row border p-4">
            <div class="col-md-8 col-12 p-2">
                <img class="img-fluid w-25 p-1" src="img/logo-direcional.png" alt="Logo-Direcional">
            </div>
        </section>
    </header>
    <!-- Área Pincipal / Tela de Login -->
    <main class="container justify-content-center h-75">
        <section class="row h-100 align-items-center my-4">
            <div class="col-12 h-100 ">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="m-auto border h-100 p-5">
                    <h2 class="text-center h2 my-3">Login</h2>
                    <small class="text-muted text-center d-block">Seja bem vindo ao sistema de gerenciamento de ferramentas da Direcional! Faça login para continuar.</small>
                    <div class="form-group align-items-center mt-4">
                      <label for="iusuario">Usuário</label>
                      <input type="text" class="form-control" name="login" id="iusuario" placeholder="Usuário" required minlength="3">
                    </div>
                    <div class="form-group my-3">
                      <label for="isenha">Senha</label>
                      <input type="password" class="form-control" name="senha" id="isenha" placeholder="Senha" required minlength="5" maxlength="32">
                      <!-- Mostrando erros se existirem -->
                      <?php 
                        if(!empty($erros)):
                            foreach($erros as $erro):
                        ?>
                        <small class="text-center d-block text-danger mt-2"><?php echo $erro; ?></small>
                        <?php 
                            endforeach;
                        endif;
                        unset($erros);
                        ?>
                    </div>
                    <div class="w-100 text-center mt-3"><button type="submit" name="btn-entrar" class="btn btn-primary w-75">Entrar</button></div>
                  </form>
            </div>
        </section>
    </main>
    
    <!-- JavaScript -->
    <script src="js/js-bootstrap/bootstrap.bundle.min.js"></script>
    <script src="js/js-bootstrap/bootstrap.min.js"></script>
</body>
</html>