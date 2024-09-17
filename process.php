<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação dos campos
    $nome = !empty($_POST['nome']) ? $_POST['nome'] : null;
    $sobrenome = !empty($_POST['sobrenome']) ? $_POST['sobrenome'] : null;
    $data_nascimento = !empty($_POST['data_nascimento']) ? $_POST['data_nascimento'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $endereco = !empty($_POST['endereco']) ? $_POST['endereco'] : null;

    if ($nome && $sobrenome && $data_nascimento && $email && $endereco) {
        // Exibir mensagem formatada com os dados
        echo "<div class='container mt-5'>
                <h2>Dados Recebidos</h2>
                <p><strong>Nome:</strong> $nome</p>
                <p><strong>Sobrenome:</strong> $sobrenome</p>
                <p><strong>Data de Nascimento:</strong> $data_nascimento</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Endereço:</strong> $endereco</p>
              </div>";
    } else {
        echo "<div class='alert alert-danger'>Todos os campos são obrigatórios!</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Método de requisição inválido.</div>";
}
?>
