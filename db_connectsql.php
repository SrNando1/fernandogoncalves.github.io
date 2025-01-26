<?php
$host = "localhost";
$user = "root"; // ou "aluno"
$password = ""; // senha definida ou configurada
$database = "mercearia"; // ou outro banco desejado

// Conectando com MySQL usando MySQLi
$conn = new mysqli($host, $user, $password, $database);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
} 
?>