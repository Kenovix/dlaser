<?php

namespace dlaser\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
    		return $this->redirect($this->generateUrl('empresa_list'));
    	}
    	elseif ($this->get('security.context')->isGranted('ROLE_MEDICO')) {
    		return $this->redirect($this->generateUrl('agenda_medica_list'));
    	}
    	else{
    		return $this->redirect($this->generateUrl('cupo_new'));
    	}
    	 
    	
    }
}
