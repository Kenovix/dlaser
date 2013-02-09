<?php
namespace dlaser\HcBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImpresosController extends Controller{
	
	function impresionAction($hc){
		
		/*
		 * CALUSULAS PARA INGRESAS A LA SECCION DE LASER............=> CISL
		 * CONSENTIMIENTO INFORMADO HILOS DE LEVANTAMIENTO GLUTEO...=> CIHLG
		 * CONSENTIMIENTO INFORMADO LASER...........................=> CIL
		 * CONSENTIMIENTO INFORMADO LASERLIPOLISIS..................=> CILL
		 * encuesta satisfaccion....................................=> ES x
		 * FINALIZACION TRATAMIENTO LASER...........................=> FTL
		 * HORA DE LLEGADA..........................................=> TH x
		 * PAGARE...................................................=> P 
		 * PROGRAMA DE NUTRICION....................................=> PN
		 * RECOMENDACIONES NUEVO....................................=> RN
		 * SESIONES LASER FIRMAS....................................=> SLF -
		 */
		$em = $this->getDoctrine()->getEntityManager();
		$hc = $em->getRepository('HcBundle:Hc')->find($hc);
		$pagina = null;
		$option = 'PN';
		
		if($hc){
			
			$sede = $hc->getFactura()->getSede();
			$paciente = $hc->getFactura()->getPaciente();
			$user = $this->get('security.context')->getToken()->getUser();			
			
			$fecha = new \DateTime('now');
			
			switch ($option){
				case 'CISL':					 	
					 	$pagina = 'clausulaISL.pdf.twig';
					break;
				case 'CIHLG':
						$pagina = 'consentimientoIHLG.pdf.twig';
					break;
				case 'CIL':
						$pagina = 'consentimientoIL.pdf.twig';
					break;
				case 'CILL':
					$pagina = 'consentimientoILL.pdf.twig';
					break;
				case 'ES':
						$pagina = 'encuestaS.pdf.twig';
					break;
				case 'FTL':
						$pagina = 'finalizacionTL.pdf.twig';
					break;
				case 'TH':
						$pagina = 'horaLegada.pdf.twig';
					break;
				case 'P':
						$pagina = 'pagare.pdf.twig';
					break;
				case 'PN':
						$pagina = 'programaN.pdf.twig';
					break;
				case 'RN':
						$pagina = 'recomendacionesN.pdf.twig';
					break;
				case 'SLF':
						$pagina = 'sesionesLF.pdf.twig';
					break;
				default:				
					$this->get('session')->setFlash('error', 'No hay informacion disponible para su consulta verifique que los dato sean correctos.');						
					return $this->redirect($this->generateUrl('hc_search'));
			}
			
			$html = $this->render('HcBundle:Impresos:'.$pagina, array(
					'paciente' => $paciente,
					'usuario' => $user,
					'fecha' => $fecha,
			));
			
			$this->get('io_tcpdf')->dir = $sede->getDireccion();
			$this->get('io_tcpdf')->ciudad = $sede->getCiudad();
			$this->get('io_tcpdf')->tel = $sede->getTelefono();
			$this->get('io_tcpdf')->mov = $sede->getMovil();
			$this->get('io_tcpdf')->mail = $sede->getEmail();
			$this->get('io_tcpdf')->sede = $sede->getnombre();
			$this->get('io_tcpdf')->empresa = $sede->getEmpresa()->getNombre();
			
			return $this->get('io_tcpdf')->quick_pdf($html, 'impresos.pdf');
			
		}else{
			$this->get('session')->setFlash('error', 'La historia clinica no existe.');				
			return $this->redirect($this->generateUrl('hc_search'));
		}		
	}
	
	function listAction($hc){
		
		$em = $this->getDoctrine()->getEntityManager();
		$hc = $em->getRepository('HcBundle:Hc')->find($hc);
		
		if($hc){
				
			$fecha = new \DateTime('now');
			
			$sede = $hc->getFactura()->getSede();
			$paciente = $hc->getFactura()->getPaciente();
			$user = $this->get('security.context')->getToken()->getUser();
		
			return $this->render('HcBundle:Impresos:list.html.twig', array(
						'paciente' => $paciente,
						'usuario' => $user,
						'fecha' => $fecha,
				));
		}else{
			$this->get('session')->setFlash('error', 'La historia clinica no existe.');
			return $this->redirect($this->generateUrl('hc_search'));
		}
	}
}