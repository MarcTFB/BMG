<?php
require_once ('PdoDao.class.php');
Class GenreDal{
public static function loadGenres($style){
  //instanciation d'un ojbet PdoDao
  $cnx = new PdoDao();
  $qry = 'SELECT * FROM genre';
  $tab = $cnx->getRows($qry, array(), $style);
  if ( is_a($tab,'PDOException')){
    return PDO_EXCEPTION_VALUE;
  }
  // dans le cas où on attend un tableau d'objets
  if ($style == 1){
    //retourner un tableau d'objets
    $res = array();
    foreach ($tab as $ligne){
      $unGenre = new Genre(
        $ligne->code_genre,
        $ligne->lib_genre
      );
      array_push($res, $unGenre);
    }
    return $res;
  }
    return $tab;
  }
  /**
     * ajoute un genre
     * @param   string  $code : le code du genre à ajouter
     * @param   string  $libelle : le libellé du genre à ajouter
     * @return  le code du Genre
     */
    public static function addGenre($code, $libelle) {
        $cnx = new PdoDao();
        $qry = 'INSERT INTO genre VALUES (?,?)';
        $res = $cnx->execSQL($qry, array(// nb de lignes affectées
            $code,
            $libelle
                )
        );
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        return $code;
    }
    /**
     * charge un objet de la classe Genre à partir de son code
     * @param  $id : le code du genre
     * @return  un objet de la classe Genre
     */
    public static function loadGenreByID($id) {
        $cnx = new PdoDao();
        // requête
        $qry = 'SELECT code_genre, lib_genre FROM genre WHERE code_genre = ?';
        $res = $cnx->getRows($qry, array($id), 1);
        if (is_a($res, 'PDOException')) {
            return PDO_EXCEPTION_VALUE;
        }
        if (!empty($res)) {
            // le genre existe
            $code = $res[0]->code_genre;
            $libelle = $res[0]->lib_genre;
            return new Genre($code, $libelle);
        } else {
            return NULL;
        }
    }

}

 ?>
