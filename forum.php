<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT t.id, t.titulo, t.data_criacao, u.nome AS autor FROM topicos t JOIN usuarios u ON t.autor_id = u.id ORDER BY t.data_criacao DESC";
$resultado = $conn->query($sql);
?>

<h2>Fórum</h2>
<a href="novo-topico.php">Criar novo tópico</a> | <a href="curriculo.html">Dicas de Currículo</a>

<ul>
<?php while ($topico = $resultado->fetch_assoc()) { ?>
    <li>
        <a href="responder.php?id=<?= $topico['id'] ?>"><?= $topico['titulo'] ?></a> - por <?= $topico['autor'] ?> (<?= $topico['data_criacao'] ?>)
    </li>
<?php } ?>
</ul>
