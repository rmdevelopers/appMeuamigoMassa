<?php

/**
 * BaseAPI Class is the parent class
 * to other api's and common functionalities
 * share between different api's can be defined
 * here.
 *
 * @author jaison.justus
 */
class BaseAPI {
    
    
    public function __construct() {
        $this->time = new CDbExpression('NOW()');
    }
    
    
}

?>
