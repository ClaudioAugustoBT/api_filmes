<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
</head>

<body>
  <h1>Cadastrar filme</h1>
  <form method="POST" action="../api/index.php">
    Titulo: <input type="text" name="titulo" id="titulo" required="required"><br><br>
    Categoria: <input type="text" name="categoria" id="categoria" required="required"><br><br>
    Duração (em minutos): <input type="number" min="1" step="1" name="duracao" id="duracao" required="required"><br><br>
    <input type="submit" value="CADASTAR">
  </form>
  <br>
  <br>
  <h3>Lista de Filmes</h3>
  <table border="1">
    <thead>
      <tr>
        <th>Titulo</th>
        <th>Categoria</th>
        <th>Duração</th>
      </tr>
    </thead>
    <tbody>

      <?php
      $get = "http://localhost/api_filmes/api/index.php?all=0";
      $json = file_get_contents($get);
      $jsonDecode = json_decode($json, true);
      foreach ($jsonDecode as $filme) {
        $html = "<tr>";
        $html .= "<td>" . $filme["titulo"] . "</td>";
        $html .= "<td>" . $filme["categoria"] . "</td>";
        $html .= "<td>" . $filme["duracao"] . "</td>";
        $html .= "</tr>";
        echo $html;
      }
      ?>
    </tbody>
  </table>
</body>

</html>