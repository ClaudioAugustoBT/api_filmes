<?php

//============================================================+
//ENDPOINT - Consultar / Cadastrar de Filmes
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
