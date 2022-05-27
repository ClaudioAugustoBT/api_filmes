<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
</head>

<body>

    <h1>Consultar filme</h1>
    <form method="POST" action="../api/index.php">
        ID, Titulo ou Categoria do Filme: <input type="text" name="procura_filme" id="procura_filme" required="required"><br><br>
        <input type="submit" value="CONSULTAR">
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