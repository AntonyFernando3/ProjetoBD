<?php
include("conexao.php");

if(isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $produto = $_POST['nomeproduto'];
    $valor = $_POST['valorproduto'];
    $lote = $_POST['lote'];
    $estoque = $_POST['estoque'];
    $data_upload = $_POST['datahora'];

    $mysqli->query("UPDATE produto SET produto = '$produto', valor = '$valor', lote = '$lote', estoque = '$estoque', data_upload = NOW() WHERE id = '$id'") or die($mysqli->error);

    header("Location: http://localhost/upload/admin.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="logo.png" type="imagem/x-icon">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Aba de Edição </title>
</head>
<body> 
<nav id="menu-h">
        <ul>
            <li>
                <img src="logo.png" height="50px" width="50px">
                <a href="" style="color: white; font-weight: bolder; font-size: 16px;">EDITOR DE PRODUTOS</a>
            </li>
            <li><a href="#">
                 </a>
            </li>
        </ul>
        <div class="barra1"> </div>
    </nav>

<div class="espacamento">

            </html>
        </body>

<tbody>
<?php
$query = 'SELECT * FROM produto';
$produto = mysqli_query($con, $query);
while ($sla = mysqli_fetch_array($produto)) {
    ?>
    <tr>
        <td>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $sla[0]) { ?>
                <br><br>
                  <span class="foto">
                <img height="100" src="<?php echo $sla[2]; ?>" alt="">
                </span>
            <?php } else { ?>
                <a target="_blank" href="<?php echo $sla[2]; ?>"></a>
            <?php } ?>
        </td>
        <td>
            <?php if (isset($_GET['edit']) && $_GET['edit'] == $sla[0]) { ?>
                <form method="POST" action="editar.php"><br><br>
                    <input type="hidden" name="id" value="<?php echo $sla[0]; ?>">
                 <td><span class="palavra">Produto:</span> <input type="text" name="nomeproduto" value="<?php echo $sla[5]; ?>"></td> <br><br>
                 <td><span class="palavra">Valor:</span> <input type="text" name="valorproduto" value="<?php echo $sla[4]; ?>"> </td> <br><br>
                 <td><span class="palavra">Lote:</span> <input type="text" name="lote" value="<?php echo $sla[6]; ?>"> </td> <br><br>
                 <td><span class="palavra">Estoque: </span> <input type="number" name="estoque" value="<?php echo $sla[7]; ?>"> </td> <br><br>
                 <td>Data e Hora: <?php echo $sla[3]; ?></td><br><br>
                 <h5>- Data e Hora atualiza automaticamente após salvar</h5>
                         <td></td>
                 <br><br>
                    <button type="submit">SALVAR</button>
                    <button><a href="admin.php">CANCELAR</a></button>
                    <button><a href="admin.php?deletar=<?php echo $sla[0]; ?>">EXCLUIR</a></button>
                    <br><br><br>
                </form>
            <?php } else { ?>
            <?php } ?>
        </td>
    </tr>
    <?php
}
?>
</tbody>