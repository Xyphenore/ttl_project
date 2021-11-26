<?php
namespace App\Libraries\SuzyForm\InputsForm;

/**
 * Classe Abstraite
 */
abstract class InputForm
{
    protected $_tabAttrib = array('type' => '', 'name' => '', 'id' => '', 'class' => '');

    /**
     * Génère le code HTML des inputs d'un formulaire
     *
     * @return void
     */
    protected abstract function returnHTML();

    /**
     * Constructeur
     *
     * @param [String] $type
     * @param [String] $name
     * @param [String] $id
     * @param [String] $class
     */
    protected function __construct($type, $name, $id, $class)
    {
        $this->_tabAttrib['type'] = $type;
        $this->_tabAttrib['name'] = $name;
        $this->_tabAttrib['id'] = $id;
        $this->_tabAttrib['class'] = $class;
    }

    /**
     * Destructeur
     */
    protected function __destruct()
    {
    }
}
?>