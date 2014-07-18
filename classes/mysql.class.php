<?php
// Classe permettant de faire des requêtes MySQL en échappant les caractères spéciaux

class Mysql {
  /**
   * Requête SQL échappant les caractères spéciaux
   * @param string $requete
   * @param string $param1
   * @param string $param2
   * ...
   * @return boolean
   */
  static function query() {
    $params = func_get_args();
    $requete = array_shift($params);
    if ((count($params) > 0) && $params[0]) {
      if (is_array($params[0])) { // si on a passé un tableau contenant les paramètres au lieu d'une liste de paramètres
        $params = $params[0];
      }
      $params_echappes = array_map('mysql_escape_string', $params);
      $requete_echappee = vsprintf($requete, $params_echappes);
    }
    else {
      $requete_echappee = $requete;
    }
//    file_put_contents('logs/requete.txt', $requete_echappee);
    $result = mysql_query($requete_echappee) or die ("MySQL error " . mysql_errno() . ": " . mysql_error() . "\n");
    return $result;
  }
  
  /**
   * Exécute une requête SQL et renvoie un objet
   * @param string $requete
   * @param string $param1
   * @param string $param2
   * ...
   * @return object
   */
  static function get_object() {
    $params = func_get_args();
    $requete = array_shift($params);
    $query = Mysql::query($requete, $params);
    return mysql_fetch_object($query);
  }
  
  /**
   * Renvoie un objet depuis sa table et son id
   * @param string $table
   * @param int $id
   * @return object
   */
  static function get_object_from_id($table, $id) {
    return Mysql::get_object("SELECT * FROM `%s` WHERE id = '%d'", $table, $id);
  }
  
  /**
   * Exécute une requête SQL et renvoie une liste d'objets
   * @param string $requete
   * @param string $param1
   * @param string $param2
   * ...
   * @return object[]
   */
  static function get_list() {
    $params = func_get_args();
    $requete = array_shift($params);
    $query = Mysql::query($requete, $params);
    $list = array();
    while ($row = mysql_fetch_object($query)) {
      $list[] = $row;
    }
    return $list;
  }
  
  /**
   * Exécute une requête SQL et renvoie le nombre d'enregistrement retournées par une requête
   * @param string $requete
   * @param string $param1
   * @param string $param2
   * ...
   * @return object[]
   */
  static function get_nombre_lignes() {
    $params = func_get_args();
    $requete = array_shift($params);
    $query = Mysql::query($requete, $params);
    return mysql_num_rows($query);   
  }
  
  /**
   * Ajoute un enregistrement dans une table SQL
   * @param string $table
   * @param array $dict
   * @return int
   */
  static function insert($table, $dict) {
    $valeurs_echappees = array_map('mysql_escape_string', array_values($dict));
    $liste_cles = '`' . implode("`, `", array_keys($dict)) . '`';
    $liste_valeurs = "'" . implode("', '", $valeurs_echappees) . "'";
    $requete = "INSERT INTO `$table` ($liste_cles) VALUES($liste_valeurs)";
    $requete = str_replace("'NOW()'", "NOW()", $requete); // on accepte la fonction NOW()
	
    Mysql::query($requete);
    return mysql_insert_id();
  }
  
  /**
   * Remplace un enregistrement dans une table SQL
   * @param string $table
   * @param array $dict
   * @return boolean
   */
   static function replace($table, $dict) {
    $valeurs_echappees = array_map('mysql_escape_string', array_values($dict));
    $liste_cles = '`' . implode("`, `", array_keys($dict)) . '`';
    $liste_valeurs = "'" . implode("', '", $valeurs_echappees) . "'";
    $requete = "REPLACE INTO `$table` ($liste_cles) VALUES($liste_valeurs)";
    return Mysql::query($requete);
  }
  
  /**
   * Modifie un enregistrement dans une table SQL
   * @param string $table
   * @param array $dict
   * @param string $where
   * @return boolean
   */
  static function update() {
    $params = func_get_args();
    $table = array_shift($params);
    $dict = array_shift($params);
    $where = (count($params) > 0)? array_shift($params) : '';
    
    if (count($dict) == 0) return false;
    
    $requete = "UPDATE `$table` SET `" . implode("` = '%s', `", array_keys($dict)) . "` = '%s' " . $where;
    $params = array_merge(array_values($dict), $params);
    return Mysql::query($requete, $params);
  }
  
  /**
   * Supprime un enregistrement d'après son id
   * @param string $table
   * @param int $id
   * @return boolean
   */
  function delete($table, $id) {
    return Mysql::query("
      DELETE FROM `%s`
      WHERE id = '%d'
      LIMIT 1
    ", $table, $id);
  }
}


?>
