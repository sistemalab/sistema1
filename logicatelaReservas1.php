<?php
session_start(); // Inicie a sessão no início do arquivo
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservar Laboratório</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <header>
        <h1>Reservar Laboratório</h1>
    </header>
    
    <div id="professor-box">
        Professor: 
        <?php
        if (isset($_SESSION['nome_professor'])) {
            echo htmlspecialchars($_SESSION['nome_professor']); 
        } else {
            echo "Nome do professor não disponível";
        }
        ?>
    </div>
    <div class="container">
        <form method="post" action="logicatelaReservas2.php">
            <table>
                <tr>
                    <th>Laboratório</th>
                    <th>Data</th>
                </tr>
                <tr>
                    <td>
                        <select name="laboratorio" required>
                            <?php
                            include("conexao.php");
                            $sqlresult = "SELECT numero_laboratorio FROM laboratorio";
                            $query = mysqli_query($conexao, $sqlresult);

                            if ($query) {
                                while ($retorno = mysqli_fetch_assoc($query)) {
                                    echo "<option value='" . htmlspecialchars($retorno['numero_laboratorio']) . "'>Laboratório " . htmlspecialchars($retorno['numero_laboratorio']) . "</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhum laboratório disponível</option>";
                            }

                            mysqli_close($conexao);
                            ?>
                        </select>
                    </td>
                    <td>
                        <input type="date" name="data" required>
                    </td>
                </tr>
            </table>
            <div class="bt">
                <button id="verdisponibilidade" type="submit">Ver Disponibilidade</button>
            </div>
        </form>
    </div>
</body>
</html>
