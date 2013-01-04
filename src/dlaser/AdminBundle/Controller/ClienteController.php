<?php

namespace dlaser\AdminBundle\Controller;;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use dlaser\ParametrizarBundle\Entity\Cliente;
use dlaser\ParametrizarBundle\Entity\Contrato;
use dlaser\AdminBundle\Form\ClienteType;

class ClienteController extends Controller
{

    public function listAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $clientes = $em->getRepository('ParametrizarBundle:Cliente')->findAll();

        return $this->render('AdminBundle:Cliente:list.html.twig', array(
                'entities'  => $clientes
        ));
    }
    
    public function newAction()
    {
        $entity = new Cliente();
        $form   = $this->createForm(new ClienteType(), $entity);
    
        return $this->render('AdminBundle:Cliente:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
        ));
    }
    
    public function saveAction()
    {
        $entity  = new Cliente();
        $request = $this->getRequest();
        $form    = $this->createForm(new ClienteType(), $entity);
        $form->bindRequest($request);
    
        if ($form->isValid()) {
             
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
    
            $this->get('session')->setFlash('info', 'El cliente ha sido creado éxitosamente.');
    
    
            return $this->redirect($this->generateUrl('cliente_show', array("id" => $entity->getId())));
    
        }
    
        return $this->render('AdminBundle:Cliente:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView()
        ));
    
    }
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $cliente = $em->getRepository('ParametrizarBundle:Cliente')->find($id);
    
        if (!$cliente) {
            throw $this->createNotFoundException('El cliente solicitado no existe.');
        }
        
        $contratos = $em->getRepository('ParametrizarBundle:Contrato')->findByCliente($id);
        
        $vars = array(
                'cliente' => $cliente,
                'contratos' => $contratos);
    
        return $this->render('AdminBundle:Cliente:show.html.twig', $vars);
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $entity = $em->getRepository('ParametrizarBundle:Cliente')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('El cliente solicitado no existe');
        }
    
        $editForm = $this->createForm(new ClienteType(), $entity);
        //$deleteForm = $this->createDeleteForm($id);
    
        return $this->render('AdminBundle:Cliente:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
                //'delete_form' => $deleteForm->createView(),
        ));
    }
    
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $entity = $em->getRepository('ParametrizarBundle:Cliente')->find($id);
    
        if (!$entity) {
            throw $this->createNotFoundException('El cliente solicitado no existe.');
        }
    
        $editForm   = $this->createForm(new ClienteType(), $entity);
    
        $request = $this->getRequest();
    
        $editForm->bindRequest($request);
    
        if ($editForm->isValid()) {
    
            $em->persist($entity);
            $em->flush();
    
            $this->get('session')->setFlash('info', 'La información del cliente ha sido modificada éxitosamente.');
    
            return $this->redirect($this->generateUrl('cliente_edit', array('id' => $id)));
        }
    
        return $this->render('AdminBundle:Cliente:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
        ));
    }

}