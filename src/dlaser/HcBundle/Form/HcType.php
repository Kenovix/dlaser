<?php
namespace dlaser\HcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class HcType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('fecha',   			'datetime',array('read_only'=>true))
		->add('sistole', 			'integer', array('label' => 'Sist.','attr' => array('autofocus'=>'autofocus')))
		->add('diastole',			'integer', array('label' => 'Dias.'))
		->add('f_c',	 			'integer',	array('required' => false, 'label'=> 'F/C'))
		->add('f_r',	 			'integer',	array('required' => false, 'label'=> 'F/R'))
		->add('peso',	 			'integer',	array( 'label'=> 'Peso *'))
		->add('estatura',			'integer',	array( 'label'=> 'Talla *'))
		->add('hta', 	 			'choice',  array('label' => 'Hipertensión', 'choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('diabetes',			'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('dislipidemia', 		'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('tabaquismo', 		'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('obesidad', 			'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('ante_familiar', 		'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('sedentarismo', 		'choice',  array('choices' => array('no'=> 'No','si'=> 'Si',),'multiple'=>false))
		->add('enfermedad',		    'textarea',array('label' => 'Enfermedad actual *', 'attr' => array('placeholder' => 'Ingrese la enfermedad actual del paciente')))
		->add('rev_cardiovascular', 'textarea',array('label' => 'Revisión Sistema', 'required' => false))
		->add('exa_fisico',			'textarea',array('label' => 'Examen Físico', 'required' => false))
		->add('exa_presentado',		'textarea',array('label' => 'Otros examenes presentados', 'required' => false))
		->add('nota_exa_soli',		'textarea',array('label' => 'Nota examen solicitado', 'required' => false))
		->add('interconsulta',		'textarea',array('required' => false,'attr' => array('placeholder' => 'Remisión a interconsulta')))
		->add('motivo_inter',		'textarea',array('label' => 'Interconsulta 2', 'required' => false))
		->add('dx_presunto',		'text',array('label' => 'Otro diagnostico', 'required' => false))
		->add('manejo',				'textarea',array('required' => false))
		->add('control',			'text', array('required' => false,'attr' => array('placeholder' => '2 Caracteres maximo')))
		->add('ctrl_prioritario',	'checkbox',array('required' => false))
		->add('postfecha',			'integer', array('required' => false,'attr' => array('placeholder' => '2 Caracteres maximo')))
        ;	
	}

	public function getName()
	{
		return 'newHC';
	}
}