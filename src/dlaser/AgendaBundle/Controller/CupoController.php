<?php

namespace dlaser\AgendaBundle\Controller;

use dlaser\ParametrizarBundle\Entity\Cargo;

use dlaser\ParametrizarBundle\Entity\Paciente;

use Doctrine\Tests\Common\Annotations\Null;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use dlaser\AgendaBundle\Entity\Cupo;
use dlaser\ParametrizarBundle\Entity\Afiliacion;
use dlaser\AgendaBundle\Form\CupoType;
use dlaser\AdminBundle\Form\AfiliacionType;


class CupoController extends Controller
{

    public function listAction()
    {        
        return $this->render('AgendaBundle:Cupo:list.html.twig');
    }

    public function newAction()
    {
        $entity = new Cupo();
        
        $user = $this->get('security.context')->getToken()->getUser();        
        $id=$user->getId();
        
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        
        $breadcrumbs->addItem("Inicio", $this->get("router")->generate("cupo_new"));
        
        $breadcrumbs->addItem("pruebita", $this->get("router")->generate("cupo_new"));
        $breadcrumbs->addItem("prueba");
        
        $form   = $this->createForm(new CupoType(array('user' => $id)), $entity);
        
        $afiliacion = new Afiliacion();
        
        $form_afil = $this->createForm(new AfiliacionType(), $afiliacion);
    
        return $this->render('AgendaBundle:Cupo:new.html.twig', array(
                'entity' => $entity,
                'form'   => $form->createView(),
        		'form_afil' => $form_afil->createView()
        ));
    }    

    public function saveAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
                
        $form = $this->createForm(new CupoType());
        $request = $this->getRequest();
        $entity = $request->get($form->getName());

        $cupo = $em->getRepository('AgendaBundle:Cupo')->find($entity['hora']);
        $paciente = $em->getRepository('ParametrizarBundle:Paciente')->findOneBy(array('identificacion' => $entity['paciente']));
        $cargo = $em->getRepository('ParametrizarBundle:Cargo')->find($entity['cargo']);
        
        $user = $this->get('security.context')->getToken()->getUser();
            
        $cupo->setRegistra($user->getId());
        $cupo->setPaciente($paciente);
        $cupo->setCargo($cargo);
        $cupo->setEstado('A');
        $cupo->setNota($entity['nota']);
        $cupo->setCliente($entity['cliente']);
            
        $em->persist($cupo);
        $em->flush();
    
        $this->get('session')->setFlash('info', 'La reserva ha sido creada éxitosamente.');
    
        return $this->redirect($this->generateUrl('cupo_show', array('id' => $cupo->getId())));
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $cupo = $em->getRepository('AgendaBundle:Cupo')->find($id);
    
        if (!$cupo) {
            throw $this->createNotFoundException('La reserva solicitada no existe.');
        }
        
        $usuario = $em->getRepository('UsuarioBundle:Usuario')->find($cupo->getRegistra());
                    
        return $this->render('AgendaBundle:Cupo:show.html.twig', array(
                'cupo'  => $cupo,
        		'usuario' => $usuario
        ));
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();    
        $entity = $em->getRepository('AgendaBundle:Cupo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('La reserva solicitada no existe');
        }

        $user = $this->get('security.context')->getToken()->getUser();
        $id=$user->getId();

        $editForm = $this->createForm(new CupoType(array('user' => $id)));

