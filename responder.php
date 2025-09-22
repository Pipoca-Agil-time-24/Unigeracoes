<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$topico_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resposta = $_POST["resposta"];
    $autor_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO respostas (topico_id, resposta, autor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $topico_id, $resposta, $autor_id);
    $stmt->execute();
}

$topico_sql = "SELECT * FROM topicos WHERE id = $topico_id";
$respostas_sql = "SELECT r.*, u.nome FROM respostas r JOIN usuarios u ON r.autor_id = u.id WHERE topico_id = $topico_id ORDER BY data_resposta";

$topico = $conn->query($topico_sql)->fetch_assoc();
$respostas = $conn->query($respostas_sql);
?>

<h2><?= $topico['titulo'] ?></h2>
<p><?= $topico['conteudo'] ?></p>

<h3>Respostas</h3>
<ul>
<?php while ($res = $respostas->fetch_assoc()) { ?>
    <li><strong><?= $res['nome'] ?>:</strong> <?= $res['resposta'] ?> (<?= $res['data_resposta'] ?>)</li>
<?php } ?>
</ul>

<form method="POST">
    <textarea name="resposta" required></textarea><br>
    <button type="submit">Responder</button>
</form>
