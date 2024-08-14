<?php
session_start(); // Inicia a sessão
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
        Professor: <?php echo htmlspecialchars($_SESSION['nome_professor']); ?>
    </div>

    <div class="container">
        <form method="post" action="logicatelaReservas3.php">
        <input type="text" value="Laboratório Selecionado:<?php echo htmlspecialchars($_POST['laboratorio']); ?>" readonly><br>
        <br>
        <input type="date" value="<?php echo htmlspecialchars($_POST['data']); ?>" readonly>
        <div>
            <br>
        </div>
        <table id="linha">
            <tr>
                <th>Manhã</th>
                <th>Tarde</th>
                <th>Noite</th>
            </tr>
            <?php
            include("conexao.php");
            if(isset($_POST['data']) && isset($_POST['laboratorio'])){
                $data = $_POST['data'];
                $laboratorio = $_POST['laboratorio'];

                $sqlresult = "SELECT horario, professor FROM reserva WHERE dia = '$data' AND laboratorio = '$laboratorio'";
                $query = mysqli_query($conexao, $sqlresult);
                
                $horariosMarcados = array();
                if ($query) {
                    while ($retorno = mysqli_fetch_assoc($query)) {
                        // $horariosMarcados['horario'] = $retorno['horario'];
                        // echo("Horario: ".$horariosMarcados['horario']);
                        // $horariosMarcados['professor'] = $retorno['professor'];
                        // echo("Professor: ".$horariosMarcados['professor']);
                        $linha = array();
                        $linha['horario'] = $retorno['horario'];
                        $linha['professor'] = $retorno['professor'];
                        $horariosMarcados[] = $linha;
                    }
                }
                $profAtual = $_SESSION['nome_professor'];
                
                function marcado($horario, $horariosMarcados, $profAtual) {
                    foreach ($horariosMarcados as $hm) {
                        if ($hm['horario'] == $horario) {
                            if ($hm['professor'] == $profAtual) {
                                return 'checked';
                            } else {
                                return 'disabled';
                            }
                        }
                    }
                    return '';
                    
                    // return in_array($horario, $horariosMarcados) ? 'checked' : '';
                }

                function profMarcado($horario, $horariosMarcados) {
                    foreach ($horariosMarcados as $hm) {
                        if ($hm['horario'] == $horario) {
                            return 'Reservado: '.$hm['professor'];
                        }
                    }
                    return '';
                    // return in_array($horario, $horariosMarcados) ? 'Professor: '.$horariosMarcados['professor'] : '';
                }

                echo("
                <table>
                    <tr>
                        <td>07:10 - 08:00 <input type='checkbox' name='horarios[]' value='manha_1' ".marcado('manha_1', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_1', $horariosMarcados)."</br></td>
                        <td>14:25 - 15:15 <input type='checkbox' name='horarios[]' value='tarde_1' ".marcado('tarde_1', $horariosMarcados, $profAtual)."><br>".profMarcado('tarde_1', $horariosMarcados)."</br></td>
                        <td>19:00 - 20:00 <input type='checkbox' name='horarios[]' value='noite_1' ".marcado('noite_1', $horariosMarcados, $profAtual)."><br>".profMarcado('noite_1', $horariosMarcados)."</br></td>
                    </tr>
                    <tr>
                        <td>08:00 - 08:50 <input type='checkbox' name='horarios[]' value='manha_2' ".marcado('manha_2', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_2', $horariosMarcados)."</br></td>
                        <td>15:15 - 16:05 <input type='checkbox' name='horarios[]' value='tarde_2' ".marcado('tarde_2', $horariosMarcados, $profAtual)."><br>".profMarcado('tarde_2', $horariosMarcados)."</br></td>
                        <td>20:15 - 21:15 <input type='checkbox' name='horarios[]' value='noite_2' ".marcado('noite_2', $horariosMarcados, $profAtual)."><br>".profMarcado('noite_2', $horariosMarcados)."</br></td>
                    </tr>
                    <tr>
                        <td>08:50 - 09:40 <input type='checkbox' name='horarios[]' value='manha_3' ".marcado('manha_3', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_3', $horariosMarcados)."</br></td>
                        <td>16:20 - 17:10 <input type='checkbox' name='horarios[]' value='tarde_3' ".marcado('tarde_3', $horariosMarcados, $profAtual)."><br>".profMarcado('tarde_3', $horariosMarcados)."</br></td>
                        <td>21:15 - 22:15 <input type='checkbox' name='horarios[]' value='noite_3' ".marcado('noite_3', $horariosMarcados, $profAtual)."><br>".profMarcado('noite_3', $horariosMarcados)."</br></td>
                    </tr>
                    <tr>
                        <td>10:00 - 10:50 <input type='checkbox' name='horarios[]' value='manha_4' ".marcado('manha_4', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_4', $horariosMarcados)."</br></td>
                        <td>17:10 - 18:00 <input type='checkbox' name='horarios[]' value='tarde_4' ".marcado('tarde_4', $horariosMarcados, $profAtual)."><br>".profMarcado('tarde_4', $horariosMarcados)."</br></td>
                        <td>22:15 - 23:15 <input type='checkbox' name='horarios[]' value='noite_4' ".marcado('noite_4', $horariosMarcados, $profAtual)."><br>".profMarcado('noite_4', $horariosMarcados)."</br></td>
                    </tr>
                    <tr>
                        <td>10:50 - 11:40 <input type='checkbox' name='horarios[]' value='manha_5' ".marcado('manha_5', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_5', $horariosMarcados)."</br></td>
                    </tr>
                    <tr>
                        <td>11:40 - 12:30 <input type='checkbox' name='horarios[]' value='manha_6' ".marcado('manha_6', $horariosMarcados, $profAtual)."><br>".profMarcado('manha_6', $horariosMarcados)."</br></td>
                    </tr>
                </table>
                ");
            }
            ?>
        </table>
        <div>
            <input type="hidden" name="laboratorio" value="<?= htmlspecialchars($laboratorio) ?>">
            <input type="hidden" name="data" value="<?= htmlspecialchars($data) ?>">
            <button id="reservar" type="submit">Reservar</button>
        </div>
        </form>
    </div>
</body>
</html>
