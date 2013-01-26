<?php

namespace dlaser\HcBundle\Entity;

use Symfony\Tests\Component\Translation\String;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * dlaser\HcBundle\Entity\Hc
 *
 * @ORM\Table(name="hc")
 * @ORM\Entity
 */
class Hc
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var datetime $fecha
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var integer $sistole
     *
     * @ORM\Column(name="sistole", type="integer", nullable=true)
     */
    private $sistole;

    /**
     * @var integer $diastole
     *
     * @ORM\Column(name="diastole", type="integer", nullable=true)
     */
    private $diastole;

    /**
     * @var integer $fC
     *
     * @ORM\Column(name="f_c", type="integer", nullable=true)
     */
    private $fC;

    /**
     * @var integer $fR
     *
     * @ORM\Column(name="f_r", type="integer", nullable=true)
     */
    private $fR;

    /**
     * @var integer $peso
     *
     * @ORM\Column(name="peso", type="integer", nullable=true)
     */
    private $peso;

    /**
     * @var integer $estatura
     *
     * @ORM\Column(name="estatura", type="integer", nullable=true)
     */
    private $estatura;

    /**
     * @var string $hta
     *
     * @ORM\Column(name="hta", type="string", length=2, nullable=true)
     */
    private $hta;

    /**
     * @var string $diabetes
     *
     * @ORM\Column(name="diabetes", type="string", length=2, nullable=true)
     */
    private $diabetes;

    /**
     * @var string $dislipidemia
     *
     * @ORM\Column(name="dislipidemia", type="string", length=2, nullable=true)
     */
    private $dislipidemia;

    /**
     * @var string $tabaquismo
     *
     * @ORM\Column(name="tabaquismo", type="string", length=2, nullable=true)
     */
    private $tabaquismo;

    /**
     * @var string $obesidad
     *
     * @ORM\Column(name="obesidad", type="string", length=2, nullable=true)
     */
    private $obesidad;

    /**
     * @var string $anteFamiliar
     *
     * @ORM\Column(name="ante_familiar", type="string", length=2, nullable=true)
     */
    private $anteFamiliar;

    /**
     * @var string $sedentarismo
     *
     * @ORM\Column(name="sedentarismo", type="string", length=2, nullable=true)
     */
    private $sedentarismo;

    /**
     * @var text $enfermedad
     *
     * @ORM\Column(name="enfermedad", type="text", nullable=true)
     */
    private $enfermedad;

    /**
     * @var text $revCardiovascular
     *
     * @ORM\Column(name="rev_cardiovascular", type="text", nullable=true)
     */
    private $revCardiovascular;

    /**
     * @var text $exaFisico
     *
     * @ORM\Column(name="exa_fisico", type="text", nullable=true)
     */
    private $exaFisico;
    
    /**
     * @var text $exaPresentado
     *
     * @ORM\Column(name="exa_presentado", type="text", nullable=true)
     */
    private $exaPresentado;
    
    /**
     * @var text $notaExaSoli
     *
     * @ORM\Column(name="nota_exa_soli", type="text", nullable=true)
     */
    private $notaExaSoli;

    /**
     * @var string $interconsulta
     *
     * @ORM\Column(name="interconsulta", type="text", nullable=true)
     */
    private $interconsulta;

    /**
     * @var text $motivoInter
     *
     * @ORM\Column(name="motivo_inter", type="text", nullable=true)
     */
    private $motivoInter;
    
    /**
     * @var text $dxPresunto
     *
     * @ORM\Column(name="dx_presunto", type="text", nullable=true)
     */
    private $dxPresunto;

    /**
     * @var text $manejo
     *
     * @ORM\Column(name="manejo", type="text", nullable=true)
     */
    private $manejo;

    /**
     * @var string $control
     *
     * @ORM\Column(name="control", type="string", length=255, nullable=true)
     */
    private $control;

    /**
     * @var boolean $ctrlPrioritario
     *
     * @ORM\Column(name="ctrl_prioritario", type="boolean", nullable=true)
     */
    private $ctrlPrioritario;

    /**
     * @var integer $postfecha
     *
     * @ORM\Column(name="postfecha", type="integer", nullable=true)
     */
    private $postfecha;

    /**
     * @var Cie
     *
     * @ORM\ManyToMany(targetEntity="Cie", inversedBy="hc")
     * @ORM\JoinTable(name="cie_hc",
     *   joinColumns={
     *     @ORM\JoinColumn(name="hc_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="cie_id", referencedColumnName="id")
     *   }
     * )
     */
    private $cie;
    
    /**
     * @var Factura
     *
     * @ORM\ManyToOne(targetEntity="dlaser\ParametrizarBundle\Entity\Factura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="factura_id", referencedColumnName="id")
     * })
     */
    private $factura;
    
    /**
     * @ORM\OneToOne(targetEntity="dlaser\HcBundle\Entity\HcEstetica", mappedBy="hc")
     */
    private $hcEstetica;
    
    

    public function __construct()
    {
        $this->cie = new \Doctrine\Common\Collections\ArrayCollection();        
    }    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fecha
     *
     * @param datetime $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * Get fecha
     *
     * @return datetime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set sistole
     *
     * @param integer $sistole
     */
    public function setSistole($sistole)
    {
        $this->sistole = $sistole;
    }

    /**
     * Get sistole
     *
     * @return integer 
     */
    public function getSistole()
    {
        return $this->sistole;
    }

    /**
     * Set diastole
     *
     * @param integer $diastole
     */
    public function setDiastole($diastole)
    {
        $this->diastole = $diastole;
    }

    /**
     * Get diastole
     *
     * @return integer 
     */
    public function getDiastole()
    {
        return $this->diastole;
    }

    /**
     * Set fC
     *
     * @param integer $fC
     */
    public function setFC($fC)
    {
        $this->fC = $fC;
    }

    /**
     * Get fC
     *
     * @return integer 
     */
    public function getFC()
    {
        return $this->fC;
    }

    /**
     * Set fR
     *
     * @param integer $fR
     */
    public function setFR($fR)
    {
        $this->fR = $fR;
    }

    /**
     * Get fR
     *
     * @return integer 
     */
    public function getFR()
    {
        return $this->fR;
    }

    /**
     * Set peso
     *
     * @param integer $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * Get peso
     *
     * @return integer 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Set estatura
     *
     * @param integer $estatura
     */
    public function setEstatura($estatura)
    {
        $this->estatura = $estatura;
    }

    /**
     * Get estatura
     *
     * @return integer 
     */
    public function getEstatura()
    {
        return $this->estatura;
    }

    /**
     * Set hta
     *
     * @param string $hta
     */
    public function setHta($hta)
    {
        $this->hta = $hta;
    }

    /**
     * Get hta
     *
     * @return string 
     */
    public function getHta()
    {
        return $this->hta;
    }

    /**
     * Set diabetes
     *
     * @param string $diabetes
     */
    public function setDiabetes($diabetes)
    {
        $this->diabetes = $diabetes;
    }

    /**
     * Get diabetes
     *
     * @return string 
     */
    public function getDiabetes()
    {
        return $this->diabetes;
    }

    /**
     * Set dislipidemia
     *
     * @param string $dislipidemia
     */
    public function setDislipidemia($dislipidemia)
    {
        $this->dislipidemia = $dislipidemia;
    }

    /**
     * Get dislipidemia
     *
     * @return string 
     */
    public function getDislipidemia()
    {
        return $this->dislipidemia;
    }

    /**
     * Set tabaquismo
     *
     * @param string $tabaquismo
     */
    public function setTabaquismo($tabaquismo)
    {
        $this->tabaquismo = $tabaquismo;
    }

    /**
     * Get tabaquismo
     *
     * @return string 
     */
    public function getTabaquismo()
    {
        return $this->tabaquismo;
    }

    /**
     * Set obesidad
     *
     * @param string $obesidad
     */
    public function setObesidad($obesidad)
    {
        $this->obesidad = $obesidad;
    }

    /**
     * Get obesidad
     *
     * @return string 
     */
    public function getObesidad()
    {
        return $this->obesidad;
    }

    /**
     * Set anteFamiliar
     *
     * @param string $anteFamiliar
     */
    public function setAnteFamiliar($anteFamiliar)
    {
        $this->anteFamiliar = $anteFamiliar;
    }

    /**
     * Get anteFamiliar
     *
     * @return string 
     */
    public function getAnteFamiliar()
    {
        return $this->anteFamiliar;
    }

    /**
     * Set sedentarismo
     *
     * @param string $sedentarismo
     */
    public function setSedentarismo($sedentarismo)
    {
        $this->sedentarismo = $sedentarismo;
    }

    /**
     * Get sedentarismo
     *
     * @return string 
     */
    public function getSedentarismo()
    {
        return $this->sedentarismo;
    }

    /**
     * Set enfermedad
     *
     * @param text $enfermedad
     */
    public function setEnfermedad($enfermedad)
    {
        $this->enfermedad = $enfermedad;
    }

    /**
     * Get enfermedad
     *
     * @return text 
     */
    public function getEnfermedad()
    {
        return $this->enfermedad;
    }

    /**
     * Set revCardiovascular
     *
     * @param text $revCardiovascular
     */
    public function setRevCardiovascular($revCardiovascular)
    {
        $this->revCardiovascular = $revCardiovascular;
    }

    /**
     * Get revCardiovascular
     *
     * @return text 
     */
    public function getRevCardiovascular()
    {
        return $this->revCardiovascular;
    }

    /**
     * Set exaFisico
     *
     * @param text $exaFisico
     */
    public function setExaFisico($exaFisico)
    {
        $this->exaFisico = $exaFisico;
    }

    /**
     * Get exaFisico
     *
     * @return text 
     */
    public function getExaFisico()
    {
        return $this->exaFisico;
    }
    
    /**
     * Set exaPresentado
     *
     * @param text $exaPresentado
     */
    public function setExaPresentado($exaPresentado)
    {
    	$this->exaPresentado = $exaPresentado;
    }
    
    /**
     * Get exaPresentado
     *
     * @return text
     */
    public function getExaPresentado()
    {
    	return $this->exaPresentado;
    }
    
    /**
     * Set notaExaSoli
     *
     * @param text $notaExaSoli
     */
    public function setNotaExaSoli($notaExaSoli)
    {
    	$this->notaExaSoli = $notaExaSoli;
    }
    
    /**
     * Get notaExaSoli
     *
     * @return text
     */
    public function getNotaExaSoli()
    {
    	return $this->notaExaSoli;
    }

    /**
     * Set interconsulta
     *
     * @param string $interconsulta
     */
    public function setInterconsulta($interconsulta)
    {
        $this->interconsulta = $interconsulta;
    }

    /**
     * Get interconsulta
     *
     * @return string 
     */
    public function getInterconsulta()
    {
        return $this->interconsulta;
    }

    /**
     * Set motivoInter
     *
     * @param text $motivoInter
     */
    public function setMotivoInter($motivoInter)
    {
        $this->motivoInter = $motivoInter;
    }

    /**
     * Get motivoInter
     *
     * @return text 
     */
    public function getMotivoInter()
    {
        return $this->motivoInter;
    }
    
    /**
     * Set dxPresunto
     *
     * @param text $dxPresunto
     */
    public function setDxPresunto($dxPresunto)
    {
    	$this->dxPresunto = $dxPresunto;
    }
    
    /**
     * Get dxPresunto
     *
     * @return text
     */
    public function getDxPresunto()
    {
    	return $this->dxPresunto;
    }

    /**
     * Set manejo
     *
     * @param text $manejo
     */
    public function setManejo($manejo)
    {
        $this->manejo = $manejo;
    }

    /**
     * Get manejo
     *
     * @return text 
     */
    public function getManejo()
    {
        return $this->manejo;
    }

    /**
     * Set control
     *
     * @param integer $control
     */
    public function setControl($control)
    {
        $this->control = $control;
    }

    /**
     * Get control
     *
     * @return integer 
     */
    public function getControl()
    {
        return $this->control;
    }

    /**
     * Set ctrlPrioritario
     *
     * @param boolean $ctrlPrioritario
     */
    public function setCtrlPrioritario($ctrlPrioritario)
    {
        $this->ctrlPrioritario = $ctrlPrioritario;
    }

    /**
     * Get ctrlPrioritario
     *
     * @return boolean 
     */
    public function getCtrlPrioritario()
    {
        return $this->ctrlPrioritario;
    }

    /**
     * Set postfecha
     *
     * @param integer $postfecha
     */
    public function setPostfecha($postfecha)
    {
        $this->postfecha = $postfecha;
    }

    /**
     * Get postfecha
     *
     * @return integer 
     */
    public function getPostfecha()
    {
        return $this->postfecha;
    }

    /**
     * Add cie
     *
     * @param dlaser\HcBundle\Entity\Cie $cie
     */
    public function addCie(\dlaser\HcBundle\Entity\Cie $cie)
    {
        if (!$this->hasCie($cie)) {
        	$this->cie[] = $cie;
        	return true;
        }
        return false;
    }
    public function hasCie(\dlaser\HcBundle\Entity\Cie $cie)
    {
    	foreach ($this->cie as $value) {
    		if ($value->getId() == $cie->getId()) {
    			return true;
    		}
    	}
    	return false;
    }
    /**
     * Get cie
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCie()
    {
        return $this->cie;
    }
    /**
     * Set factura
     *
     * @param dlaser\ParametrizarBundle\Entity\Factura $factura
     */
    public function setFactura(\dlaser\ParametrizarBundle\Entity\Factura $factura)
    {
        $this->factura = $factura;
    }

    /**
     * Get factura
     *
     * @return dlaser\ParametrizarBundle\Entity\Factura 
     */
    public function getFactura()
    {
        return $this->factura;
    }
    
    
    /**
     * Set hcEstetica
     *
     * @param dlaser\HcBundle\Entity\HcEstetica $hcEstetica
     */
    
    public function setHcEstetica(\dlaser\HcBundle\Entity\HcEstetica $hcEstetica)
    {
    	$this->hcEstetica = $hcEstetica;
    }
    
    /**
     * Get hcEstetica
     *
     * @return dlaser\HcBundle\Entity\HcEstetica
     */
    public function getHcEstetica()
    {
    	return $this->hcEstetica;
    }
}