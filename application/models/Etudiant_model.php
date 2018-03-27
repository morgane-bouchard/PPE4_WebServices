<?php  if (!defined('BASEPATH'))   exit('No direct script access allowed');

class Etudiant_Model extends CI_Model {
	private  $monPdo;
	private	 $cmdSelectByLoginMdp;
	private $cmdUpdateMdp;
	/**
	 * Initialise une instance de la classe Visiteur_Model
	 * - Récupère les paramètres de configuration liés au serveur MySql
	 * - Prépare les requêtes SQL qui comportent des parties variables
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
                $this->cmdSelectByLoginMdp = null;
                $this->cmdUpdateMdp = null;
	}
	/**
	 * Retourne les données du visiteur médical si couple (login, mdp) existant,
	 * le booléen false sinon.
	 *
	 * @return array tableau comportant toutes les données du visiteur authentifié
	 * @return boolean false si utilisateur non reconnu
	 */	
	public function get_one_byloginmdp($login, $mdp) {
            // préparation de la requête de sélection d'un étudiant à partir de son login (mél) et mot de passe (mdp)
            if ( $this->cmdSelectByLoginMdp == null ) {
 		$query = "select num, nom, prenom from port_etudiant where mel = :login and mdp = :mdp";
 		$this->cmdSelectByLoginMdp = $this->monPdo->prepare($query);
		$this->cmdSelectByLoginMdp->setFetchMode(PDO::FETCH_ASSOC);
            }
            $this->cmdSelectByLoginMdp->bindValue("login", $login);
            $this->cmdSelectByLoginMdp->bindValue("mdp", $mdp);
            $this->cmdSelectByLoginMdp->execute();
            $unEtudiant = $this->cmdSelectByLoginMdp->fetch();
            $succes = is_array($unEtudiant);
            $this->cmdSelectByLoginMdp->closeCursor();
            return $unEtudiant;            
	}
	
	/**
	 * Met à jour le mot de passe du visiteur identifié par son numéro
	 *
         * @param string $num
         * @param string $newMdp
	 * @return array tableau comportant toutes les données de l'étudiant authentifié
	 * @return boolean true si opération réussie, false sinon
	 */	
	public function update_mdp($num, $newMdp) {
            if ($this->cmdUpdateMdp == null ) {
 		$query = "update port_etudiant set mdp = :mdp where num = :num";
 		$this->cmdUpdateMdp = $this->monPdo->prepare($query);
            }
            $this->cmdUpdateMdp->bindValue("mdp", $newMdp);
            $this->cmdUpdateMdp->bindValue("num", $num);
            $this->cmdUpdateMdp->execute();
            $nb = $this->cmdUpdateMdp->rowCount();
            return $nb > 0;
	}
	
}
?>