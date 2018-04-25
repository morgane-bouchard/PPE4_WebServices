<?php  
require('REST_PCP_Controller.php');  
/**
 * Regroupement de web services sur les médecins
 * Le format de retour des résultats est mémorisé dans la classe mère
 * Ce format sera utilisé lors de la génération de la réponse (méthode response)
 * @author baraban
 *
 */
class WSSitPros extends REST_PCP_Controller {  

    /**
     * Fournit au format xml ou json la liste des situations professionnelles
     * de l'étudiant connecté
     * Paramètre : aucun
     * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
     */    
    public function getByStudent_get() {  
        $num = $this->lEtudiant["num"];
        $sitpros = $this->sitpro_model->get_all_bystudent($num);  
        if (is_array($sitpros)) {
            $res = array("status" => 0, "error" => "OK", "sitpros" => $sitpros);
        }
        else {
            $res = array("status" => 10, "error" => "Liste des situations professionnelles impossible à obtenir. Contacter l'administrateur système.");
        }
        $this->response($res);  
    }  
    /**
     * Fournit au format xml ou json la réussite ou l'échec de la modification de la stituation professionnelle
     * Login et mot de passe de l'étudiant sont traités dans le constructeur de la classe mère
     */
    public function update_post() {
        $this->load->library('form_validation');

	// définition des règles de validation des champs du formulaire d'ajout
	$this->form_validation->set_rules('ref', 'référence', 'required|is_natural_no_zero|callback_verifExistenceRef');
	$this->form_validation->set_rules('libcourt', 'libellé court', 'max_length[50]');
	$this->form_validation->set_rules('descriptif', 'descriptif', '');
	$this->form_validation->set_rules('codeLocalisation', 'codeLocalisation', 'in_list[1,2]');
	$this->form_validation->set_rules('source', 'Source', '');
        // règle de validation ci-dessous ne fonctionne pas : l'expression régulière semble mal interprétée par la classe form_validation
        // $this->form_validation->set_rules('datedebut', 'Date de début', 'regex_match[/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/]');

        $this->form_validation->set_rules('datedebut', 'Date de début', 'callback_verifFormatDate');
	$this->form_validation->set_rules('datefin', 'Date de fin', 'callback_verifFormatDate');
		
	// demande de validation des champs du formulaire
	if ($this->form_validation->run() == FALSE) { // au moins une règle non validée
             $res = array('status' => 3, 'error' =>  $this->form_validation->error_string());   
        }
        else { // règles de validation ok
            // on vérifie que le nom de chaque donnée est connue, pour l'instant on n'accepte que 7 données
            $names = array("ref", "libcourt", "descriptif", "codeLocalisation", "codeSource", "datedebut", "datefin");
            $lesDonnees = $this->input->post(null, true);
            $erreur = false;
            foreach ($lesDonnees as $cle => $valeur) {
                if ( ! in_array($cle, $names )) {
                    $erreur = true;
                }
            }
            if ($erreur) {
                $res = array('status' => 3, 'error' => "Au moins un nom de donnée est inconnu. Consulter la documentation des web services.");
            }
            else {
                $ref = $lesDonnees["ref"];
                unset($lesDonnees["ref"]);
                $result = $this->sitpro_model->update($ref, $lesDonnees);
                if($result === FALSE) {
                        $res = array('status' => 10, 'error' => "Impossibilité de modifier la situation professionnelle.");
                }
                else {
                        $res = array('status' => 0, 'error' => "OK");
                }
            }
        }
    	$this->response($res);        
    }
    /**
     * Vérifie le format de la date au format MySql AAAA-MM-JJ
     * @param string $laDate
     * @return boolean
     */
    public function verifFormatDate($laDate) {
        $ok = true;
        if ( $laDate != "" && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $laDate) <= 0 ) {
            $this->form_validation->set_message('verifFormatDate', 'La %s ne respecte pas le format anglais AAAA-MM-JJ');
            $ok = false;
        }
        return $ok;
    }
    /**
     * Vérifie l'existence de la référence de la situation professionnelle
     * @param string $laRef
     * @return boolean
     */
    public function verifExistenceRef($laRef) {
        // si la valeur retournée est un tableau, la ligne existe bien dans les SPs
        $ligne = $this->sitpro_model->get_one_byref($laRef);
        $ok = is_array($ligne);
        if ( !$ok ) {
            $this->form_validation->set_message("verifExistenceRef", "La référence de situation professionnelle n'existe pas");
        }
        elseif ($ligne["numEtudiant"] != $this->lEtudiant['num'] ) {
            $ok = false;
            $this->form_validation->set_message("verifExistenceRef", "La référence de situation professionnelle ne fait pas partie de celles de l'étudiant connecté");
        }
        return $ok;
    }
}  
?>