<?php include 'conexaobd.php';

$evento_id = $_GET['evento_id'] ?? 1;
$usuario_id = 2; // Simulação (cliente fixo para exemplo)

// Checar limite de tickets
$stmt = $pdo->prepare("SELECT COUNT(*) FROM tickets WHERE usuario_id = ? AND evento_id = ?");
$stmt->execute([$usuario_id, $evento_id]);
$qtd = $stmt->fetchColumn();

if ($qtd >= 3) {
    echo "<p>Você já comprou o limite de 3 tickets para este evento.</p><a href='index.php'>Voltar</a>";
    exit;
}

// Encontrar um lote
$lote_stmt = $pdo->prepare("SELECT id FROM lotes WHERE eventos_id = ? LIMIT 1");
$lote_stmt->execute([$evento_id]);
$lote = $lote_stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $tipo = $_POST['tipo_pagamento'];
    $meia = isset($_POST['meia']) ? 1 : 0;
    $valor = $_POST['valor_evento'] ?? 100;

    $pdo->exec("CALL comprar_tickets($usuario_id, $evento_id, {$lote['id']}, $meia, NOW(), '$tipo', $valor)");
    echo "<p>Compra realizada com sucesso!</p><a href='index.php'>Voltar</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Comprar Ticket</title>
</head>
<body>
  <h1>Comprar Ticket</h1>
  <form method="post">
    <label>Tipo de pagamento:
      <select name="tipo_pagamento">
        <option value="PIX">PIX</option>
        <option value="Crédito">Crédito</option>
        <option value="Débito">Débito</option>
      </select>
    </label><br><br>
    <label><input type="checkbox" name="meia"> Meia Entrada</label><br><br>
    <label>Valor: <input type="number" step="0.10" name="valor_evento" value="100.00" required></label><br><br>
    <button type="submit">Confirmar Compra</button>
  </form>
</body>
</html>
