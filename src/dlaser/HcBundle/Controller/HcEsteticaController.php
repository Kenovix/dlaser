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
	
	function newAction($hc){
		
		$em = $this->getDoctrine()->getEntityManager();
		$HC = $em->getRepository('HcBundle:Hc')->find($hc);
		$estetica = $HC->getHcEstetica();
		
		if($HC and !$estetica){
			$HcEstetica = new HcEstetica();
			$HcEstetica->setFecha(new \DateTime('now'));
			$form   = $this->createForm(new HcEsteticaType(), $HcEstetica);				
			
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
			$breadcrumbs->addItem("Historia Estetica", $this->get("router")->generate("HcEstetica_new",array('hc'=>$hc)));
			$breadcrumbs->addItem("Nueva");
			
			return $this->render("HcBundle:HcEstetica:new.html.twig", array(
					'entity' => $HcEstetica,
					'hc' => $hc,
					'form'   => $form->createView()
			));			
		}else{
			$this->get('session')->setFlash('error', 'La historia clinica no existe o la hc-estetica ya se encuentra creada.'.
					'Porfavor consulte el usuario con su respectiva identificasion.');
			
			return $this->redirect($this->generateUrl('hc_search'));
		}
		
		
	}
	
	public function saveAction($hc)
	{
		$HcEstetica = new HcEstetica();		
		$request = $this->getRequest();
		$form   = $this->createForm(new HcEsteticaType(), $HcEstetica);				
		$form->bindRequest($request);
	
		if ($form->isValid()) {
			
			$HcEstetica->serialize();
			
			$em = $this->getDoctrine()->getEntityManager();
			$hc = $em->getRepository('HcBundle:Hc')->find($hc);
			
			if($hc){
				
				$HcEstetica->setHc($hc);				
				$em->persist($HcEstetica);
				$em->flush();
				
				$this->get('session')->setFlash('ok', 'La historia de estetica ha sido creado éxitosamente.');
				return $this->redirect($this->generateUrl('HcEstetica_edit',array('hc'=>$hc)));				
			}else{
				$this->get('session')->setFlash('error', 'La historia clinica no existe.');
				return $this->redirect($this->generateUrl('hc_search'));
			}	
		}else{
			$this->get('session')->setFlash('error', 'Los campos de historia de estetica no son correctos.');
			return $this->render("HcBundle:HcEstetica:new.html.twig", array(
					'entity' => $HcEstetica,
					'hc' => $hc,
					'form'   => $form->createView()
			));				
		}	
	}
	
	public function editAction($hc)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$hcEstetica = $em->getRepository('HcBundle:HcEstetica')->findOneBy(array('hc' => $hc));		
				
		if($hcEstetica)
		{
			$serialize = array(
					'op' => $hcEstetica->getOp(),
					'pigmentacion' => $hcEstetica->getPigmentacion(),
					'arrugas' => $hcEstetica->getArrugas(),
					'flacidez' => $hcEstetica->getFlacidez(),
					'parpado' => $hcEstetica->getParpado(),
					'lesiones_cut' => $hcEstetica->getLesionesCut(),
			);
						
			$hcEstetica->unserialize($serialize);
						
			$editform   = $this->createForm(new HcEsteticaType(), $hcEstetica);		
			
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
			$breadcrumbs->addItem("Historia Estetica", $this->get("router")->generate("HcEstetica_new",array('hc'=>$hc)));
			$breadcrumbs->addItem("Modificar");
			
			return $this->render('HcBundle:HcEstetica:edit.html.twig', array(
					'entity' => $hcEstetica,
					'hc' => $hc,
					'edit_form'   => $editform->createView()
			));			
			
		}else{
				$this->get('session')->setFlash('error', 'La historia clinica no existe.');
				return $this->redirect($this->generateUrl('hc_search'));
		}	
	}
	
	public function updateAction($estetica)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$HcEstetica = $em->getRepository('HcBundle:HcEstetica')->find($estetica);
					
		if($HcEstetica)			
		{		
			$serialize = array(
					'op' => $HcEstetica->getOp(),
					'pigmentacion' => $HcEstetica->getPigmentacion(),
					'arrugas' => $HcEstetica->getArrugas(),
					'flacidez' => $HcEstetica->getFlacidez(),
					'parpado' => $HcEstetica->getParpado(),
					'lesiones_cut' => $HcEstetica->getLesionesCut()
					);			
			$HcEstetica->unserialize($serialize);			
			$request = $this->getRequest();
			$form   = $this->createForm(new HcEsteticaType(), $HcEstetica);			
			$form->bindRequest($request);
						
			$hc = $HcEstetica->getHc();			
			
			if ($form->isValid())
			{
				$HcEstetica->serialize();			
				$em->persist($HcEstetica);
				$em->flush();
				
				$this->get('session')->setFlash('info', 'La historia de estetica ha sido modificada éxitosamente.');
				return $this->redirect($this->generateUrl('HcEstetica_edit',array('hc' => $hc->getId())));				
				
			}else{
				$breadcrumbs = $this->get("white_october_breadcrumbs");
				$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
				$breadcrumbs->addItem("Historia Estetica", $this->get("router")->generate("HcEstetica_new",array('hc'=>$hc->getId())));
				$breadcrumbs->addItem("Modificar");
				
				return $this->render('HcBundle:HcEstetica:edit.html.twig', array(
						'entity' => $HcEstetica,
						'hc' => $hc,
						'edit_form'   => $form->createView()
				));
			}
		}else{
				$this->get('session')->setFlash('error', 'La historia clinica no existe.');
				return $this->redirect($this->generateUrl('hc_search'));
		}
	}
}