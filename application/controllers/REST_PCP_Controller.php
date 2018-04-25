<?php  ;
require(APPPATH.'/libraries/REST_Controller.php');  
/**
 * Classe abstraite servant de modèle pour les contrôleurs jouant le rôle de services web
 * Chaque service web est appelé avec les informations des login et mot de passe de l'étudiant connecté.
 * Le constructeur de la classe abstraite vérifie la validité du couple (login, mot de passe) dans son constructeur,
 * et mémorise toutes les informations sur l'étudiant connecté si la validation s'est avérée positive.
 * Si invalide, renvoie un flux xml avec un statut de réponse particulier.
 */
 class REST_PCP_Controller extends REST_Controller { 
	protected $lEtudiant;
        protected $laSitution;
        /**
	 * Instancie un contrôleur jouant le rôle de service web pour VisPrat
	 */
	public function __construct() {
		parent::__construct();
		// récupère login et mot de passe dans l'url
		$login = $this->get('login');
		$mdp = $this->get('mdp');
		// on suppose que tout va bien se passer ...
		$status = 0;
		if ( !$login || !$mdp ) {
			$status = 1;
			$error = "Authentification incorrecte.";
		}		
		else {
			try {
                                // on charge tous les modèles
				$this->load->model("etudiant_model");
                                $this->load->model("sitpro_model");
                                $this->load->model("activite_model");
				// on recherche l'étudiant d'après son login et mot de passe
				$this->lEtudiant = $this->etudiant_model->get_one_byloginmdp($login, $mdp);
                                if ( ! is_array($this->lEtudiant) ) {
					$status = 1;
					$error = "Authentification incorrecte.";
                                }
			}
			catch (Exception $e) {
				$status = 2;
				$error = "Données inaccessibles. Contacter l'administrateur système.";
			}		 	
		}
		// dans le cas d'un statut différent de 0, une erreur grave empêche de poursuivre
		if ( $status != 0 ) {
			$res = array("status" => $status, "error" => $error);
			$this->response($res);
		}
	}
}  
?>