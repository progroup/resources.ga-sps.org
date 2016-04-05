<?php

class UsersField extends CheckboxesField 
{
  	public function __construct() 
  	{
    	$this->type    = 'checkboxes';
    	$this->options = array();
    
    	foreach(kirby()->site()->users() as $user) {
      		if(!$user->hasRole('admin')) {
        		$this->options[$user->username()] = $user->username();
      		}
    	}
  	}
}