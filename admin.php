<?php

include("conexao.php");

// Deleta as informações do banco de dados e da pagina admin.php

if(isset($_GET['deletar'])) {
    $id = intval($_GET['deletar']);
    $sql_query = $mysqli->query("SELECT * FROM produto WHERE id = '$id' ") or die($mysqli->error);
    $produto = $sql_query->fetch_assoc();

    if (unlink($produto['path'])){
     $deu_certo =  $mysqli->query("DELETE FROM produto WHERE id = '$id' ") or die($mysqli->error);

     if($deu_certo){
        header("Location: admin.php"); //Navegar entre páginas automáticamente; 
        echo "<p>Arquivo excluido com sucesso!</p>";
     }
  }
}


// Verificação da Imagem

if(isset($_FILES['arquivo'])){
    $arquivo = $_FILES['arquivo'];

    if($arquivo['error'])
    die("Falha ao enviar o arquivo");

    if($arquivo['size'] > 2097152)
    die("Arquivo muito grande!! Maximo: 2MB");

 // Upload da Imagem

 $pasta = "arquivos/";
 $nomeDoArquivo = $arquivo['name'];
 $novoNomeDoArquivo = uniqid();
 $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

 // Verifica se a imagem e JPG ou PNG

 if($extensao != "jpg" && $extensao != 'png')
   die("Tipo de arquivo não aceito! Verifique novamente");

  $path = $pasta . $novoNomeDoArquivo . "." . $extensao;

   $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

   if($deu_certo) { 
   
    if(isset($_POST['upload'])){
        $produto = $_POST['nomeproduto']; 
        $valor = $_POST['valorproduto'];
        $lote = $_POST['lote'];
        $estoque = $_POST['estoque'];

   $mysqli->query("INSERT INTO produto (nome, path, valor, produto, lote, estoque) VALUES('$nomeDoArquivo', '$path', '$valor', '$produto', '$lote', '$estoque')") or die($mysqli->error);
      echo "<p>O arquivo foi enviado com sucesso! </p>";
    } } else
        echo "<p>Falha ao enviar o arquivo</p>";
}
$sql_query = $mysqli->query("SELECT * FROM produto") or die($mysqli->error);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="shortcut icon" href="logo.png" type="imagem/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Administrador </title>
</head>
<body> <div class="es"><br></div>
    <nav id="menu-h">
        <ul>
            <li>
                <img src="logo.png" height="50px" width="50px">
                <a href="" style="color: white; font-weight: bolder; font-size: 16px;">
                    ADMINISTRADOR
                </a>
            </li>
            <li><a href="#">
            <?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: loginadmin.php");
    exit;
}
echo "<a href='index.php'><button1>ENCERRAR SESSÃO</button1></a>";
?>

                 </a>
                </li>
        </ul>
        <div class="barra1"> </div>
    </nav>
   
<div class="espacamento">

<!-- CAMERA PARA TIRAR FOTOS E FAZER DOWNLOAD -->

<br>
<div class="#">
    <h5>- Você pode tirar a foto e carregar ou baixar</h5>
    <h5>- Lembre-se de ativar a permissão da câmera no seu navegador</h5>
    <h5>- Imagens acima de 2MB serão recusadas pelo sistema</h5>
    <h5>- Somente é aceito imagens de formato PNG ou JPG</h5>
    <h5>- Se apertar no botão tirar foto 2x é feito outra foto</h5>

<video autoplay></video>
  <canvas></canvas>
  <button>Tirar foto</button>
  <script src="./script.js"></script>
  </div>
 <br><br>

 <!--TERMINO DO VIDEO -->
<form method="POST" enctype="multipart/form-data" action="#">
<p>
    <br><br>
    <label for="">Selecione o Arquivo:</label>
    <input name="arquivo" type="file">
</p>

<br>

<!-- AQUI DEVE SER DIGITADO O NOME DO PRODUTO E O SEU VALOR RESPECTIVO -->

   <div class="barras">
     <p>Nome do Produto:
       <input type="text" name="nomeproduto"/>
       </p>
     <p>Valor do Produto: 
       <input type="text" name="valorproduto"/>
       </p>
       <p>Lote: 
       <input type="number" name="lote"/>
       </p>
       <p>Estoque: 
       <input type="number" name="estoque"/>
       </p>
   </div>
   <button name="upload" type="submit">Enviar</button>
</form>

<br><br>
<h4>CLASSIFICAÇÃO DE ESTOQUE</h4>
<div id="bloco1" style="height: 24px; width: 300px; font-weight: bolder; color: black; background-color: #00FF00;"> Reposição disponível</div>
<div id="bloco2" style="height: 24px; width: 300px; font-weight: bolder; color: black; background-color: yellow;"> Poucos em estoque</div>
<div id="bloco3" style="height: 24px; width: 300px; font-weight: bolder; color: black; background-color: orange;"> Compra necessária</div>
<div id="bloco4" style="height: 24px; width: 300px; font-weight: bolder; color: black; background-color: red;"> Esgotado</div>


