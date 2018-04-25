<?php  if (!defined('BASEPATH'))   exit('No direct script access allowed');

class Activite_model extends CI_Model {
        private  $monPdo;
        private	 $cmdSelectBySituationId;
        private  $cmdSelectByRef;
        /**
	 * Initialise une instance de la classe Activite_model
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

            //$ref = $this->get('ref');
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
            $this->cmdSelectBySituationId = null;
            $this->cmdSelectByRef = null;
	}
        
        /**
	 * Retourne l'ensemble des activités d'une situation professionnelle
         *  spécifiées sous forme de tableaux d'objets activite
	 *
	 * @return array tableau d'objets activités (propriétés objet = colonnes table)
	 */
	public function get_all_bysituation($ref) {
            // préparation de la requête de sélection des activités à partir de la ref d'une situation
            if ($this->cmdSelectBySituationId == null) {
 		$query = "select id, nomenclature, libelle from port_activite join port_activitecitee on id = idActivite where refSituation = :ref order by nomenclature";
 		$this->cmdSelectBySituationId = $this->monPdo->prepare($query);
		$this->cmdSelectBySituationId->setFetchMode(PDO::FETCH_ASSOC);
            }
            $this->cmdSelectBySituationId->bindParam("ref", $ref);
            $this->cmdSelectBySituationId->execute();
            $lignes = $this->cmdSelectBySituationId->fetchAll();
            $this->cmdSelectBySituationId->closeCursor();
            return $lignes;
        }
        
        public function get_all_activities() {
            if ($this->cmdSelectBySituationId == null) {
 		$query = "select id, nomenclature, libelle from port_activite order by nomenclature";
 		$this->cmdSelectBySituationId = $this->monPdo->prepare($query);
		$this->cmdSelectBySituationId->setFetchMode(PDO::FETCH_ASSOC);
            }
            $this->cmdSelectBySituationId->execute();
            $lignes = $this->cmdSelectBySituationId->fetchAll();
            $this->cmdSelectBySituationId->closeCursor();
            return $lignes;
        }
        /**
	 * Retourne l'ensemble des activités d'une situation professionnelle
         *  spécifiées sous forme de tableaux d'objets activite
	 * 
         * @param string $id id de l'activité
         * @param string $ref référence de la situation
	 * @return array tableau d'objets activités (propriétés objet = colonnes table)
	 */
        public function add_activity_to_situation($id, $ref){
            try{
                if ($this->cmdSelectBySituationId == null) {
                    $query = "INSERT INTO port_activitecitee (idActivite, refSituation) VALUES (:id, :ref);";
                    $this->cmdSelectBySituationId = $this->monPdo->prepare($query);
                }
                $this->cmdSelectBySituationId->bindParam("id", $id);
                $this->cmdSelectBySituationId->bindParam("ref", $ref);
                $this->cmdSelectBySituationId->execute();
                return $this->cmdSelectBySituationId->rowCount()==1;
            }
            catch (Exception $uneException){
                return false;
            }
        }
}
