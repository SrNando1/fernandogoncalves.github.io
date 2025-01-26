<?php
$host = "localhost";
$user = "root"; // ou "aluno"
$password = ""; // senha definida ou configurada
$database = "mercearia"; // ou outro banco desejado

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "";
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>