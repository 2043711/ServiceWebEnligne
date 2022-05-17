<?php

namespace App\Domain\Film\Repository;

use PDO;

/**
 * Repository.
 */
class FilmListorRepository
{
    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * Constructor.
     *
     * @param PDO $connection The database connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Insert film row.
     *
     * @param array $film The film
     *
     * @return int The new ID
     */
    public function listAllFilms()
    {
        $sql = "SELECT * FROM films ORDER BY nom";
        $sqlArgs = array();
        if(isset($_REQUEST['fields'])){
            $fields = explode(",",$_REQUEST['fields']);
            $sql = "SELECT ";
            foreach ($fields as $field){
                $sql.= $field;
                $sql .= " ,";
            }
            $sql = substr($sql, 0, -1);
            $sql .= "FROM films";
        }
        if(isset($_REQUEST['nom']) || isset($_REQUEST['duree']) || isset($_REQUEST['dateSortie'])){
            $sql .= " WHERE";
            if(isset($_REQUEST['nom'])){
                $noms = explode(',',$_REQUEST['nom']);
                $sql.= " nom IN (";

                foreach ($noms as $nom){
                    $sql.= "?,";
                    array_push($sqlArgs, $nom);
                }
                //Enleve le dernier OR
                $sql = substr($sql, 0, -1);
                $sql.= ") AND";
            }
            if(isset($_REQUEST['duree'])){
                $durees = explode(',',$_REQUEST['duree']);
                $sql.= " duree IN (";

                foreach ($durees as $duree){
                    $sql.= "?,";
                    array_push($sqlArgs, $duree);
                }
                //Enleve la derniere ,
                $sql = substr($sql, 0, -1);
                $sql.= ") AND";
            }
            if(isset($_REQUEST['dateSortie'])){
                $dateSorties = explode(',',$_REQUEST['dateSortie']);
                $sql.= " dateSortie IN (";

                foreach ($dateSorties as $dateSortie){
                    $sql.= "?,";
                    array_push($sqlArgs, $dateSortie);
                }
                //Enleve la derniere ,
                $sql = substr($sql, 0, -1);
                $sql.= ") AND";

            }
            //On retire le dernier AND
            $sql = substr($sql, 0, -4);

        }
        if(isset($_REQUEST['sort'])){
            if($_REQUEST['sort'] == "id"){
                $sql.= " ORDER BY  id";
            } else if ($_REQUEST['sort'] == 'dateSortie'){
                $sql.= " ORDER BY  dateSortie";
            } else if ($_REQUEST['sort'] == 'nom'){
                $sql.= " ORDER BY  nom";
            } else if ($_REQUEST['sort'] == 'duree'){
                $sql.= " ORDER BY  duree";
            }
        }

        if(isset($_REQUEST['limit'])){
            if( is_numeric( $_REQUEST['limit'] ) ){

                $sql.= " LIMIT ";

                if(isset($_REQUEST['offset'])){
                    if( is_numeric( $_REQUEST['offset'] ) ){
                        $sql.= $_REQUEST['offset'];
                        $sql.= ",";

                    }
                }

                $sql.= $_REQUEST['limit'];
            }
        } else if(isset($_REQUEST['page'])){
            if(is_numeric($_REQUEST['page'])){
                $sql .= " LIMIT ";
                $offset = ((intval($_REQUEST['page']) - 1) * 10);
                $sql .= $offset;
                $sql .= ",10";
            }
        }
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($sqlArgs);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * Insert film row.
     *
     * @param array $film The film
     *
     * @return int The new ID
     */
    public function listFilm(int $id)
    {
        $sql = "SELECT * FROM films WHERE id = ?";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute(array($id));
        $result = $stmt->fetchAll();
        return $result;
    }
}