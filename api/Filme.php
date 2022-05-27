<?php

//============================================================+
//ENDPOINTS - Consultar / Cadastrar de Filmes
//============================================================+

class Filme
{

    /*
    ** Consulta / Retorna todos filmes cadastrados
    */
    public function getTodosFilmes()
    {
        try {
            $conexao = new PDO(
                'mysql:host=' . DB_SERVER .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                DB_USERNAME,
                DB_PASSWORD
            );

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conexao->prepare('SELECT * from tb_filme');
            $query->execute();

            $result = $query->fetchAll();

            $conexao = null;
            return $result;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    /*
    ** Consulta / Retorna um filme pelo ID
    */
    public function getFilmePorId($id)
    {
        if (!is_int($id)) {
            throw new Exception('Código de identificação inválido!');
            exit;
        }

        try {
            $conexao = new PDO(
                'mysql:host=' . DB_SERVER .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                DB_USERNAME,
                DB_PASSWORD
            );

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conexao->prepare('SELECT * from tb_filme WHERE id = :id');
            $query->bindParam(':id', $id);
            $query->execute();

            $result = $query->fetch(PDO::FETCH_ASSOC);

            $conexao = null;

            if (!$result) {
                throw new Exception('Filme não encontrado');
            }

            return $result;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    /*
    ** Procura filmes cadastrados por id, titulo ou categoria
    */
    public function buscarFilme($filmeInfo)
    {
        $todosFilmes = $this->getTodosFilmes();
        $result = array();

        $buscaPorId = intval($filmeInfo) > 0 ? intval($filmeInfo) : false;
        if ($buscaPorId) {
            $response = $this->getFilmePorId($buscaPorId);
            $result = array("matchID" => $response);
        } else {

            $busca = $this->prepara_string_para_busca($filmeInfo);

            //$result = array_merge(array("matchTitulo" => []), array("matchCategoria" => []));

            $arr_index = 0;

            foreach ($todosFilmes as $filme) {

                $titulo = $this->prepara_string_para_busca($filme["titulo"]);
                $categoria = $this->prepara_string_para_busca($filme["categoria"]);

                if ($busca == $titulo) {
                    $result["matchTitulo"][$arr_index] = $filme;
                    $arr_index++;
                } else if ($busca == $categoria) {
                    $result["matchCategoria"][$arr_index] = $filme;
                    $arr_index++;
                } else {
                    preg_match('/' . $busca . '/', $titulo, $matches);

                    if (count($matches) > 0) {
                        $result["matchTitulo"][$arr_index] = $filme;
                        $arr_index++;
                    } else {

                        preg_match('/' . $busca . '/', $categoria, $matches);

                        if (count($matches) > 0) {
                            $result["matchCategoria"][$arr_index] = $filme;
                            $arr_index++;
                        } else {
                            //$nenhum filme encontrado
                        }
                    }
                }
            }
        }

        if (!$result) {
            throw new Exception('Filme não encontrado');
        }

        return $result;
    }

    private function prepara_string_para_busca(STRING $string)
    {
        $string = strtolower($string);
        $string = preg_replace('/[@\.\;\" "]+/', '', $string);

        return $string;
    }

    /*
    ** Cadastra um filme
    */
    public function cadastrarFilme($titulo, $categoria, $duracao)
    {
        if (!is_int($duracao) || $duracao <= 0) {
            throw new Exception('Duração inválida!');
            exit;
        }

        try {
            $conexao = new PDO(
                'mysql:host=' . DB_SERVER .
                    ';dbname=' . DB_NAME .
                    ';charset=' . DB_CHARSET,
                DB_USERNAME,
                DB_PASSWORD
            );

            $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = $conexao->prepare('INSERT INTO tb_filme VALUES (null,:titulo,:categoria,:duracao)');
            $query->execute(array(
                ':titulo' => $titulo,
                ':categoria' => $categoria,
                ':duracao' => $duracao
            ));

            $conexao = null;
        } catch (PDOException $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
