<?php
namespace dlaser\HcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HcEsteticaType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('fecha', 'date',array('read_only'=>true))
		->add('edad_crono', 'integer', array('label' => 'Edad cronológica','attr' => array('autofocus'=>'autofocus')))
		->add('edad_aparente', 'integer', array('label' => 'Edad aparente'))
		
		->add('piel_color', 'choice', array(
				'choices' => array('N' => 'Normal', 'P' => 'Palida', 'R' => 'Rojiza')))
		->add('piel_cutis', 'choice', array(
				'choices' => array('S' => 'Seco', 'G' => 'Graso', 'M' => 'Mixto')))
		->add('piel_tacto', 'choice', array(
				'choices' => array('LF' => 'Lisa y Fina', 'GR' => 'Gruesa y Rugosa')))
		->add('dentadura', 'choice', array(
				'choices' => array('B' => 'Buena', 'R' => 'Regular', 'M' => 'Mala', 'P' => 'Protesis')))
		
		->add('nutricion', 'choice', array(
				'choices' => array('OB' => 'Obesidad', 'KG ' => 'KGS de exceso', 'DE' => 'Desnutricion'),
				'label' => 'NutriciÃ³n'))
		
		->add('kgs', 'integer', array('label' => 'K.G.S'))
				
		->add('op', 'choice', array(
				'choices' => array(
						'aspecto_normal' => 'Aspecto normal', 'orificios_poco_visible ' => 'OrificiosPocoVisible',
						'acne_conglobata' => 'Acne conglobata', 'comedones' => 'Comedones', 'orificios_manifiestos' => 'OrificiosManifiesto',
						'pustulas' => 'Pustulas', 'miliun' => 'Miliun', 'foliculitis' => 'Foliculitis', 'secuela_acne' => 'Secuela acne'
						),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Orificios pilocebaceos'
		))
		->add('pigmentacion', 'choice', array(
				'choices' => array(
						'normal' => 'Normal', 'medicamentosa' => 'Medicamentosa', 'solar' => 'Solar',
						'malesma' => 'Malesma', 'cosmetica' => 'Cosmetica', 'maquillajes' => 'Maquillajes'
						),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'PigmentaciÃ³n'
		))
		->add('arrugas', 'choice', array(
				'choices' => array(
						'expresion_normal' => 'Expresion Normal', 'preauriculares ' => 'Preauriculares',
						'nasogenianos' => 'Nasogenianos', 'pliegues_finos' => 'Pliegues finos', 'pata_gallo' => 'Pata de gallo',
						'frontales' => 'Frontales', 'glabelares' => 'Glabelares', 'pliegues_profundos' => 'Pliegues profundos',
						'peribucales' => 'Peribucales', 'cuello' => 'Cuello', 'nasales' => 'Nasales', 'pliegues_cicatrizales' => 'Pliegues cicatrizales',
						),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Arrugas'
		))
		
		->add('flacidez', 'choice', array(
				'choices' => array(
						'nula' => 'Nula', 'mejilla ' => 'Mejilla', 'papada' => 'Papada',
						'regular' => 'Regular', 'cuello' => 'Cuello', 'severa' => 'Severa',
						'parpados' => 'Parpados'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Flacidez'
		))
		->add('parpado', 'choice', array(
				'choices' => array(
						'ptosis' => 'PTosis', 'edematizados ' => 'Edematizados', 'ojeras' => 'Ojeras',
						'bolsas_superiores' => 'Bolsas superiores', 'xantelasma' => 'Xantelasma', 'bolsas_inferiores' => 'Bolsas inferiores'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Parpado'
		))		
		->add('lesiones_cut', 'choice', array(
				'choices' => array(
						'querato_seborreica' => 'Queratosis seborreica', 'querato_acantoma ' => 'Queratosis acantoma', 'nevus ' => 'Nevus',
						'quiste_sebaceo' => 'Quiste sebaceo', 'cicatrices' => 'Cicatrices', 'rosacea' => 'Rosacea',
						'melanoma' => 'Melanoma', 'epit_basocelular' => 'Epit. Basocelular', 'epit_espinocelular' => 'Epit. Espinocelular'						
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Lesiones cutÃ¡neas'
		))		
		->add('lipodistrofia', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Lipodistrofia'
		))		
		->add('tatuaje', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Tatuajes'
		))
		->add('cicatrizes', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Cicatrices'
		))
		->add('estrias', 'choice', array(
				'choices' => array(
						'abdomen' => 'Abdomen', 'espalda ' => 'Espalda', 'pierna ' => 'Pierna',
						'brazo' => 'Brazo', 'muslo' => 'Muslo'
				),
				'multiple'=>true,
				'expanded' => true,
				'label' => 'Estrias'
		))		
		->add('medicacion', 	'textarea', array('label' => 'Medicacion'))
		->add('dx_cut', 		'textarea', array('required' => false,'label' => 'Diagnostico cutaneo'))
		->add('e_uno', 			'text', array('required' => false,'label' => 'Fototipo 1'))
		->add('e_dos', 			'text', array('required' => false,'label' => 'Fototipo 2'))
		->add('e_tres', 		'text', array('required' => false,'label' => 'Fototipo 3'))
		->add('e_cuatro', 		'text', array('required' => false,'label' => 'Fototipo 4'))
		->add('e_cinco', 		'text', array('required' => false,'label' => 'Fototipo 5'))
		->add('e_seis', 		'text', array('required' => false,'label' => 'Fototipo 6'))
		->add('grafico', 		'textarea', array('required' => false, 'label' => 'grafico'))
		
		;		
	}
	
	public function getName()
	{
		return 'newHcEstetica';
	}
}