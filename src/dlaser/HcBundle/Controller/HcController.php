<?php

namespace dlaser\HcBundle\Controller;


use dlaser\InformeBundle\Entity\Mapa;
use dlaser\HcBundle\Entity\HcMedicamento;
use dlaser\HcBundle\Entity\HcExamen;
use dlaser\ParametrizarBundle\Entity\Factura;
use dlaser\ParametrizarBundle\Entity\Paciente;
use dlaser\HcBundle\Entity\Hc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use dlaser\HcBundle\Form\MedicamentoType;
use dlaser\InformeBundle\Form\ThType;
use dlaser\HcBundle\Form\HcType;
use dlaser\HcBundle\Form\searchType;
use dlaser\HcBundle\Form\HcExamenType;
use dlaser\InformeBundle\Form\TeType;


class HcController extends Controller
{
	/* este metodo se establece para la creacion de la Historia clinica justo despues de hacer la facturacion 
	 * asi que el id que le llega a esta es el id de la factura 
	 */
	public function autoSaveAction($id)
	{
		$entity  = new Hc();		
						
			$em = $this->getDoctrine()->getEntityManager();
			$factura = $em->getRepository('ParametrizarBundle:Factura')->find($id);
			
			$existe = $em->getRepository('HcBundle:Hc')->findByFactura($id);
			
			if(!$factura || $existe)
			{
				throw $this->createNotFoundException('La factura relacionada ya esta en uso o no existe.');
			}		
			
			$paciente = $factura->getPaciente();
			$cargo = $factura->getCargo();
		
			$dql = $em->createQuery("SELECT hc FROM HcBundle:Hc hc JOIN hc.factura f JOIN f.paciente p
					WHERE p.identificacion = :id ORDER BY hc.fecha DESC");			
			
			$dql->setParameter('id', $paciente->getIdentificacion());
			$dql->setMaxResults(1);			
			$HC = $dql->getResult();
			
			//----- asignar los datos de la ultima historia clinica si el paciente aun no tiene hc entonces se le creare una nueva.	
			if($HC)
			{
				$HC = $dql->getSingleResult();				
								
				$entity->setHta($HC->getHta());
				$entity->setDiabetes($HC->getDiabetes());
				$entity->setDislipidemia($HC->getDislipidemia());
				$entity->setTabaquismo($HC->getTabaquismo());
				$entity->setObesidad($HC->getObesidad());
				$entity->setAnteFamiliar($HC->getAnteFamiliar());
				$entity->setSedentarismo($HC->getSedentarismo());
				$entity->setEnfermedad($HC->getEnfermedad());
				$entity->setExaFisico($HC->getExaFisico());
				$entity->setRevCardiovascular($HC->getRevCardiovascular());
				$entity->setManejo($HC->getManejo());
				$entity->setMotivoInter($HC->getMotivoInter());
				$entity->setControl($HC->getControl());
				$entity->setCtrlPrioritario($HC->getCtrlPrioritario());
				$entity->setPostfecha($HC->getPostfecha());					
				
				$entity->setFecha(new \DateTime('now'));		
				$entity->setFactura($factura);
				
				$em->persist($entity);
				$em->flush();
				
				// Verifica si de los examenes solicitados alguno fue hecho en ccv y trae conclusión
				$ultimaCx = $em->createQuery('SELECT
												f.id,
												f.fecha
											FROM
												ParametrizarBundle:Factura f
											WHERE
												f.paciente = :paciente AND
												f.cargo = :cargo
											ORDER BY 
												f.fecha DESC');
				
				$ultimaCx->setParameter('paciente', $paciente);
				$ultimaCx->setParameter('cargo', $cargo);
				
				$cxAnt = $ultimaCx->getArrayResult();
				
				if(count($cxAnt) > 1){
					$hc_ant = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $cxAnt[1]['id']));
						
					$dql = $em->createQuery('SELECT
												he.id,
												he.fecha,
												he.resultado,
												he.fecha_r,
												he.estado,
												e.nombre,
												e.codigo
											FROM
												HcBundle:HcExamen he
											JOIN
												he.examen e
											WHERE
												he.hc = :hc');
						
					$dql->setParameter('hc', $hc_ant->getId());
						
					$exaPresentados = $dql->getResult();
						
					if($exaPresentados){
				
						$exa_ccv = array("881234", "894102", "895001", "895101", "881236", "896100", "893805");
							
						foreach ($exaPresentados as $examen){
							if(in_array($examen['codigo'], $exa_ccv)){
								
								$dql = $em->createQuery('SELECT
															f.id
														FROM
															ParametrizarBundle:Factura f
														JOIN
															f.cargo c
														WHERE
															f.fecha > :fecha AND
															c.cups = :codigo');
								
								$dql->setParameter('codigo', $examen['codigo']);
								$dql->setParameter('fecha', $examen['fecha']);
								
								$exa_in_ccv = $dql->getArrayResult();
								
								if ($exa_in_ccv){
									switch($examen['codigo']){
										case "881234":
											$eco = $em->getRepository('InformeBundle:Eco')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
												
											$hc_examen->setFechaR($eco->getFecha());
											$hc_examen->setResultado($eco->getConclusion());
											$hc_examen->setEstado('R');
											
											$em->persist($hc_examen);
											$em->flush();											
											break;
											
										case "894102":
											$esfuerzo = $em->getRepository('InformeBundle:TE')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
										
											$hc_examen->setFechaR($esfuerzo->getFecha());
											$hc_examen->setResultado($esfuerzo->getConclusion());
											$hc_examen->setEstado('R');
										
											$em->persist($hc_examen);
											$em->flush();
											break;
											
										case "895001":
											$holter = $em->getRepository('InformeBundle:TH')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
										
											$hc_examen->setFechaR($holter->getFecha());
											$hc_examen->setResultado($holter->getConclusion());
											$hc_examen->setEstado('R');
												
											$em->persist($hc_examen);
											$em->flush();
											break;
										
										case "895101":
											$ekg = $em->getRepository('InformeBundle:Electrocardiograma')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);

											$hc_examen->setFechaR($ekg->getFecha());
											$hc_examen->setResultado($ekg->getObservacion());
											$hc_examen->setEstado('R');

											$em->persist($hc_examen);
											$em->flush();
											break;
											
										case "881236":
											$ecostres = $em->getRepository('InformeBundle:Ecostres')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
										
											$hc_examen->setFechaR($ecostres->getFecha());
											$hc_examen->setResultado($ecostres->getContenido());
											$hc_examen->setEstado('R');
										
											$em->persist($hc_examen);
											$em->flush();
											break;
											
										case "896100":
											$mapa = $em->getRepository('InformeBundle:Mapa')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
										
											$hc_examen->setFechaR($mapa->getFecha());
											$hc_examen->setResultado($mapa->getConclusiones());
											$hc_examen->setEstado('R');
										
											$em->persist($hc_examen);
											$em->flush();
											break;
											
										case "893805":
											$espiro = $em->getRepository('InformeBundle:Espirometria')->findOneBy(array('factura' => $exa_in_ccv[0]['id']));
											$hc_examen = $em->getRepository('HcBundle:HcExamen')->find($examen['id']);
										
											$hc_examen->setFechaR($espiro->getFecha());
											$hc_examen->setResultado($espiro->getObservacion());
											$hc_examen->setEstado('R');
										
											$em->persist($hc_examen);
											$em->flush();
											break;
									}
								}
							}
						}
					}
				}else {
					$exaPresentados = null;
				}

				$medi_hc = $em->getRepository('HcBundle:HcMedicamento')->findByHc($HC->getId());
				$cie_hc = $HC->getCie();
				
				$dql = $em->createQuery("SELECT hc FROM HcBundle:Hc hc JOIN hc.factura f JOIN f.paciente p
						WHERE p.identificacion = :id ORDER BY hc.fecha DESC");
					
				$dql->setParameter('id', $paciente->getIdentificacion());
				$dql->setMaxResults(1);
				$HC = $dql->getSingleResult();											
																
				
				foreach ($medi_hc as $medicamentos){
						
					$entity  = new HcMedicamento();			
					$entity->setEstado('R');
					$entity->setHc($HC);
					$entity->setMedicamento($medicamentos->getMedicamento());
						
					$em->persist($entity);
					$em->flush();
				}

				foreach ($cie_hc as $cies){
				
					if($HC->addCie($cies)){
					
						$em->persist($HC);
						$em->flush();
					}
				}							

				$this->get('session')->setFlash('info','La historia clinica se ha registrado correctamente ');
				
				return $this->redirect($this->generateUrl('factura_search'));
			}
			else{
				$entity->setFecha(new \DateTime('now'));
				$entity->setHta('no');
				$entity->setDiabetes('no');
				$entity->setDislipidemia('no');
				$entity->setTabaquismo('no');
				$entity->setObesidad('no');
				$entity->setAnteFamiliar('no');
				$entity->setSedentarismo('no');
				$entity->setEnfermedad('Requerido');
				$entity->setRevCardiovascular('Disnea no, ortopnea no, disnea nocturna paroxistica no, precordalgia no, palpitaciones no.');
				$entity->setExaFisico('Buen estado general,  corazón en ritmo regular  en dos tiempos, sin soplos, sin congestión pulmonar, sin congestión sistémica');
				$entity->setFactura($factura);

				$em->persist($entity);
				$em->flush();
								
				$this->get('session')->setFlash('info',
						'El paciente no registra visitas anteriores en el sistema.');
				
				return $this->redirect($this->generateUrl('factura_search'));
			}	
	}
	
	public function editAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();		
		$factura = $em->getRepository('ParametrizarBundle:Factura')->find($id);
		
		if(!$factura)
		{
			throw $this->createNotFoundException('La factura no existe');
		}
		
		$hc = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $id));
		
