<?php

namespace dlaser\AdminBundle\Controller;

use dlaser\AdminBundle\Form\AfiliacionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use dlaser\ParametrizarBundle\Entity\Paciente;
use dlaser\ParametrizarBundle\Entity\Afiliacion;
use dlaser\AdminBundle\Form\PacienteType;
use Symfony\Component\HttpFoundation\Response;

class PacienteController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $pacientes = $em->getRepository('ParametrizarBundle:Paciente')->findAll();

        return $this->render('AdminBundle:Paciente:list.html.twig', array(
                'entities'  => $pacientes
        ));
    }
    
    public function newAction()
    {
        $entity = new Paciente();
        $form   = $this->createForm(new PacienteType(), $entity);
        
        if ($this->get('security.context')->isGranted('ROLE_AUX')) {
        	$plantilla = 'ParametrizarBundle:Paciente:new.html.twig';
        }
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$plantilla = 'AdminBundle:Paciente:new.html.twig';
        }
        
    
        return $this->render($plantilla, array(
                'entity' => $entity,
                'form'   => $form->createView()
        ));
    }
    
    public function saveAction()
    {
        $entity  = new Paciente();
        $request = $this->getRequest();
        $form    = $this->createForm(new PacienteType(), $entity);
        $form->bindRequest($request);
    
        if ($form->isValid()) {
             
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
    
            $this->get('session')->setFlash('info', 'El paciente ha sido creado éxitosamente.');    
    
            return $this->redirect($this->generateUrl('paciente_show', array("id" => $entity->getId())));
    
        }
        
        if ($this->get('security.context')->isGranted('ROLE_AUX')) {
        	$plantilla = 'ParametrizarBundle:Paciente:new.html.twig';
        }
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$plantilla = 'AdminBundle:Paciente:new.html.twig';
        }
    
        return $this->render($plantilla, array(
                'entity' => $entity,
                'form'   => $form->createView()
        ));
    
    }
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $paciente = $em->getRepository('ParametrizarBundle:Paciente')->find($id);
    
        if (!$paciente) {
            throw $this->createNotFoundException('El paciente solicitado no existe.');
        }
        
        $afiliaciones = $em->getRepository('ParametrizarBundle:Afiliacion')->findByPaciente($id);
        
        $afiliacion = new Afiliacion();
        
        $form = $this->createForm(new AfiliacionType(), $afiliacion);
        
        $vars = array('paciente' => $paciente,
                      'afiliaciones' => $afiliaciones,
                      'form' => $form->createView());
        
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {        	
        	$plantilla = 'AdminBundle:Paciente:show.html.twig';        	
        }
        elseif ($this->get('security.context')->isGranted('ROLE_AUX')) {
        	$plantilla = 'ParametrizarBundle:Paciente:show.html.twig';        	
        }
    	
        return $this->render($plantilla, $vars);
    }
    
    public function editAction($id)
    {    	
    	$em = $this->getDoctrine()->getEntityManager();
    
        $entity = $em->getRepository('ParametrizarBundle:Paciente')->find($id);
        
    
        if (!$entity) {
            throw $this->createNotFoundException('El paciente solicitado no existe');
        }
    
        $editForm = $this->createForm(new PacienteType(), $entity);
        
        if ($this->get('security.context')->isGranted('ROLE_AUX')) {
        	$plantilla = 'ParametrizarBundle:Paciente:edit.html.twig';
        }
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$plantilla = 'AdminBundle:Paciente:edit.html.twig';
        }
    
        return $this->render($plantilla, array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView()
        ));
    }
    
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $entity = $em->getRepository('ParametrizarBundle:Paciente')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('El paciente solicitado no existe.');
        }
    
        $editForm   = $this->createForm(new PacienteType(), $entity);
    
        $request = $this->getRequest();
    
        $editForm->bindRequest($request);
    
        if ($editForm->isValid()) {
    
            $em->persist($entity);
            $em->flush();
    
            $this->get('session')->setFlash('info', 'La información del paciente ha sido modificada éxitosamente.');
    
            return $this->redirect($this->generateUrl('paciente_edit', array('id' => $id)));
        }
        
        if ($this->get('security.context')->isGranted('ROLE_AUX')) {
        	$plantilla = 'ParametrizarBundle:Paciente:edit.html.twig';
        }
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
        	$plantilla = 'AdminBundle:Paciente:edit.html.twig';
        }
    
        return $this->render($plantilla, array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
        ));
    }
    
    
    public function municipiosAction($id) 
    {
        if (is_numeric($_GET["newPaciente_depto"])){
            
            $em = $this->getDoctrine()->getEntityManager();            
            $entity = $em->getRepository('ParametrizarBundle:Mupio')->findBy(array('depto' => $_GET["newPaciente_depto"]));

            
            foreach($entity as $value)
            {
                $response[$value->getId()] = $value->getMunicipio();
            }
            
            if($id) $response["selected"] = $id;
        }
        
        $respuesta = new Response(json_encode($response));
        $respuesta->headers->set('Content-Type', 'application/json');
        
        return $respuesta;
        
    }
    
    
    public function ajaxBuscarAction(){
        
            $request = $this->get('request');
            $id=$request->request->get('id');
            
            if(is_numeric($id)){
            
                $em = $this->getDoctrine()->getEntityManager();
                $entity = $em->getRepository('ParametrizarBundle:Paciente')->findOneBy(array('identificacion' => $id));
                
                if($entity){
                    $cliente = $em->getRepository('ParametrizarBundle:Afiliacion')->findBy(array('paciente' => $entity->getId()));
                                           
                    $response=array("responseCode" => 200,
                                    "id" => $entity->getId(),
                                    "nombre" => $entity->getPriNombre()." ".$entity->getSegNombre()." ".$entity->getPriApellido()." ".$entity->getSegApellido());
                    
                    foreach($cliente as $value)
                    {
                        $response['cliente'][$value->getCliente()->getId()] = $value->getCliente()->getNombre();
                    }
                    
                }
                else{
                    $response=array("responseCode"=>400, "msg"=>"el paciente no existe en el sistema!");
                }
            }else{
                $response=array("responseCode"=>400, "msg"=>"Por favor ingrese un valor valido.");
            }
    
        $return=json_encode($response);
        return new Response($return,200,array('Content-Type'=>'application/json'));
    }

}