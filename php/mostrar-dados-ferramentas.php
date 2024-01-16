<?php
// Importação da conexão
require_once "db_connect.php";
// Iniciando sessão
session_start();

// recebe os valores da requisição GET
$cod = filter_input(INPUT_GET, 'codFerramenta', FILTER_SANITIZE_SPECIAL_CHARS); 

// faz o select 
$sql = "SELECT * FROM ferramentas WHERE codigo = '$cod'";
$resultado = mysqli_query($connect, $sql);

// verifica se há um codigo cadastrado e mostra os dados
if ($cod && mysqli_num_rows($resultado) == 1):
    $dados = mysqli_fetch_array($resultado);
    echo "".$dados['ferramenta']."|"."../img/imagem-ferramentas/".$dados['imagem_ferramenta']."|".$dados['status'];
else:
    echo "Ferramenta não cadastrada no sistema";
endif;
?>