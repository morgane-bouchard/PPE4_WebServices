<?php  if (!defined('BASEPATH'))   exit('No direct script access allowed');

class SitPro_Model extends CI_Model {
	private  $monPdo;
	private	 $cmdSelectByStudentId;
        private  $cmdSelectByRef;
	/**
	 * Initialise une instance de la classe SitPro_Model
	 * - Récupère les paramètres de configuration liés au serveur MySql
	 * - Initialise les références aux commandes SQL
	 */
	public function __construct() {
            parent::__construct();
            // demande à charger les paramètres de configuration du fichier models.php
            $this->config->load("models");
            $server = $this->config->item("hostname");
            $bdd = $this->config->item("database");
            $user = $this->config->item("username");
            $mdp = $this->config->item("password");
            $driver = $this->config->item("dbdriver");

            // ouverture d'une connexion vers le serveur MySql dont la configuration vient d'être chargée
            try {
                    $this->monPdo = new PDO($driver . ":host=" . $server . ";dbname=" . $bdd, 
                        			$user, $mdp, 
						array( PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'UTF8'",
                                                       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                                                );	
            }
            catch (Exception $e) {
                    log_message('error', $e->getMessage());
                    throw new Exception("Base de données inaccessible");
            }
            $this->cmdSelectByStudentId = null;
            $this->cmdSelectByRef = null;
	}
	/**
	 * Retourne l'ensemble des situations professionnelles d'un étudiant
         *  spécifié sous forme de tableaux d'objets situations professionnelles
	 *
	 * @return array tableau d'objets situations professionnelles (propriétés objet = colonnes table)
	 */
	public function get_all_bystudent($num) {
            
            // préparation de la requête de sélection des SPs à partir du numéro de l'étudiant
            if ($this->cmdSelectByStudentId == null) {
 		$query = "select * from port_situation where numEtudiant = :num order by libcourt";
 		$this->cmdSelectByStudentId = $this->monPdo->prepare($query);
		$this->cmdSelectByStudentId->setFetchMode(PDO::FETCH_ASSOC);
            }
            $this->cmdSelectByStudentId->bindParam("num", $num);
            $this->cmdSelectByStudentId->execute();
            $lignes = $this->cmdSelectByStudentId->fetchAll();
            $this->cmdSelectByStudentId->closeCursor();
            return $lignes;
	}
        /**
         * Fournit la situation professionnelle correspondant à la référence spécifiée
         * @param string $ref
         * @return array false ou tableau correspondant à la ligne demandée
         */
        public function get_one_byref($ref) {
            // préparation de la requête de sélection d'une SP à partir de sa référence
            if ($this->cmdSelectByRef == null) {
 		$query = "select * from port_situation where ref = :ref";
 		$this->cmdSelectByRef = $this->monPdo->prepare($query);
		$this->cmdSelectByRef->setFetchMode(PDO::FETCH_ASSOC);
            }
            $this->cmdSelectByRef->bindParam("ref", $ref);
            $this->cmdSelectByRef->execute();
            $ligne = $this->cmdSelectByRef->fetch();
            $this->cmdSelectByRef->closeCursor();
            return $ligne;            
        }
	/**
	 * Met à jour les données de la situation professionnelle demandée
	 * à partir d'une référence $ref et d'un tableau des données $lesDonnees
         * @param string $ref
         * @param array $lesDonnees
	 * @return boolean true si opération réussie, false sinon
	 */	
	public function update($ref, $lesDonnees) {
		
            // initialisation du début de la requête update
            $req = "update port_situation set ";
            // parcours des éléments du tableau $lesDonnees pour construire la requête update
            foreach ($lesDonnees as $field => $value) {
                // on complète la requête par nomDeColonne = nomDeParamètre,
                $req .= $field ."=:" . $field . ",";
            }
            // on termine la requête en enlevant la dernière virgule et en restreignant à l'organisation du numéro demandé
            $req = substr($req, 0, -1) . " where ref=:ref";
		
            // on prépare la requête 
            $cmdUpdate = $this->monPdo->prepare($req);
            // on initialise la valeur de la référence
            $cmdUpdate->bindValue("ref", $ref);
            // parcours des éléments du tableau $lesDonnees pour valoriser les paramètres de la requête
            foreach ($lesDonnees as $field => $value) {
                // on complète les paramètres utilisés pour l'exécution de la requête
                $cmdUpdate->bindValue($field, $value);
            }
            // exécution de la requête
            $cmdUpdate->execute();            
            $nb = $cmdUpdate->rowCount();
            return $nb > 0;
	}
}
?>