<?php
namespace App\Libraries\SuzyForm;


/**
 * Classe pour générer un formulaire en HTML
 */
class Formulaire
{
    private $_method;
    private $_action;
    private $_enctype;
    private $_name;
    private $_id;
    private $_class;
    private $_tabObjectForm = array();

    /**
     * Constructeur
     *
     * @param [String] $method
     * @param [String] $action
     * @param [String] $name
     * @param [String] $id
     * @param [String] $enctype
     * @param [String] $class
     */
    public function  __construct($method, $action, $name, $id, $enctype, $class)
    {
        $this->_method = $method;
        $this->_action = $action;
        $this->_name = $name;
        $this->_id = $id;
        $this->_enctype = $enctype;
        $this->_class = $class;
    }

    /**
     * Destructeur
     * On délègue à la classe Formulaire la destruction 
     * des instances d'ObjectForm contenus dans $_tabObjectForm
     */
    public function __destruct()
    {
        foreach($this->_tabObjectForm as $element)
            $element->__destruct();     
    }

    /**
     * Ajoute un ObjectForm au formulaire instancié
     *
     * @param [ObjectForm] $object
     * @return void
     */
    public function addObject($object)
    {
        array_push($this->_tabObjectForm, $object);
    }

    /**
     * Génération du formulaire HTML
     *
     * @return void
     */
    public function  writeForm()
    {
        echo '<form action="' . $this->_action . '" method="' . $this->_method . '" ';
        echo 'name="' . $this->_name . '" id="' . $this->_id . '" ';
        if (!is_Null($this->_enctype))
            echo 'enctype="' . $this->_enctype . '" ';

        if (!is_Null($this->_class))
            echo 'class="' . $this->_class . '" ';

        echo ' ><br/>';
        echo '<?= csrf_field() ?>';
        foreach ($this->_tabObjectForm as $element) {
            $element->returnHTML();
        }
        echo '</form><br/>';
    }
}