        return $this->render('AgendaBundle:Cupo:edit.html.twig', array(
                'entity'      => $entity,
                'edit_form'   => $editForm->createView(),
        ));
    }

    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $form = $this->createForm(new CupoType());
        $request = $this->getRequest();
        $entity = $request->get($form->getName());
        
        if($id != $entity['hora']){
            
            $cupo = $em->getRepository('AgendaBundle:Cupo')->find($id);
            
            if($cupo){
                
                $cupo->setEstado('L');
                
                $em->persist($cupo);
                $em->flush();
                
                $cupo = $em->getRepository('AgendaBundle:Cupo')->find($entity['hora']);
                $paciente = $em->getRepository('ParametrizarBundle:Paciente')->findOneBy(array('identificacion' => $entity['paciente']));
                $cargo = $em->getRepository('ParametrizarBundle:Cargo')->find($entity['cargo']);
                
                $user = $this->get('security.context')->getToken()->getUser();
                
                $cupo->setRegistra($user->getId());
                $cupo->setPaciente($paciente);
                $cupo->setCargo($cargo);
                $cupo->setEstado('A');
                $cupo->setNota($entity['nota']);
                $cupo->setCliente($entity['cliente']);
                
                $em->persist($cupo);
                $em->flush();
                
            }
        }else{
            
            $cupo = $em->getRepository('AgendaBundle:Cupo')->find($id);            
            $paciente = $em->getRepository('ParametrizarBundle:Paciente')->findOneBy(array('identificacion' => $entity['paciente']));
            $cargo = $em->getRepository('ParametrizarBundle:Cargo')->find($entity['cargo']);
            
            $user = $this->get('security.context')->getToken()->getUser();
            
            $cupo->setRegistra($user->getId());
            $cupo->setPaciente($paciente);
            $cupo->setCargo($cargo);
            $cupo->setEstado('A');
            $cupo->setNota($entity['nota']);
            $cupo->setCliente($entity['cliente']);
            
            $em->persist($cupo);
            $em->flush();
        }
        
        $this->get('session')->setFlash('info', 'La información de la reserva ha sido modificada éxitosamente.');
    
        return $this->redirect($this->generateUrl('cupo_show', array('id' => $cupo->getId())));
        
    }
    
    public function deleteAction()
    {    	
    	$request = $this->get('request');
    	$cupo=$request->request->get('cupo');
    	    	    	
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$cupo = $em->getRepository('AgendaBundle:Cupo')->find($cupo);
    
    	if (!$cupo) {
        	$response=array("responseCode"=>400, "msg"=>"El cupo solicitado es incorrecto.");
    		
    		$return=json_encode($response);
    		return new Response($return,200,array('Content-Type'=>'application/json'));
        }
        
        $cupo->setEstado('L');
        $cupo->setNota('');
        $cupo->setRegistra('');
        $cupo->setVerificacion(null);
        $cupo->setCliente(null);
        $cupo->setPaciente(null);
        $cupo->setCargo(null);
        
        $em->persist($cupo);
        $em->flush();
    
    	$response=array("responseCode"=>200);
    
    	$return = json_encode($response);
        return new Response($return,200,array('Content-Type'=>'application/json'));
    }

    public function searchAction()
    {
    
    	return $this->render('AgendaBundle:Cupo:search.html.twig');
    }

    public function ajaxBuscarAction(){
    
        $request = $this->get('request');
        $paciente=$request->request->get('paciente');
        $agenda=$request->request->get('agenda');
        $cargo=$request->request->get('cargo');
        $reserva=$request->request->get('cupo');
    
        if(is_numeric($paciente) && is_numeric($agenda) && is_numeric($cargo)){
    
            $em = $this->getDoctrine()->getEntityManager();
            
            $cupo = $em->getRepository('AgendaBundle:Cupo')->findBy(array('paciente' => $paciente, 'agenda' => $agenda, 'cargo' => $cargo));
            
            if ($cupo && !$reserva){
                $response=array("responseCode"=>400, "msg"=>"El paciente ingresado ya cuenta con una reserva para esta actividad");
            }else{
                
                $cupo = $em->getRepository('AgendaBundle:Cupo')->findBy(array('agenda' => $agenda, 'estado' => 'L'));
                
                if($cupo){
                
                    $response=array("responseCode"=>200);
                
                    foreach($cupo as $value)
                    {
                        $response['cupo'][$value->getId()] = $value->getHora()->format('H:i');
                    }
                }else{
                    $response=array("responseCode"=>400, "msg"=>"No hay cupos disponibles en esta agenda.");
                }
            }
            
            $return=json_encode($response);
            return new Response($return,200,array('Content-Type'=>'application/json'));
        }
    }

    public function ajaxListarAction(){
    
        $request = $this->get('request');        
        $agenda=$request->request->get('agenda');
    
        if(is_numeric($agenda)){
            
            $em = $this->getDoctrine()->getEntityManager();
    
            $query = $em->createQuery(' SELECT c.id,
                    c.hora,
                    c.estado,
                    c.nota,
                    c.registra,
                    c.verificacion,                    
                    p.id AS paciente,
            		p.priNombre, 
                    p.segNombre, 
                    p.priApellido, 
                    p.segApellido, 
                    car.nombre
                    FROM AgendaBundle:Cupo c
                    LEFT JOIN c.paciente p
                    LEFT JOIN c.cargo car
                    WHERE c.agenda = :agenda
                    ORDER BY c.hora ASC');
            
            
            $query->setParameter('agenda', $agenda);
            
            $cupo = $query->getArrayResult();
            
            
            if (!$cupo){
                $response=array("responseCode"=>400, "msg"=>"La agenda no tiene cupos definidos.");
            }else{           
    
                $response=array("responseCode"=>200);
    
                foreach($cupo as $key => $value)
                {
                    $response['cupo'][$key] = $value;
                }
                
            }
    
            $return=json_encode($response);
            return new Response($return,200,array('Content-Type'=>'application/json'));
        }
    }

    /**
     * @uses Función que consulta un cupo por un parametro definido.
     *
     * @param ninguno
     */
    public function ajaxBuscarCupoAction() {
    
    	$request = $this->get('request');
    	$parametro=$request->request->get('parametro');
    	$valor=$request->request->get('valor');
    
    	$em = $this->getDoctrine()->getEntityManager();
    
    	$fecha=new \DateTime('now');
    
    	if($parametro == 'codigo'){
    		$query = $em->createQuery(' SELECT c.id,
    				c.hora,
    				c.nota,
    				c.registra,
    				c.verificacion,
    				p.priNombre,
    				p.segNombre,
    				p.priApellido,
    				p.segApellido,
    				car.nombre
    				FROM AgendaBundle:Cupo c
    				LEFT JOIN c.paciente p
    				LEFT JOIN c.cargo car
    				WHERE c.verificacion = :codigo
    				AND c.hora >= :fecha
    				ORDER BY c.hora ASC');
    
    		$query->setParameter('fecha', $fecha->format('Y-m-d 00:00:00'));
    		$query->setParameter('codigo', $valor);
    		$reserva = $query->getArrayResult();
    	}

    	if($parametro == 'identificacion'){
    
    		$query = $em->createQuery(" SELECT c.id,
    				c.hora,
    				c.nota,
    				c.registra,
    				c.verificacion,
    				p.priNombre,
    				p.segNombre,
    				p.priApellido,
    				p.segApellido,
    				car.nombre as cargo,
    				s.nombre as sede
    				FROM AgendaBundle:Cupo c
    				LEFT JOIN c.paciente p
    				LEFT JOIN c.cargo car
    				LEFT JOIN c.agenda a
    				LEFT JOIN a.sede s
    				WHERE 
    					p.identificacion = :identificacion AND
    					c.estado = 'A' AND
    					c.hora >= :fechaI
    				ORDER BY c.hora ASC");

    		$query->setParameter('fechaI', $fecha->format('Y-m-d 00:00:00'));
    		$query->setParameter('identificacion', $valor);
    		$reserva = $query->getArrayResult();
    	}

    	if($parametro == 'nombre'){
    
    		$query = $em->createQuery(" SELECT c.id,
    				c.hora,
    				c.nota,
    				c.registra,
    				c.verificacion,
    				p.priNombre,
    				p.segNombre,
    				p.priApellido,
    				p.segApellido,
    				car.nombre
    				FROM AgendaBundle:Cupo c
    				LEFT JOIN c.paciente p
    				LEFT JOIN c.cargo car
    				WHIT p.priNombre LIKE '%hernan%'");
    
    
    		$query->setParameter('nombre', $valor);
    		$reserva = $query->getArrayResult();
    	}
    
    	if (!$reserva){
    		$response=array("responseCode"=>400, "msg"=>"No existen reservas para los parametros de consulta ingrasados.");
    	}else{
    
    		$response=array("responseCode"=>200);
    
    		foreach($reserva as $key => $value)
    		{
    			$response['cupo'][$key] = $value;
    		}
    
    	}
    
    	$return=json_encode($response);
    	return new Response($return,200,array('Content-Type'=>'application/json'));
    
    }
}