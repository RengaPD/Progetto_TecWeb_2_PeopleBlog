<?php
class App_Form_Abstract extends Zend_Form
{
    public $elementDecorators = array(
        'ViewHelper',
        array(array('alias1'=>'HtmlTag'),array('tag'=>'br','openOnly'=>true,'placement'=>'append')),
        array(array('alias2'=>'HtmlTag'),array('tag'=>'font','color'=>'red','openOnly'=>true,'placement'=>'append')),
        'Errors',
        array(array('alias3'=>'HtmlTag'),array('tag'=>'font','closeOnly'=>true,'placement'=>'append')),
        array('Label',array('tag'=>'br')),
    );

    public $buttonDecorators = array(
        'ViewHelper',
        array(array('alias1'=>'HtmlTag'),array('tag'=>'br','openOnly'=>true,'placement'=>'append')),
    );

    public $fileDecorators = array(
        'File',
        array(array('alias1' => 'HtmlTag'),array('tag' => 'td', 'class' => 'file')),
        array(array('alias2' => 'HtmlTag'), array('tag' => 'td', 'class' => 'errors', 'openOnly' => true, 'placement' => 'append')),
        'Errors',
        array(array('alias3' => 'HtmlTag'), array('tag' => 'td', 'closeOnly' => true, 'placement' => 'append')),
        array('Label', array('tag' => 'td')),
        array(array('alias4' => 'HtmlTag'), array('tag' => 'tr')),
    );
}