<?php

//============================================================+
//API para cadastro e consulta de filmes
//============================================================+

/*
** Configurações
*/
require_once(dirname(__FILE__) . '/config.php');

/*
** Class - Filme
*/
require_once(dirname(__FILE__) . '/Filme.php');
$filme = new Filme;

/*
**Consultar e Cadastar Filmes filmes Cadastrados
** ============================================================+
** Method:GET - Somente Consultar
** $_GET['all'] = '0' -> retorna array com todos filmes cadastrados
** $_GET['all'] = '1' -> Consulta filme por ID -> requisita $_GET['id']
** $_GET['id'] = Id do filme a ser consultado
** ============================================================+
** Method: POST - Consultar e cadastar
** $_POST['procura_filme'] -> retorna array filmes da procura
** $_POST['titulo'] -> titulo do filme a ser cadastrado
** $_POST['categoria'] -> categoria do filme a ser cadastrado
** $_POST['duracao'] -> duração em minutos do filme a ser cadastrado
** ============================================================+
*/
if ($_SERVER['REQUEST_METHOD'] == "GET") {

    if (isset($_GET['all'])) {
        if ($_GET['all'] == 0) {
            try {
                echo json_encode($filme->getTodosFilmes());
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else if ($_GET['all'] == 1) {
            try {
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
                echo json_encode($filme->getFilmePorId($id));
            } catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            die("Error: Parametros inválidos");
        }
    } else {
        die("Error: Faltam parametros!");
    }
} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if(isset($_POST['procura_filme'])){
        try {
            echo json_encode($filme->buscarFilme($_POST['procura_filme']));
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }else if (!isset($_POST['titulo']) || !isset($_POST['categoria']) || !isset($_POST['duracao'])) {
        die("Error: Faltam parametros!");
    } else {
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $duracao = intval($_POST['duracao']);
        try {
            $filme->cadastrarFilme($titulo, $categoria, $duracao);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
    }
} else {
    die("Metodo de requisição inválido!");
}
