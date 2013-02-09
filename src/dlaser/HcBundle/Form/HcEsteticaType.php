<?php
namespace dlaser\HcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HcEsteticaType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('fecha',   			'date',array('read_only'=>true))
		->add('edad_crono', 			'integer', array('label' => 'Edad Crono','attr' => array('autofocus'=>'autofocus')))
		->add('edad_aparente', 			'integer', array('label' => 'Edad Aparente'))
		
		->add('piel_color', 'choice', array(
				'choices' => array('N' => 'Normal', 'P' => 'Palida', 'R' => 'Rojiza')))
		->add('piel_cutis', 'choice', array(
				'choices' => array('S' => 'Seco', 'G' => 'Graso', 'M' => 'Mixto')))
		->add('piel_tacto', 'choice', array(
				'choices' => array('LF' => 'Lisa y Fina', 'GR' => 'Gruesa y Rugosa')))
		->add('dentadura', 'choice', array(
				'choices' => array('B' => 'Buena', 'R' => 'Regular', 'M' => 'Mala', 'P' => 'Protesis')))
		->add('nutricion', 'choice', array(
				'choices' => array('OB' => 'Obesidad', 'KG ' => 'KGS de exceso', 'DE' => 'Desnutricion')))
		->add('kgs', 		'integer', array('label' => 'K.G.S'))
				
		->add('op', 'choice', array(
				'choices' => array(
						'aspecto_normal' => 'Aspecto normal', 'orificios_poco_visible ' => 'OrificiosPocoVisible',
						'acne_conglobata' => 'Acne conglobata', 'comedones' => 'Comedones', 'orificios_manifiestos' => 'OrificiosManifiesto',
						'pustulas' => 'Pustulas', 'miliun' => 'Miliun', 'foliculitis' => 'Foliculitis', 'secuela_acne' => 'Secuela acne'
						),
				'multiple'=>true,
				'expanded' => true
		))
		->add('pigmentacion', 'choice', array(
				'choices' => array(
						'normal' => 'Normal', 'medicamentosa' => 'Medicamentosa', 'solar' => 'Solar',
						'melasma' => 'Melasma', 'cosmetica' => 'Cosmetica', 'maquillajes' => 'Maquillajes'
						),
				'multiple'=>true,
				'expanded' => true
		))
		->add('arrugas', 'choice', array(
				'choices' => array(
						'expresion_normal' => 'Expresion Normal', 'preauriculares ' => 'Preauriculares',
						'nasogenianos' => 'Nasogenianos', 'pliegues_finos' => 'Pliegues finos', 'pata_gallo' => 'Pata de gallo',
						'frontales' => 'Frontales', 'glabelares' => 'Glabelares', 'pliegues_profundos' => 'Pliegues profundos',
						'peribucales' => 'Peribucales', 'cuello' => 'Cuello', 'nasales' => 'Nasales', 'pliegues_cicatrizales' => 'Pliegues cicatrizales',
						),
				'multiple'=>true,
				'expanded' => true
		))
		
		->add('flacidez', 'choice', array(
				'choices' => array(
						'nula' => 'Nula', 'mejilla ' => 'Mejilla', 'papada' => 'Papada',
						'regular' => 'Regular', 'cuello' => 'Cuello', 'severa' => 'Severa',
						'parpados' => 'Parpados'
				),
				'multiple'=>true,
				'expanded' => true
		))
		->add('parpado', 'choice', array(
				'choices' => array(
						'ptosis' => 'PTosis', 'edematizados ' => 'Edematizados', 'ojeras' => 'Ojeras',
						'bolsas_superiores' => 'Bolsas superiores', 'xantelasma' => 'Xantelasma', 'bolsas_inferiores' => 'Bolsas inferiores'
				),
				'multiple'=>true,
				'expanded' => true
		))		
		->add('lesiones_cut', 'choice', array(
				'choices' => array(
						'querato_seborreica' => 'Queratosis seborreica', 'querato_acantoma ' => 'Queratosis acantoma', 'nevus ' => 'Nevus',
						'quiste_sebaceo' => 'Quiste sebaceo', 'cicatrices' => 'Cicatrices', 'rosacea' => 'Rosacea',
						'melanoma' => 'Melanoma', 'epit_basocelular' => 'Epit. Basocelular', 'epit_espinocelular' => 'Epit. Espinocelular'						
				),
				'multiple'=>true,
				'expanded' => true
		))		
		->add('lipodistrofia', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true
		))		
		->add('tatuaje', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true
		))
		->add('cicatrizes', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true
		))
		->add('estrias', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true
		))		
		->add('medicacion', 			'textarea', array('label' => 'Medicacion'))
		->add('dx_cut', 		'textarea', array('required' => false,'label' => 'Diagnostico cutaneo'))
		->add('e_uno', 			'textarea', array('required' => false,'label' => 'Escala uno'))
		->add('e_dos', 			'textarea', array('required' => false,'label' => 'Escala dos'))
		->add('e_tres', 		'textarea', array('required' => false,'label' => 'Escala tres'))
		->add('e_cuatro', 		'textarea', array('required' => false,'label' => 'Escala cuatro'))
		->add('e_cinco', 		'textarea', array('required' => false,'label' => 'Escala cinco'))
		->add('e_seis', 		'textarea', array('required' => false,'label' => 'Escala seis'))
		
		;		
	}
	
	public function getName()
	{
		return 'newHcEstetica';
	}
}