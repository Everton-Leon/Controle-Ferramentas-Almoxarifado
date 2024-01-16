<?php 
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "direcional_ferramentas";

$connect = mysqli_connect($servername, $username, $password, $db_name);

if (mysqli_connect_error()):
    echo "Falha na conexão: ".mysqli_connect_error();
endif;

// Função para limpar o input 
function limparInput($input) {
    global $connect;
    // limpeza contra códigos SQL
    $var = mysqli_escape_string($connect, $input);
    // limpeza contra códigos JavaScript
    $var = htmlspecialchars($var);
    return $var;
}
?>