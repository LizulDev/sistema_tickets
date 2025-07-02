<?php include 'conexaobd.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Venda de Tickets</title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <h1>Eventos Disponíveis</h1>
  <table>
    <tr>
      <th>Nome</th>
      <th>Data</th>
      <th>Status</th>
      <th>Ação</th>
    </tr>

    <?php
    $sql = "SELECT e.id, e.nome, e.data_evento, s.descricao FROM eventos e
            JOIN status_evento s ON e.status_evento_id = s.id";
    $stmt = $pdo->query($sql);

    foreach ($stmt as $row) {
        echo "<tr>
                <td>{$row['nome']}</td>
                <td>{$row['data_evento']}</td>
                <td>{$row['descricao']}</td>
                <td><a href='comprar.php?evento_id={$row['id']}'>Comprar</a></td>
              </tr>";
    }
    ?>
  </table>
</body>
</html>
