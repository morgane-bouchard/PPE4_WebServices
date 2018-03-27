<?php  
require('REST_PCP_Controller.php');  
/**
 * Regroupement de web services sur les étudiants
 * Le format de retour des résultats est mémorisé dans la classe mère
 * Ce format sera utilisé lors de la génération de la réponse (méthode response)
 * @author baraban
 *
 */
class WSEtudiants extends REST_PCP_Controller {  
	/**
	 * Fournit au format xml ou json le succès ou l'échec d'authentification d'un étudiant
	 * Pas de paramètres
	 * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
	 * Si on arrive jusqu'ici, login et mot de passe forment un couple validé
	 */
   public function authentifier_get() {
    	$res = array("status" => 0, "error" => "OK", "etudiant" => $this->lEtudiant);
    	$this->response($res);
    }
    /**
     * Fournit au format xml ou json la réussite ou l'échec de la modification de mot de passe
     * Paramètres URL : newmdp
     * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
     */
   public function changermdp_get()  {
   	$newmdp = $this->get('newmdp');
    	if ( !$newmdp ) {
    		$res = array('status' => 3, 'error' => 'Données incorrectes ou incomplètes');
    	}
    	else {
            $result = $this->etudiant_model->update_mdp( $this->lEtudiant['num'], $newmdp);
            if($result === FALSE) {
                    $res = array('status' => 10, 'error' => "Impossible de mettre à jour le mot de passe. Contacter l'administrateur système.");
            }
            else {
                    $res = array('status' => 0, 'error' => "OK");
            }
    	}
    	$this->response($res);
   }   
}  
?>