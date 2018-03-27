<?php  
/**
 * Regroupement de web services sur les étudiants
 * Le format de retour des résultats est mémorisé dans la classe mère
 * Ce format sera utilisé lors de la génération de la réponse (méthode response)
 * @author baraban
 *
 */
class WSTest extends CI_Controller {  
    /**
     * Fournit au format xml ou json le succès ou l'échec d'authentification d'un étudiant
     * Pas de paramètres
     * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
     * Si on arrive jusqu'ici, login et mot de passe forment un couple validé
     */
    public function updateSitPro() {
    	$this->load->view("modif_sitpro");
    }
}  
?>