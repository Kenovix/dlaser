<?php
namespace dlaser\HcBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class MedicamentoType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder
		->add('principio_activo','text',	array('label'=>'Nombre Medicamento:*','attr' => array('placeholder' => 'Limit 200 caracteres')))
		->add('concentracion',	 'text',	array('label'=>'Concentracion:*','attr' => array('placeholder' => 'Limit 10 caracteres')))
		->add('presentacion',	 'text',	array('label'=>'Presentacion:*','attr' => array('placeholder' => 'Limit 30 caracteres')))		
		->add('tiempo',			 'integer', array('label'=>'Tiempo:*','attr' => array('placeholder' => 'Valor max 99')))
		->add('dias_tratamiento','integer', array('label'=>'Dias Tratamiento:*','attr' => array('placeholder' => 'Valor max 999')))
		->add('pos',			 'checkbox',array( 'label'=>'No Pos:','required' => false))		
		->add('invima',	 'text',array( 'required' => false,'attr' => array('placeholder' => 'Limit 150 characters')))
		->add('dosis_dia',		 'textarea', array('label'=>'Posologia:','required' => false,'attr' => array('placeholder' => 'Posologia')))
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
