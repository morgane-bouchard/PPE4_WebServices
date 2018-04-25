<?php  
require('REST_PCP_Controller.php');  
/**
 * Regroupement de web services sur les médecins
 * Le format de retour des résultats est mémorisé dans la classe mère
 * Ce format sera utilisé lors de la génération de la réponse (méthode response)
 * @author baraban
 *
 */
class WSActivite extends REST_PCP_Controller {  
    /**
     * Fournit au format xml ou json la liste des activités professionnelles
     * de la situation actuelle
     * Paramètre : aucun
     * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
     */   
    public function getBySituation_get() {  
        $ref = $this->get('ref');
        $activite = $this->activite_model->get_all_bysituation($ref);  
        if (is_array($activite)) {
            $res = array("status" => 0, "error" => "OK", "sitpros" => $activite);
        }
        else {
            $res = array("status" => 10, "error" => "Liste des activités impossible à obtenir. Contacter l'administrateur système.");
        }
        $this->response($res);  
    }
    
    /**
     * Fournit toute les activités
     */
    public function getAllActivities_get() { 
        $activite = $this->activite_model->get_all_activities(); 
        if (is_array($activite)) {
            $res = array("status" => 0, "error" => "OK", "sitpros" => $activite);
        }
        else {
            $res = array("status" => 10, "error" => "Liste des activités impossible à obtenir. Contacter l'administrateur système.");
        }
        $this->response($res); 
    }

    /**
     * Ajoute une activité à une situation
     */   
    public function add_get(){
        $ref = $this->get('ref');
        $id = $this->get('id');
        //$activite = $this->activite_model->add_activity_to_situation($id, $ref);
        
        
        //$this->load->library('form_validation');

	// définition des règles de validation des champs du formulaire d'ajout
	//$this->form_validation->set_rules('refSituation', 'référence', 'required|is_natural_no_zero|callback_verifExistenceRef');
	//$this->form_validation->set_rules('idActivite', 'id de l\'activité', 'required');
		
	// demande de validation des champs du formulaire
	/*if ($this->form_validation->run() == FALSE) { // au moins une règle non validée
            $res = array('status' => 3, 'error' =>  $this->form_validation->error_string());   
        }
        else { // règles de validation ok*/
            //$res = array('status' => 9, 'error' => "Impossibilité de modifier la situation professionnelle.");
            $result = $this->activite_model->add_activity_to_situation($id, $ref);
            if($result === FALSE) {
                $res = array('status' => 10, 'error' => "Impossibilité de modifier la situation professionnelle.");
            }
            else {
                $res = array('status' => 0, 'error' => "OK");
            }
        //}
    	$this->response($res);
        
    }
    
    /**
     * Supprime une activité à une situation
     */   
    /*public function delete(){
        
    }*/
}
