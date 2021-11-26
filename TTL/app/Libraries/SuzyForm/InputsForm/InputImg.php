<?php
namespace App\Libraries\SuzyForm\InputsForm;
use App\Libraries\SuzyForm\InputsForm\InputForm;

class InputImg extends InputForm
{
    private $_src;
    private $_alt;
    private $_width;
    private $_height;

    public function __construct($src, $alt, $width, $height)
    {
        $this->_src = $src;
        $this->_alt = $alt;
        $this->_width = $width;
        $this->_height = $height;
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

        echo 'alt="' . $this->_alt . '" src="' . $this->_src . '" ';

        if (!is_Null($this->_width))
            echo 'width="' . $this->_width . '" ';

        if (!is_Null($this->_height))
            echo 'height="' . $this->_height . '" ';

        echo ' /><br/>';
    }
}

?>