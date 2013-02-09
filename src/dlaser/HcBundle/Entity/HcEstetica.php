<?php

namespace dlaser\HcBundle\Entity;

use Symfony\Tests\Component\Translation\String;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * dlaser\HcBundle\Entity\HcEstetica
 *
 * @ORM\Table(name="hc_estetica")
 * @ORM\Entity
 */
class HcEstetica implements \Serializable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $fecha
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var integer $edad_crono
     *
     * @ORM\Column(name="edad_crono", type="integer")
     * @Assert\Min(limit = "10", message = "El valor ingresado no puede ser menor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
     * @Assert\Max(limit = "150", message = "El valor ingresado no puede ser mayor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
     */
    private $edad_crono;

    /**
     * @var integer $edad_aparente
     *
     * @ORM\Column(name="edad_aparente", type="integer")
     * @Assert\Min(limit = "10", message = "El valor ingresado no puede ser menor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
     * @Assert\Max(limit = "150", message = "El valor ingresado no puede ser mayor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")     
     */
    private $edad_aparente;

    /**
     * @var string $piel_color
     *
     * @ORM\Column(name="piel_color", type="string", length=2)
     * @Assert\Choice(choices = {"N", "P", "R"}, message = "Selecciona una opción valida.")
     */
    private $piel_color;

    /**
     * @var string $piel_cutis
     *
     * @ORM\Column(name="piel_cutis", type="string", length=2)
     * @Assert\Choice(choices = {"S", "G", "M"}, message = "Selecciona una opción valida.")
     */
    private $piel_cutis;

    /**
     * @var string $piel_tacto
     *
     * @ORM\Column(name="piel_tacto", type="string", length=2)
     * @Assert\Choice(choices = {"LF", "GR"}, message = "Selecciona una opción valida.")
     */
    private $piel_tacto;

    /**
     * @var string $op
     *
     * @ORM\Column(name="op", type="string", length=80)
     */
    private $op;

    /**
     * @var string $pigmentacion
     *
     * @ORM\Column(name="pigmentacion", type="string", length=80)
     */
    private $pigmentacion;

    /**
     * @var string $arrugas
     *
     * @ORM\Column(name="arrugas", type="string", length=90)
     */
    private $arrugas;

    /**
     * @var string $dentadura
     *
     * @ORM\Column(name="dentadura", type="string", length=2)
     * @Assert\Choice(choices = {"B", "R", "M", "P"}, message = "Selecciona una opción valida.")
     */
    private $dentadura;

    /**
     * @var string $flacidez
     *
     * @ORM\Column(name="flacidez", type="string", length=80)
     */
    private $flacidez;

    /**
     * @var string $parpado
     *
     * @ORM\Column(name="parpado", type="string", length=80)
     */
    private $parpado;

    /**
     * @var string $nutricion
     *
     * @ORM\Column(name="nutricion", type="string", length=2)
     * @Assert\Choice(choices = {"OB", "KG", "DE"}, message = "Selecciona una opción valida.")
     */
    private $nutricion;

    /**
     * @var integer $kgs
     *
     * @ORM\Column(name="kgs", type="integer")
     * @Assert\Min(limit = "001", message = "El valor ingresado no puede ser menor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
     * @Assert\Max(limit = "150", message = "El valor ingresado no puede ser mayor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
     */
    private $kgs;

    /**
     * @var text $medicacion
     *
     * @ORM\Column(name="medicacion", type="text")
     */
    private $medicacion;

    /**
     * @var string $lesiones_cut
     *
     * @ORM\Column(name="lesiones_cut", type="text")
     */
    private $lesiones_cut;
    
    /**
     * @var string $lipodistrofia
     *
     * @ORM\Column(name="lipodistrofia", type="text")
     */
    private $lipodistrofia;
    
    /**
     * @var string $tatuaje
     *
     * @ORM\Column(name="tatuaje", type="text")
     */
    private $tatuaje;
    
    /**
     * @var string $cictrizes
     *
     * @ORM\Column(name="cicatrizes", type="text")
     */
    private $cicatrizes;
    
    /**
     * @var string $estrias
     *
     * @ORM\Column(name="estrias",type="text")
     */
    private $estrias;

    /**
     * @var string $dx_cut
     *
     * @ORM\Column(name="dx_cut", type="string", length=160)
     */
    private $dx_cut;

    /**
     * @var string $e_uno
     *
     * @ORM\Column(name="e_uno", type="string", length=160)
     */
    private $e_uno;

    /**
     * @var string $e_dos
     *
     * @ORM\Column(name="e_dos", type="string", length=160)
     */
    private $e_dos;

    /**
     * @var string $e_tres
     *
     * @ORM\Column(name="e_tres", type="string", length=160)
     */
    private $e_tres;

    /**
     * @var string $e_cuatro
     *
     * @ORM\Column(name="e_cuatro", type="string", length=160)
     */
    private $e_cuatro;

    /**
     * @var string $e_cinco
     *
     * @ORM\Column(name="e_cinco", type="string", length=160)
     */
    private $e_cinco;

    /**
     * @var string $e_seis
     *
     * @ORM\Column(name="e_seis", type="string", length=160)
     */
    private $e_seis;

    /**
     * @var text $grafico
     *
     * @ORM\Column(name="grafico", type="text")
     */
    private $grafico;

    /**
     * @var Hc
     *
     * @ORM\OneToOne(targetEntity="dlaser\HcBundle\Entity\Hc", inversedBy="hcEstetica")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="hc_id", referencedColumnName="id" )
     * })
     */
    private $hc;
    
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
     * Set edad_crono
     *
     * @param integer $edadCrono
     */
    public function setEdadCrono($edadCrono)
    {
        $this->edad_crono = $edadCrono;
    }

    /**
     * Get edad_crono
     *
     * @return integer 
     */
    public function getEdadCrono()
    {
        return $this->edad_crono;
    }

    /**
     * Set edad_aparente
     *
     * @param integer $edadAparente
     */
    public function setEdadAparente($edadAparente)
    {
        $this->edad_aparente = $edadAparente;
    }

    /**
     * Get edad_aparente
     *
     * @return integer 
     */
    public function getEdadAparente()
    {
        return $this->edad_aparente;
    }

    /**
     * Set piel_color
     *
     * @param string $pielColor
     */
    public function setPielColor($pielColor)
    {
        $this->piel_color = $pielColor;
    }

    /**
     * Get piel_color
     *
     * @return string 
     */
    public function getPielColor()
    {
        return $this->piel_color;
    }

    /**
     * Set piel_cutis
     *
     * @param string $pielCutis
     */
    public function setPielCutis($pielCutis)
    {
        $this->piel_cutis = $pielCutis;
    }

    /**
     * Get piel_cutis
     *
     * @return string 
     */
    public function getPielCutis()
    {
        return $this->piel_cutis;
    }

    /**
     * Set piel_tacto
     *
     * @param string $pielTacto
     */
    public function setPielTacto($pielTacto)
    {
        $this->piel_tacto = $pielTacto;
    }

    /**
     * Get piel_tacto
     *
     * @return string 
     */
    public function getPielTacto()
    {
        return $this->piel_tacto;
    }

    /**
     * Set op
     *
     * @param string $op
     */
    public function setOp($op)
    {
        $this->op = $op;
    }

    /**
     * Get op
     *
     * @return string 
     */
    public function getOp()
    {
        return $this->op;
    }

    /**
     * Set pigmentacion
     *
     * @param string $pigmentacion
     */
    public function setPigmentacion($pigmentacion)
    {
        $this->pigmentacion = $pigmentacion;
    }

    /**
     * Get pigmentacion
     *
     * @return string 
     */
    public function getPigmentacion()
    {
        return $this->pigmentacion;
    }

    /**
     * Set arrugas
     *
     * @param string $arrugas
     */
    public function setArrugas($arrugas)
    {
        $this->arrugas = $arrugas;
    }

    /**
     * Get arrugas
     *
     * @return string 
     */
    public function getArrugas()
    {
        return $this->arrugas;
    }

    /**
     * Set dentadura
     *
     * @param string $dentadura
     */
    public function setDentadura($dentadura)
    {
        $this->dentadura = $dentadura;
    }

    /**
     * Get dentadura
     *
     * @return string 
     */
    public function getDentadura()
    {
        return $this->dentadura;
    }

    /**
     * Set flacidez
     *
     * @param string $flacidez
     */
    public function setFlacidez($flacidez)
    {
        $this->flacidez = $flacidez;
    }

    /**
     * Get flacidez
     *
     * @return string 
     */
    public function getFlacidez()
    {
        return $this->flacidez;
    }

    /**
     * Set parpado
     *
     * @param string $parpado
     */
    public function setParpado($parpado)
    {
        $this->parpado = $parpado;
    }

    /**
     * Get parpado
     *
     * @return string 
     */
    public function getParpado()
    {
        return $this->parpado;
    }

    /**
     * Set nutricion
     *
     * @param string $nutricion
     */
    public function setNutricion($nutricion)
    {
        $this->nutricion = $nutricion;
    }

    /**
     * Get nutricion
     *
     * @return string 
     */
    public function getNutricion()
    {
        return $this->nutricion;
    }

    /**
     * Set kgs
     *
     * @param integer $kgs
     */
    public function setKgs($kgs)
    {
        $this->kgs = $kgs;
    }

    /**
     * Get kgs
     *
     * @return integer 
     */
    public function getKgs()
    {
        return $this->kgs;
    }

    /**
     * Set medicacion
     *
     * @param text $medicacion
     */
    public function setMedicacion($medicacion)
    {
        $this->medicacion = $medicacion;
    }

    /**
     * Get medicacion
     *
     * @return text 
     */
    public function getMedicacion()
    {
        return $this->medicacion;
    }

    /**
     * Set lesiones_cut
     *
     * @param string $lesionesCut
     */
    public function setLesionesCut($lesionesCut)
    {
        $this->lesiones_cut = $lesionesCut;
    }

    /**
     * Get lesiones_cut
     *
     * @return string 
     */
    public function getLesionesCut()
    {
        return $this->lesiones_cut;
    }
    
    /**
     * Set lipodistrofia
     *
     * @param text $lipodistrofia
     */
    public function setLipodistrofia($lipodistrofia)
    {
    	$this->lipodistrofia = $lipodistrofia;
    }
    
    /**
     * Get lipodistrofia
     *
     * @return text
     */
    public function getLipodistrofia()
    {
    	return $this->lipodistrofia;
    }
    
    /**
     * Set tatuaje
     *
     * @param text $tatuaje
     */
    public function setTatuaje($tatuaje)
    {
    	$this->tatuaje = $tatuaje;
    }
    
    /**
     * Get tatuaje
     *
     * @return text
     */
    public function getTatuaje()
    {
    	return $this->tatuaje;
    }
    
    /**
     * Set cicatrizes
     *
     * @param text $cicatrizes
     */
    public function setCicatrizes($cicatrizes)
    {
    	$this->cicatrizes = $cicatrizes;
    }
    
    /**
     * Get cicatrizes
     *
     * @return text
     */
    public function getCicatrizes()
    {
    	return $this->cicatrizes;
    }
    
    
    /**
     * Set estrias
     *
     * @param text $estrias
     */
    public function setEstrias($estrias)
    {
    	$this->estrias = $estrias;
    }
    
    /**
     * Get estrias
     *
     * @return text
     */
    public function getEstrias()
    {
    	return $this->estrias;
    }
    

    /**
     * Set dx_cut
     *
     * @param string $dxCut
     */
    public function setDxCut($dxCut)
    {
        $this->dx_cut = $dxCut;
    }

    /**
     * Get dx_cut
     *
     * @return string 
     */
    public function getDxCut()
    {
        return $this->dx_cut;
    }

    /**
     * Set e_uno
     *
     * @param string $eUno
     */
    public function setEUno($eUno)
    {
        $this->e_uno = $eUno;
    }

    /**
     * Get e_uno
     *
     * @return string 
     */
    public function getEUno()
    {
        return $this->e_uno;
    }

    /**
     * Set e_dos
     *
     * @param string $eDos
     */
    public function setEDos($eDos)
    {
        $this->e_dos = $eDos;
    }

    /**
     * Get e_dos
     *
     * @return string 
     */
    public function getEDos()
    {
        return $this->e_dos;
    }

    /**
     * Set e_tres
     *
     * @param string $eTres
     */
    public function setETres($eTres)
    {
        $this->e_tres = $eTres;
    }

    /**
     * Get e_tres
     *
     * @return string 
     */
    public function getETres()
    {
        return $this->e_tres;
    }

    /**
     * Set e_cuatro
     *
     * @param string $eCuatro
     */
    public function setECuatro($eCuatro)
    {
        $this->e_cuatro = $eCuatro;
    }

    /**
     * Get e_cuatro
     *
     * @return string 
     */
    public function getECuatro()
    {
        return $this->e_cuatro;
    }

    /**
     * Set e_cinco
     *
     * @param string $eCinco
     */
    public function setECinco($eCinco)
    {
        $this->e_cinco = $eCinco;
    }

    /**
     * Get e_cinco
     *
     * @return string 
     */
    public function getECinco()
    {
        return $this->e_cinco;
    }

    /**
     * Set e_seis
     *
     * @param string $eSeis
     */
    public function setESeis($eSeis)
    {
        $this->e_seis = $eSeis;
    }

    /**
     * Get e_seis
     *
     * @return string 
     */
    public function getESeis()
    {
        return $this->e_seis;
    }

    /**
     * Set grafico
     *
     * @param text $grafico
     */
    public function setGrafico($grafico)
    {
        $this->grafico = $grafico;
    }

    /**
     * Get grafico
     *
     * @return text 
     */
    public function getGrafico()
    {
        return $this->grafico;
    }

     /**
     * Set hc
     *
     * @param dlaser\HcBundle\Entity\Hc $hc
     */
    public function setHc(\dlaser\HcBundle\Entity\Hc $hc)
    {
        $this->hc = $hc;
    }

    /**
     * Get hc
     *
     * @return dlaser\HcBundle\Entity\Hc 
     */
    public function getHc()
    {
        return $this->hc;
    }
    
    /**
     * Set files
     *
     * @param dlaser\HcBundle\Entity\Files $files
     */
    
    
    public function serialize()
    {
    	$this->op = serialize($this->op);
    	$this->pigmentacion = serialize($this->pigmentacion);
    	$this->arrugas = serialize($this->arrugas);    	
    	$this->flacidez = serialize($this->flacidez);
    	$this->parpado = serialize($this->parpado);
    	$this->lesiones_cut = serialize($this->lesiones_cut);    	
    	$this->lipodistrofia = serialize($this->lipodistrofia);
    	$this->tatuaje = serialize($this->tatuaje);
    	$this->cicatrizes = serialize($this->cicatrizes);
    	$this->estrias = serialize($this->estrias);
    }
    
    public function unserialize($serialize)
    {
    	$this->op = unserialize($serialize['op']);
    	$this->pigmentacion = unserialize($serialize['pigmentacion']);
    	$this->arrugas = unserialize($serialize['arrugas']);    	
    	$this->flacidez = unserialize($serialize['flacidez']);
    	$this->parpado = unserialize($serialize['parpado']);
    	$this->lesiones_cut = unserialize($serialize['lesiones_cut']);    	
    	$this->lipodistrofia = unserialize($serialize["lipodistrofia"]);
    	$this->tatuaje = unserialize($serialize["tatuaje"]);
    	$this->cicatrizes = unserialize($serialize["cicatrizes"]);
    	$this->estrias = unserialize($serialize["estrias"]);
    }
    
    
    
}