		if(!$hc)
		{
			throw $this->createNotFoundException('La historia clinica no existe');
		}

		$paciente = $factura->getPaciente();
		$cargo = $factura->getCargo();
	
		//-----------------------consultas de usuario con su respectiva relacion -----------------------------
		$usuario = $this->get('security.context')->getToken()->getUser();	

		$dql = $em->createQuery("SELECT 
									hc 
								FROM 
									HcBundle:Hc hc 
								JOIN 
									hc.factura f 
								JOIN 
									f.paciente p
								WHERE  
									p.id = :id 
								ORDER BY 
									hc.fecha DESC");
		
		$dql->setParameter('id', $paciente->getId());
		
		$signos = $dql->getResult();
	
		//------------------------------------- MEDICAMENTO --------------------------------------------------------
		
		$dql = $em->createQuery('SELECT m
								 FROM 
									HcBundle:Medicamento m
								 WHERE 
									m.usuario = :usuario AND
									m.estado = :estado
								 ORDER BY
									m.principioActivo, 
									m.concentracion, 
									m.tiempo ASC');
		
		$dql->setParameter('usuario', $usuario->getId());
		$dql->setParameter('estado', 'A');
		$medicamento = $dql->getResult();
	
		$dql = $em->createQuery('SELECT 
									hm.estado,
									hm.id,
									m.principioActivo,
									m.concentracion,
									m.dosisDia,
									m.tiempo,
									m.pos
								FROM 
									HcBundle:HcMedicamento hm 
								JOIN 
									hm.medicamento m
								WHERE 
									hm.hc = :id');
		
		$dql->setParameter('id', $hc->getId());
		$hcMe = $dql->getResult();
		//------------------------------------- END MEDICAMENTO-----------------------------------------------------
	
		//-------------------------------------DIAGNOSTICOS---------------------------------------------------------
		$dql = $em->createQuery('SELECT 
									c 
								 FROM 
									HcBundle:Cie c 
								JOIN 
									c.usuario u
								WHERE 
									u.id = :id AND 
									c.id NOT IN (
										SELECT 
											C 
										FROM 
											HcBundle:Cie C 
										JOIN 
											C.hc h 
										WHERE 
											h.id = :hc)
								ORDER BY
									c.nombre ASC');
		
		$dql->setParameter('id', $usuario->getId());
		$dql->setParameter('hc', $hc->getId());
		$cie = $dql->getResult();
			
		$hcCie = $hc->getCie();
		
		$list_dx = $em->getRepository("HcBundle:Cie")->findAll();
		//-------------------------------------END DIAGNOSTICOS-----------------------------------------------------
	
		//-------------------------------------EXAMENES---------------------------------------------------------
		
		$ultimaCx = $em->createQuery('SELECT
										f.id,
										f.fecha
									FROM
										ParametrizarBundle:Factura f
									WHERE
										f.paciente = :paciente AND
										f.cargo = :cargo
									ORDER BY f.fecha DESC');
		
		$ultimaCx->setParameter('paciente', $paciente);
		$ultimaCx->setParameter('cargo', $cargo);
		
		$cxAnt = $ultimaCx->getArrayResult();
		
		if(count($cxAnt) > 1){
			$hc_ant = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $cxAnt[1]['id']));
			
			$dql = $em->createQuery('SELECT
										he.id,					
										he.fecha,
										he.resultado,
										he.fecha_r,
										he.estado,
										e.nombre,
										e.codigo
									FROM
										HcBundle:HcExamen he
									JOIN
										he.examen e
									WHERE
										he.hc = :hc
									ORDER BY
										he.fecha DESC');
			
			$dql->setParameter('hc', $hc_ant->getId());			
			$exaPresentados = $dql->getResult();
			
		}else {
			$exaPresentados = null;
		}
		
		$dql = $em->createQuery('SELECT
				he.id,
				he.fecha,
				he.resultado,
				he.fecha_r,
				he.estado,
				e.nombre,
				e.codigo
				FROM
				HcBundle:HcExamen he
				JOIN
				he.examen e
				WHERE
				he.hc = :hc AND
				he.resultado != :resultado');
			
		$dql->setParameter('hc', $hc->getId());
		$dql->setParameter('resultado', 'NULL');
			
		$exaPresenPrimerVez = $dql->getResult();
		
		if(!$exaPresenPrimerVez){
			$exaPresenPrimerVez = null;		
		}
		
		$dql = $em->createQuery('SELECT
					he.fecha,
					he.fecha_r,
					he.resultado,
					he.id,
					he.estado,
					e.nombre,
					e.codigo
				FROM
					HcBundle:HcExamen he
				JOIN
					he.examen e
				WHERE
					he.estado = :estado AND
					he.hc = :id');
		
		$dql->setParameter('estado', 'P');
		$dql->setParameter('id', $hc->getId());
		
		$exa_solicitado = $dql->getResult();		
		
		$examenes = $usuario->getExamen(); // examenes del usuario
		
		$exaGeneral = $em->getRepository('HcBundle:Examen')->findAll();
		
		//-------------------------------------END EXAMENES---------------------------------------------------------
		
		//-------------------------------------HC Estetica----------------------------------------------------------
		
		$hcEstetica = $em->getRepository('HcBundle:HcEstetica')->findOneBy(array('hc' => $hc->getId()));

		//-------------------------------------End HC Estetica------------------------------------------------------
		
		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Modificar HC");
		
		
		$editform = $this->createForm(new HcType(), $hc);
		$editexform = $this->createForm(new HcExamenType());
		$medform = $this->createForm(new MedicamentoType());
	
		return $this->render('HcBundle:HistoriaClinica:edit.html.twig', array(
				'entity' => $hc,
				'medicamentos' => $medicamento,
				'perHcMe' => $hcMe,
				'examenes' => $examenes,
				'exaPresentados' => $exaPresentados,
				'exaPrePrimerVez' => $exaPresenPrimerVez,
				'list_ex' => $exaGeneral,
				'exa_solicitado' => $exa_solicitado,
				'cies' => $cie,
				'list_dx' => $list_dx,
				'perHcCie' => $hcCie,
				'signos' => $signos,
				'factura' => $factura,
				'paciente' => $paciente,
				'hcEstetica' =>	$hcEstetica,	
				'edit_form'   => $editform->createView(),
				'ex_form'   => $editexform->createView(),
				'med_form' => $medform->createView()
		));
	}
	
	
	public function updateAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		$hc = $em->getRepository('HcBundle:Hc')->find($id);
	
		if(!$hc)
		{
			throw $this->createNotFoundException('La historia clinica no existe.');
		}
			
		$editform = $this->createForm(new HcType(), $hc);
		$editexform = $this->createForm(new HcExamenType());
		$medform = $this->createForm(new MedicamentoType());
		
		$request = $this->getRequest();
		
		$editform->bindRequest($request);
	
		if ($editform->isValid()) {

			$factura = $hc->getFactura();
			$em->persist($hc);
			$em->flush();

			$factura->setEstado('I');
			$em->persist($factura);
			$em->flush();
				
			$this->get('session')->setFlash('info', 'La historia clinica ha sido modificada éxitosamente.');
			
			return $this->redirect($this->generateUrl('hc_edit', array('id' => $factura->getId())));
		}
		
		$factura = $hc->getFactura();
		$paciente = $factura->getPaciente();		
		
		$usuario = $this->get('security.context')->getToken()->getUser();
		
		
		$dql = $em->createQuery('SELECT m
				FROM
					HcBundle:Medicamento m
				WHERE
					m.usuario = :usuario
				ORDER BY
					m.principioActivo ASC');
		
		$dql->setParameter('usuario', $usuario->getId());
		$medicamento = $dql->getResult();
		
		$dql = $em->createQuery('SELECT hm.estado,hm.id,m.principioActivo,m.concentracion,m.dosisDia,m.tiempo,m.pos
				FROM HcBundle:HcMedicamento hm JOIN hm.medicamento m
				WHERE hm.hc = :id');
		$dql->setParameter('id', $hc->getId());
		$hcMe = $dql->getResult();
		//------------------------------------- END MEDICAMENTO-----------------------------------------------------
		
		//-------------------------------------DIAGNOSTICOS---------------------------------------------------------
		$dql = $em->createQuery('SELECT c FROM HcBundle:Cie c JOIN c.usuario u
				WHERE u.id = :id AND c.id NOT IN (SELECT C FROM HcBundle:Cie C JOIN C.hc h WHERE h.id = :hc)');
		$dql->setParameter('id', $usuario->getId());
		$dql->setParameter('hc', $hc->getId());
		$cie = $dql->getResult();
			
		$hcCie = $hc->getCie();
		
		$list_dx = $em->getRepository("HcBundle:Cie")->findAll();
		
		//-------------------------------------END DIAGNOSTICOS-----------------------------------------------------
		
		//-------------------------------------EXAMENES---------------------------------------------------------
		
		$ultimaCx = $em->createQuery('SELECT
										f.id,
										f.fecha
									FROM
										ParametrizarBundle:Factura f
									WHERE
										f.paciente = :paciente AND
										f.cargo = :cargo
									ORDER BY f.fecha DESC');
		
		$ultimaCx->setParameter('paciente', $paciente);
		$ultimaCx->setParameter('cargo', $cargo);
		
		$cxAnt = $ultimaCx->getArrayResult();
		
		if(count($cxAnt) > 1){
			$hc_ant = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $cxAnt[1]['id']));
			
			$dql = $em->createQuery('SELECT
										he.id,					
										he.fecha,
										he.resultado,
										he.fecha_r,
										he.estado,
										e.nombre
									FROM
										HcBundle:HcExamen he
									JOIN
										he.examen e
									WHERE
										he.hc = :hc');
			
			$dql->setParameter('hc', $hc_ant->getId());
			
			$exaPresentados = $dql->getResult();
		}else {
			$exaPresentados = null;
		}
		
		$dql = $em->createQuery('SELECT
				he.id,
				he.fecha,
				he.resultado,
				he.fecha_r,
				he.estado,
				e.nombre,
				e.codigo
				FROM
				HcBundle:HcExamen he
				JOIN
				he.examen e
				WHERE
				he.hc = :hc AND
				he.resultado != :resultado');
			
		$dql->setParameter('hc', $hc->getId());
		$dql->setParameter('resultado', 'NULL');
			
		$exaPresenPrimerVez = $dql->getResult();
		
		if(!$exaPresenPrimerVez){
			$exaPresenPrimerVez = null;
		}
		
		$exaGeneral = $em->getRepository('HcBundle:Examen')->findAll();
		//-------------------------------------END EXAMENES---------------------------------------------------------
		
		//-------------------------------------HC Estetica----------------------------------------------------------
		
		$hcEstetica = $em->getRepository('HcBundle:HcEstetica')->findOneBy(array('hc' => $hc->getId()));
		
		//-------------------------------------End HC Estetica------------------------------------------------------
		
		$examenes = $usuario->getExamen();
		
		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Modificar HC");
		
		return $this->render('HcBundle:HistoriaClinica:edit.html.twig', array(
				'entity' => $hc,
				'medicamentos' => $medicamento,
				'perHcMe' => $hcMe,
				'examenes' => $examenes,
				'exaPresentados' => $exaPresentados,
				'exaPrePrimerVez' => $exaPresenPrimerVez,
				'list_ex' => $exaGeneral,
				'cies' => $cie,
				'list_dx' => $list_dx,
				'perHcCie' => $hcCie,
				'factura' => $factura,
				'paciente' => $paciente,
				'hcEstetica' =>	$hcEstetica,
				'edit_form'   => $editform->createView(),
				'ex_form'   => $editexform->createView(),
				'med_form' => $medform->createView()
		));
	}
	
	/* buscar la historia clinica de un paciente con su respectivo id tal como la cedula 
	 * 
	 */
	public function searchAction()
	{
		$form   = $this->createForm(new searchType());	

		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Buscar");

			return $this->render('HcBundle:HistoriaClinica:search.html.twig', array(
					'form'   => $form->createView()
			));		
	}	
	
	public function listAction()
	{
		$request = $this->getRequest();
		$paginador = $this->get('ideup.simple_paginator');
		$paginador->setItemsPerPage(15);
		
		$form   = $this->createForm(new searchType());
		$form->bindRequest($request);
		
		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Listar");
		
		if($form->isValid())
		{
			$idP = $form->get('paciente')->getData();
			$tipoid = $form->get('tipoid')->getData();
			
			$em = $this->getDoctrine()->getEntityManager();
			
			$dql = $em->createQuery("SELECT p.id FROM ParametrizarBundle:Paciente p WHERE p.identificacion = :id");
			$dql->setParameter('id', $idP);
			$identifi = $dql->getResult();
			
			
			if($identifi)
			{
				$identifi = $dql->getSingleResult();				
				$paciente = $em->getRepository('ParametrizarBundle:Paciente')->find($identifi['id']);
					
				$dql = $em->createQuery("SELECT hc 
										 FROM HcBundle:Hc hc 
										 JOIN hc.factura f 
										 JOIN f.paciente p
										 WHERE 
											f.estado = 'I' AND  
											p.identificacion = :id AND 
											p.tipoId = :tipo 
										 ORDER BY 
											hc.fecha DESC");
				
				$dql->setParameter('id', $idP);
				$dql->setParameter('tipo', $tipoid);
				$HC = $paginador->paginate($dql->getResult())->getResult();
				
					
				if($HC)
				{						
					return $this->render('HcBundle:HistoriaClinica:list.html.twig', array(
							'factura' => $HC,
							'paciente' => $paciente,
							'form'   => $form->createView()
					));
				
				}else{
					$this->get('session')->setFlash('info','El paciente no tiene una historia clinica disponible.');
					return $this->redirect($this->generateUrl('hc_search'));
				}								
				
			}else{
				$this->get('session')->setFlash('error','Verifique que la cedula del paciente este correcta.');
				return $this->redirect($this->generateUrl('hc_search'));
			}
							
			
		}else{
			
			return $this->redirect($this->generateUrl('hc_search'));
		}
	}
	
	public function paginatorAction($id)
	{		
		$em = $this->getDoctrine()->getEntityManager();
		$paginador = $this->get('ideup.simple_paginator');
		$paginador->setItemsPerPage(15);
		
		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Listar");
		
				
		$form   = $this->createForm(new searchType());		
		$paciente = $em->getRepository('ParametrizarBundle:Paciente')->find($id);
			
			if(!$paciente)
			{
				throw $this->createNotFoundException('No hay pacientes disponibles.');
			}
				
			$dql = $em->createQuery("SELECT hc FROM HcBundle:Hc hc JOIN hc.factura f JOIN f.paciente p
					WHERE f.estado = 'I' AND  p.id = :id ORDER BY hc.fecha DESC");	
										
			$dql->setParameter('id', $paciente->getId());			
			$HC = $paginador->paginate($dql->getResult())->getResult();
			
			
								
			if(!$HC)
			{
				$this->get('session')->setFlash('warning','No hay informacion disponible');
		
				return $this->render('HcBundle:HistoriaClinica:list.html.twig', array(
						'factura' => $HC,
						'paciente' => $paciente,						
						'form'   => $form->createView()
				));		
			}
		
			return $this->render('HcBundle:HistoriaClinica:list.html.twig', array(
					'factura' => $HC,
					'paciente' => $paciente,					
					'form'   => $form->createView()
			));		
	}
	
		
	
	/* el id que llega a este contrlador proviene del bundle genda este id hace 
	 * referencia al id de la factura q a su ves esta relacionada con el paciente
	 * 
	 * para crear una nueva HC solo la puede hacer el medico.
	 */	
	public function newAction($id)
	{
		
		$em = $this->getDoctrine()->getEntityManager();				
		$factura = $em->getRepository('ParametrizarBundle:Factura')->find($id);
			
		$existe = $em->getRepository('HcBundle:Hc')->findByFactura($id);
		if(!$factura || $existe)
		{
			throw $this->createNotFoundException('La operacion realizada es incorrecta');
		}
		
		$entity  = new Hc();
		$entity->setFecha(new \DateTime('now'));
		$form    = $this->createForm(new HcType(), $entity);	

		$breadcrumbs = $this->get("white_october_breadcrumbs");
		$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
		$breadcrumbs->addItem("Nueva HC");
		
		return $this->render('HcBundle:HistoriaClinica:new.html.twig', array(								
				'factura' => $factura,
				'form'   => $form->createView()
		));		
	}
	
	public function saveAction($id)
	{		
		$entity  = new Hc();	
		$request = $this->getRequest();
		$form    = $this->createForm(new HcType(), $entity);
		
		$em = $this->getDoctrine()->getEntityManager();		
		$form->bindRequest($request);
		
		
						
			if(!$form->isValid())
			{

				$factura = $em->getRepository('ParametrizarBundle:Factura')->find($id);
				
				if(!$factura)
				{
					throw $this->createNotFoundException('No hay facturas disponibles.');
				}
				
				$entity->setFactura($factura);
				$em->persist($entity);
				$em->flush();
				
				//-------- se matiene el estado de la factura a N para que no pueda ser impresa
				$factura->setEstado('N');
				$em->persist($factura);
				$em->flush();
												
				$this->get('session')->setFlash('info',
						'¡Enhorabuena! La historia clinica se ha registrado correctamente ');
					
				return $this->redirect($this->generateUrl('hc_search'));
			}		

					
			$breadcrumbs = $this->get("white_october_breadcrumbs");
			$breadcrumbs->addItem("Inicio", $this->get("router")->generate("hc_list"));
			$breadcrumbs->addItem("Historia Clinica", $this->get("router")->generate("hc_list"));
			$breadcrumbs->addItem("Nueva HC");
			
		return $this->render('HcBundle:HistoriaClinica:new.html.twig', array(								
				'factura' => $factura,
				'form'   => $form->createView()
		));

	}	
	
	

	public function imprimirAction($factura)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$hc = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $factura));
		
		if(!$hc)
		{
			throw $this->createNotFoundException('La informacion de la historia no esta disponible.');
		}
		$factura = $hc->getFactura();		
		$cliente = $factura->getCliente();
		$sede = $factura->getSede();
		$paciente = $factura->getPaciente();
		$cargo = $factura->getCargo();
		
		//-----------------------consultas de usuario con su respectiva relacion -----------------------------

		$usuario = $this->get('security.context')->getToken()->getUser();
		
		//------------------------------------- MEDICAMENTO --------------------------------------------------------
		$medicamento = $em->getRepository('HcBundle:Medicamento')->findByUsuario($usuario->getId());
		
		$dql = $em->createQuery('SELECT 
									hm.id,
									hm.estado,
									m.principioActivo,
									m.presentacion,
									m.concentracion,
									m.dosisDia,
									m.tiempo,
									m.diasTratamiento,
									m.pos
								FROM 
									HcBundle:HcMedicamento hm 
								JOIN 
									hm.medicamento m
								WHERE 
									hm.hc = :id');
		
		$dql->setParameter('id', $hc->getId());
		$hcMe = $dql->getResult();
		//------------------------------------- END MEDICAMENTO-----------------------------------------------------
		
		//-------------------------------------DIAGNOSTICOS---------------------------------------------------------
		$dql = $em->createQuery('SELECT c FROM HcBundle:Cie c JOIN c.usuario u
				WHERE u.id = :id AND c.id NOT IN (SELECT C FROM HcBundle:Cie C JOIN C.hc h WHERE h.id = :hc)');
		$dql->setParameter('id', $usuario->getId());
		$dql->setParameter('hc', $hc->getId());
		$cie = $dql->getResult();
			
		$hcCie = $hc->getCie();
		//-------------------------------------END DIAGNOSTICOS-----------------------------------------------------
		
		//-------------------------------------EXAMENES---------------------------------------------------------
		
		$ultimaCx = $em->createQuery('SELECT
										f.id,
										f.fecha
									FROM
										ParametrizarBundle:Factura f
									WHERE
										f.paciente = :paciente AND
										f.cargo = :cargo
									ORDER BY f.fecha DESC');
		
		$ultimaCx->setParameter('paciente', $paciente);
		$ultimaCx->setParameter('cargo', $cargo);
		
		$cxAnt = $ultimaCx->getArrayResult();
		
		
		if(count($cxAnt) > 1){
			$hc_ant = $em->getRepository('HcBundle:Hc')->findOneBy(array('factura' => $cxAnt[1]['id']));
			
			$dql = $em->createQuery('SELECT
										he.id,					
										he.fecha,
										he.resultado,
										he.fecha_r,
										he.estado,
										e.nombre
									FROM
										HcBundle:HcExamen he
									JOIN
										he.examen e
									WHERE
										he.hc = :hc');
			
			$dql->setParameter('hc', $hc_ant->getId());
			
			$exa_presentado = $dql->getResult();
		}else {
			$exa_presentado = null;
		}
		
		$dql = $em->createQuery('SELECT
				he.id,
				he.fecha,
				he.resultado,
				he.fecha_r,
				he.estado,
				e.nombre,
				e.codigo
				FROM
				HcBundle:HcExamen he
				JOIN
				he.examen e
				WHERE
				he.hc = :hc AND
				he.resultado != :resultado');
			
		$dql->setParameter('hc', $hc->getId());
		$dql->setParameter('resultado', 'NULL');
			
		$exaPresenPrimerVez = $dql->getResult();
		
		if(!$exaPresenPrimerVez){
			$exaPresenPrimerVez = null;
		}
		
		$dql = $em->createQuery('SELECT 
									he.fecha, 
									he.fecha_r, 
									he.resultado,
									he.id,
									he.estado, 
									e.nombre, 
									e.codigo 
								FROM 
									HcBundle:HcExamen he 
								JOIN 
									he.examen e
								WHERE
									he.hc = :id AND
									he.estado = :estado');
		
		$dql->setParameter('id', $hc->getId());
		$dql->setParameter('estado', 'P');
		
		$exa_solicitado = $dql->getResult();
		
		$date = new \DateTime();
		
		$html = $this->renderView('HcBundle:HistoriaClinica:imprimir.pdf.twig', array(
				'entity' => $hc,
				'factura' => $factura,
				'paciente' => $paciente,
				'cliente'	=> $cliente,
				'sede'=>$sede,
				'medicamentos' => $medicamento,
				'perHcMe' => $hcMe,
				'exa_presentado' => $exa_presentado,
				'exaPrePrimerVez' => $exaPresenPrimerVez,
				'exa_solicitado' => $exa_solicitado,
				'cies' => $cie,
				'perHcCie' => $hcCie
		));
		
		$this->get('io_tcpdf')->dir = $sede->getDireccion();
		$this->get('io_tcpdf')->ciudad = $sede->getCiudad();
		$this->get('io_tcpdf')->tel = $sede->getTelefono();
		$this->get('io_tcpdf')->mov = $sede->getMovil();
		$this->get('io_tcpdf')->mail = $sede->getEmail();
		$this->get('io_tcpdf')->sede = $sede->getnombre();
		$this->get('io_tcpdf')->empresa = $sede->getEmpresa()->getNombre();
    	
    	return $this->get('io_tcpdf')->quick_pdf($html, 'informe.pdf', 'I');
	}
	
	function ajaxupdateAction($id)
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entity = $em->getRepository('InformeBundle:Mapa')->find($id);
		
		if ($request->getMethod() == 'POST')
		{
			
		}
		
		
	}
}