<br><br>
<form method="GET" action="admin.php">
    <label for="search">Pesquisar por ID:</label>
    <input type="text" id="search" name="search_id" placeholder="Digite o ID">
    <button type="submit" value="Pesquisar">Buscar</button>
</form>
<br><br>

<?php

if(isset($_GET['search_id'])){
    $search_id = $_GET['search_id'];

    // Consulta dos arquivos que correspondem ao ID pesquisado
    $sql_query = $mysqli->query("SELECT * FROM produto WHERE id = '$search_id'") or die($mysqli->error);
    ?>

<h3>BUSCA POR ID</h3>
    <table class="minha-tabela">
        <thead>
            <th>Codigo</th>
            <th>Previa</th>
            <th>Arquivo</th>
            <th>Nome do Produto</th>
            <th>Lote</th>
            <th>Estoque</th> 
            <th>Valor</th>
            <th>Data e Hora</th>
            <th></th>
        </thead>
        <tbody>
        <?php
        while($sla = mysqli_fetch_array($sql_query)){
        ?>
            <tr>
                <td><?php echo $sla[0];?></td>
                <td><img height="50" src="<?php echo $sla[2]; ?>" alt=""></td>
                <td><a target="blenk" href="<?php echo $sla[2]; ?>"><?php echo $sla[1]; ?></a></td>
                <td><?php echo $sla[5];?></td>
                <td><?php echo $sla[6];?></td>
                <td style="background-color:
    <?php
    if ($sla[7] == 0){
        echo 'red';
    }
    elseif ($sla[7] <= 50){
        echo 'orange';
    } elseif ($sla[7] >= 51 && $sla[7] <= 100) {
        echo 'yellow';
    } elseif ($sla[7] >= 101) {
        echo '#00FF00';
    }
    ?>;
">
    <?php echo $sla[7]; ?>
</td>
                <td>R$: <?php echo $sla[4];?></td>
                <td><?php echo date("d/m/Y H:i", strtotime($sla[3])); ?></td>
                <td>
                    <button><a href="editar.php?edit=<?php echo $sla[0]; ?>">EDITAR</a></button>
                    <button><a href="admin.php?deletar=<?php echo $sla[0]; ?>">EXCLUIR</a></button>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}
?>

<br><br><br> 
<h2>PAINEL DE CONTROLE</h2>

<!-- TABELA COM PAINEL -->

<table class="minha-tabela">
    <thead>
        <th>Codigo</th>
        <th>Previa</th>
        <th>Arquivo</th>
        <th>Nome do Produto</th>
        <th>Lote</th>
        <th>Estoque</th> 
        <th>Valor</th>
        <th>Data e Hora</th>
        <th></th>
    </thead>
    <tbody>
    <?php
       $query = 'SELECT * FROM produto';
       $produto = mysqli_query($con,$query);
    while($sla = mysqli_fetch_array($produto)){

?>
    <tr>
    <td><?php echo $sla[0];?></td>
        <td><img height="50" src="<?php echo $sla[2]; ?>" alt=""></td>
        <td><a target="blenk" href="<?php echo $sla[2]; ?>"> <?php echo $sla[1]; ?> </td>

<!-- PRODUTO E VALOR -->
        <td><?php echo $sla[5];?></td>
        <td><?php echo $sla[6];?></td>
        <td style="background-color:
    <?php
    if ($sla[7] == 0){
        echo 'red';
    }
    elseif ($sla[7] <= 50){
        echo 'orange';
    } elseif ($sla[7] >= 51 && $sla[7] <= 100) {
        echo 'yellow';
    } elseif ($sla[7] >= 101) {
        echo '#00FF00';
    }
    ?>;
">
    <?php echo $sla[7]; ?>
</td>
        <td>R$: <?php echo $sla[4];?></td>
        <td><?php echo date("d/m/Y H:i", strtotime($sla[3])); ?></td>

           <td>
            <button><a href="editar.php?edit=<?php echo $sla[0]; ?>">EDITAR</a></button>
            <button><a href="admin.php?deletar=<?php echo $sla[0]; ?>">EXCLUIR</a></button>
            </td>
    </tr>
    <?php
}
?>
    </tbody>
</table>

</div>
<?php 
    if(isset($_POST['upload'])){
        $produto = $_POST['nomeproduto'];
        $query = "INSERT INTO produto(nome, path, valor, produto, lote, estoque) VALUES '','',0,'$produto'";
      
    }
?>

<br><br><br>


</body>
</html>





