<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Reserva</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>Confirmação de Reserva</h1>
    </header>
    <div class="container">
        <?php 
            session_start();
            include("conexao.php");
        
            $nomeProfessor = isset($_SESSION['nome_professor']) ? $_SESSION['nome_professor'] : 'Nome do professor não disponível';
        
            if (isset($_POST['horarios']) && isset($_POST['laboratorio']) && isset($_POST['data'])) {
                $laboratorio = $_POST['laboratorio'];
                $data = $_POST['data'];
                
                $consulta = $conexao->prepare("INSERT INTO reserva (horario, laboratorio, dia, periodo, professor) VALUES (?, ?, ?, ?, ?)");
                if ($consulta === false) {
                    echo "Erro ao preparar a declaração: " . $conexao->error;
                } else {
                    foreach ($_POST['horarios'] as $horario) {
                        list($periodo, $horario_id) = explode('_', $horario);
        
                        $consulta->bind_param("sssss", $horario, $laboratorio, $data, $periodo, $nomeProfessor);
                        if ($consulta->execute()) {
                            echo "Reserva feita com sucesso! <br>";
                        } else {
                            echo "Erro ao reservar o horário para $periodo: " . $consulta->error . "<br>";
                        }
                    }
                    $consulta->close();
                }
            } else {
                echo "Nenhum horário selecionado.";
            }
        
            $conexao->close();
        ?>
        <p>Reserva confirmada para o laboratório <?php echo htmlspecialchars($_POST['laboratorio']); ?> no dia <?php echo htmlspecialchars($_POST['data']); ?>.</p>
        <p>Professor: <?php echo htmlspecialchars($nomeProfessor); ?></p>
        <article>
            <br><a id="verdisponibilidade" href="logicatelaReservas1.php">Voltar</a><br>
        </article> 
    </div>  
</body>
</html>
