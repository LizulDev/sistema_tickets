<?php
require_once 'conexaobd.php';

$tipo_usuario = $_POST['tipo_usuario'];
$cpf = $_POST['cpf'];

// Verifica usuário
$sql = "SELECT * FROM usuarios WHERE tipo_usuario = :tipo_usuario AND cpf = :cpf";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':tipo_usuario', $tipo_usuario);
$stmt->bindParam(':cpf', $cpf);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: index.php");
    exit;
} else {
    echo "<p>CPF ou tipo de usuário incorretos.</p><a href='index.html'>Voltar</a>";
    exit;
}
?>
