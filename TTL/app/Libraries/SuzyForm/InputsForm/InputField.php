<?php
namespace App\Libraries\SuzyForm\InputsForm;
use App\Libraries\SuzyForm\InputsForm\InputForm;
/**
 * Classe qui génère un champs de formulaire en HTML
 */
class InputField extends InputForm
{
    private $_placeholder;
    private $_pattern;
    private $_label;
    private $_required;
    private $_minLength;
    private $_maxLength;

    /**
     * Constructeur
     *
     * @param [String] $type
     * @param [String] $name
     * @param [String] $id
     * @param [String] $class
     * @param [String] $placeholder
     * @param [String] $pattern
     * @param [String] $label
     * @param [Boolean] $required
     * @param [Integer] $minLength
     * @param [Integer] $maxLength
     */
    public function __construct($type, $name, $id, $class, $placeholder,$pattern, $label, $required, $minLength, $maxLength)
    {
        parent::__construct($type, $name, $id, $class);
        $this->_placeholder = $placeholder;
        $this->_pattern = $pattern;
        $this->_label = $label;
        $this->_required = $required;
        $this->_minLength = $minLength;
        $this->_maxLength = $maxLength;
    }

    /**
     * Destructeur
     */
    public function __destruct()
    {
        
    }

    /**
     * Génère le code HTML de l'input
     *
     * @return void
     */
    public function returnHTML()
    {
        if (!is_Null($this->_label)) {
            echo '<label';
            if (!is_Null($this->_tabAttrib['id']))
                echo ' for="' . $this->_tabAttrib['id'] . '" ';

            echo '>' . $this->_label . '</label><br/> ';
        }

        echo '<input type ="' . $this->_tabAttrib['type'] . '" placeholder=" ' . $this->_placeholder . '" ';

        if (!is_Null($this->_pattern))
            echo 'id="' . $this->_pattern . '" ';

        if (!is_Null($this->_tabAttrib['name']))
            echo 'name="' . $this->_tabAttrib['name'] . '" ';

        if (!is_Null($this->_tabAttrib['id']))
            echo 'id="' . $this->_tabAttrib['id'] . '" ';

        if (!is_Null($this->_tabAttrib['class']))
            echo 'class="' . $this->_tabAttrib['class'] . '" ';

        if (!is_Null($this->_required))
            echo 'required ';

        if (!is_Null($this->_minLength))
            echo 'minLength="' . $this->_minLength . '" ';

        if (!is_Null($this->_maxLength))
            echo 'maxLength="' . $this->_maxLength . '" ';

        echo '/><br/>';
    }
}

?>