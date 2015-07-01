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
     * @Assert\Choice(choices = {"N", "OB", "KG", "DE"}, message = "Selecciona una opción valida.")
     */
    private $nutricion;

    /**
     * @var integer $kgs
     *
     * @ORM\Column(name="kgs", type="integer")
     * @Assert\Min(limit = "0", message = "El valor ingresado no puede ser menor de {{ limit }}", invalidMessage = "El valor ingresado debe ser un número válido")
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
     * @var string $fitzpatrick
     *
     * @ORM\Column(name="fitzpatrick", type="string", length=8)
     * @Assert\Choice(choices = {"uno", "dos", "tres", "cuatro", "cinco", "seis"}, message = "Selecciona una opción valida.")
     */
    private $fitzpatrick;

    /**
     * @var string $infoFitzpatrick
     *
     * @ORM\Column(name="info_fitzpatrick", type="text")
     */
    private $infoFitzpatrick;
    
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
     * @var integer $pesogcorporal
     *
     * @ORM\Column(name="pesogcorporal", type="integer", nullable=true)
     */
    private $pesogcorporal;

    /**
     * @var integer $porcentajegv
     *
     * @ORM\Column(name="porcentajegv", type="integer", nullable=true)
     */
    private $porcentajegv;
    
    /**
     * @var integer $pm
     *
     * @ORM\Column(name="pm", type="integer", nullable=true)
     */
    private $pm;

    /**
     * @var integer $imc
     *
     * @ORM\Column(name="imc", type="integer", nullable=true)
     */
    private $imc;
    
    
    /**
     * @var integer $abs
     *
     * @ORM\Column(name="abs", type="integer", nullable=true)
     */
    private $abs;

    /**
     * @var integer $cintura
     *
     * @ORM\Column(name="cintura", type="integer", nullable=true)
     */
    private $cintura;
    
    
    /**
     * @var integer $ombligo
     *
     * @ORM\Column(name="ombligo", type="integer", nullable=true)
     */
    private $ombligo;

    /**
     * @var integer $abi
     *
     * @ORM\Column(name="abi", type="integer", nullable=true)
     */
    private $abi;
    
    /**
     * @var integer $piernas
     *
     * @ORM\Column(name="piernas", type="integer", nullable=true)
     */
    private $piernas;
    

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
     * Set fitzpatrick
     *
     * @param string $fitzpatrick
     */
    public function setFitzpatrick($fitzpatrick)
    {
        $this->fitzpatrick = $fitzpatrick;
    }

    /**
     * Get fitzpatrick
     *
     * @return string 
     */
    public function getFitzpatrick()
    {
        return $this->fitzpatrick;
    }

    /**
     * Set infoFitzpatrick
     *
     * @param string $infoFitzpatrick
     */
    public function setInfoFitzpatrick($infoFitzpatrick)
    {
        $this->infoFitzpatrick = $infoFitzpatrick;
    }

    /**
     * Get infoFitzpatrick
     *
     * @return string 
     */
    public function getInfoFitzpatrick()
    {
        return $this->infoFitzpatrick;
    }

    /**
     * Set peso
     *
     * @param text $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * Get peso
     *
     * @return text 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    
     /**
     * Set estatura
     *
     * @param text $estatura
     */
    public function setEstatura($estatura)
    {
        $this->estatura = $estatura;
    }

    /**
     * Get estatura
     *
     * @return text 
     */
    public function getEstatura()
    {
        return $this->estatura;
    }
    
    
    /**
     * Set pesogcorporal
     *
     * @param text $estatura
     */
    public function setPesogcorporal($pesogcorporal)
    {
        $this->pesogcorporal = $pesogcorporal;
    }

    /**
     * Get pesogcorporal
     *
     * @return text 
     */
    public function getPesogcorporal()
    {
        return $this->pesogcorporal;
    } 
    
    
    /**
     * Set porcentajegv
     *
     * @param text $porcentajegv
     */
    public function setPorcentajegv($porcentajegv)
    {
        $this->porcentajegv = $porcentajegv;
    }

    /**
     * Get porcentajegv
     *
     * @return text 
     */
    public function getPorcentajegv()
    {
        return $this->porcentajegv;
    } 
    
    
    /**
     * Set pm
     *
     * @param text $pm
     */
    public function setPm($pm)
    {
        $this->pm = $pm;
    }

    /**
     * Get pm
     *
     * @return text 
     */
    public function getPm()
    {
        return $this->pm;
    }
    
    
     /**
     * Set imc
     *
     * @param text $imc
     */
    public function setImc($imc)
    {
        $this->imc = $imc;
    }

    /**
     * Get imc
     *
     * @return text 
     */
    public function getImc()
    {
        return $this->imc;
    }
    
    /**
     * Set abs
     *
     * @param text $abs
     */
    public function setAbs($abs)
    {
        $this->abs = $abs;
    }

    /**
     * Get abs
     *
     * @return text 
     */
    public function getAbs()
    {
        return $this->abs;
    }
    
    
    /**
     * Set cintura
     *
     * @param text $cintura
     */
    public function setCintura($cintura)
    {
        $this->cintura = $cintura;
    }

    /**
     * Get cintura
     *
     * @return text 
     */
    public function getCintura()
    {
        return $this->cintura;
    }
    
    
    /**
     * Set ombligo
     *
     * @param text $ombligo
     */
    public function setOmbligo($ombligo)
    {
        $this->ombligo = $ombligo;
    }

    /**
     * Get ombligo
     *
     * @return text 
     */
    public function getOmbligo()
    {
        return $this->ombligo;
    }
    
    /**
     * Set abi
     *
     * @param text $abi
     */
    public function setAbi($abi)
    {
        $this->abi = $abi;
    }

    /**
     * Get abi
     *
     * @return text 
     */
    public function getAbi()
    {
        return $this->abi;
    }
    
    
    /**
     * Set piernas
     *
     * @param text $piernas
     */
    public function setPiernas($piernas)
    {
        $this->piernas = $piernas;
    }

    /**
     * Get piernas
     *
     * @return text 
     */
    public function getPiernas()
    {
        return $this->piernas;
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