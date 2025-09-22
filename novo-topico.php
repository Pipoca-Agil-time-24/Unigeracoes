<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];
    $autor_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO topicos (titulo, conteudo, autor_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $titulo, $conteudo, $autor_id);
    $stmt->execute();

    header("Location: forum.php");
    exit();
}
?>

<form method="POST">
    <h2>Novo Tópico</h2>
    Título: <input type="text" name="titulo" required><br>
    Conteúdo:<br>
    <textarea name="conteudo" required></textarea><br>
    <button type="submit">Postar</button>
</form>
