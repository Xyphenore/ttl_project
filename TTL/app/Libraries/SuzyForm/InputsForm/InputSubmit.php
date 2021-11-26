<?php
namespace App\Libraries\SuzyForm\InputsForm;
use App\Libraries\SuzyForm\InputsForm\InputForm;

class InputSubmit extends InputForm
{
    private $_value;

    public function __construct($type, $name, $id, $class, $value)
    {
        parent::__construct($type, $name, $id, $class);
        $this->_value = $value;
    }

    public function __destruct()
    {
       
    }

    public function returnHTML()
    {
        echo '<input type ="' . $this->_tabAttrib['type'] . '"';

        if (!is_Null($this->_tabAttrib['name']))
            echo 'name="' . $this->_tabAttrib['name'] . '" ';

        if (!is_Null($this->_tabAttrib['id']))
            echo 'id="' . $this->_tabAttrib['id'] . '" ';

        if (!is_Null($this->_tabAttrib['class']))
            echo 'class="' . $this->_tabAttrib['class'] . '" ';

        echo 'value="' . $this->_value . '" /><br/>';
    }
}

?>