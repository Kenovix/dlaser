<?php
namespace dlaser\HcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use dlaser\HcBundle\Entity\HcEstetica;
use dlaser\ParametrizarBundle\Entity\Factura;

use dlaser\HcBundle\Form\HcEsteticaType;

class HcEsteticaController extends Controller{
	
	function newAction(){
		$HcEstetica = new HcEstetica();
		$form   = $this->createForm(new HcEsteticaType(), $HcEstetica);
							
		return $this->render("HcBundle:HcEstetica:new.html.twig", array(
				'entity' => $HcEstetica,
				'form'   => $form->createView()
		));
	}
	
	public function saveAction($factura)
	{
		$HcEstetica = new HcEstetica();
		$request = $this->getRequest();
		$form   = $this->createForm(new HcEsteticaType(), $HcEstetica);				
		$form->bindRequest($request);
	
		if ($form->isValid()) {
			
			$em = $this->getDoctrine()->getEntityManager();
			$factura = $em->getRepository('ParametrizarBundle:Factura')->find($factura);
			
			if($factura){
				
				
				$HcEstetica->setFactura($factura);				
				$em->persist($HcEstetica);
				$em->flush();
				
				$this->get('session')->setFlash('ok', 'La historia de estetica ha sido creado éxitosamente.');
				return $this->redirect($this->generateUrl('HcEstetica_new'));				
			}else{
				$this->get('session')->setFlash('error', 'La factura no existe.');
				return $this->redirect($this->generateUrl('HcEstetica_new'));
			}	
		}else{
			$this->get('session')->setFlash('error', 'Los campos de historia de estetica no son correctos.');
			return $this->redirect($this->generateUrl('HcEstetica_new'));			
		}	
	}
}