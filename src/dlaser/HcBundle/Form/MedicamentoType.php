<?php
namespace dlaser\HcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MedicamentoType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('principio_activo','text',	array('label'=>'Nombre:*','attr' => array('placeholder' => 'Nombre del medicamento')))
		->add('concentracion',	 'text',	array('label'=>'Concentración:*','attr' => array('placeholder' => 'Concentración')))
		->add('presentacion',	 'text',	array('label'=>'Presentación:*','attr' => array('placeholder' => 'Presentación')))		
		->add('tiempo',			 'integer', array('label'=>'Tiempo:', 'required' => false,'attr' => array('placeholder' => 'Tiempo')))
		->add('dias_tratamiento','integer', array('label'=>'Duración:*','attr' => array('placeholder' => 'Duración del tratamiento')))
		->add('dosis_dia',		 'textarea', array('label'=>'Posologia:','required' => false,'attr' => array('placeholder' => 'Posologia')))
		->add('pos',			 'checkbox',array( 'label'=>'No Pos:','required' => false))		
		->add('invima',	 'text',array( 'required' => false,'attr' => array('placeholder' => 'No. registro invima')))		
		->add('justificacion',	 'textarea',array( 'required' => false))
		->add('efectos',	 'textarea',array( 'required' => false))
		->add('estado',	 'choice', array('choices' => array('A' => 'Activo', 'I' => 'Inactivo')))
		;
	}

	public function getName()
	{
		return 'newMedicamento';
	}
}