<?php

namespace dlaser\AgendaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;

class CupoType extends AbstractType
{    
    private $options;
    
    public function __construct(array $options = null)
    {
        $this->options = $options;
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        
        $id = $this->options['user'];
        
        $builder        
        ->add('sede', 'entity', array(
                'class' => 'dlaser\\ParametrizarBundle\\Entity\\Sede',
                'property_path' => false,
                'query_builder' => function(EntityRepository $er) use ($id) {
                        return $er->createQueryBuilder('s','u')
                        ->leftJoin("s.usuario", "u")
                        ->where("u.id = :id")
                        ->setParameter('id', $id);
                        }
        ))
        ->add('paciente', 'integer', array('required' => true))
        ->add('cliente', 'choice', array('choices' => array('' => '--')))
        ->add('cargo', 'choice', array('choices' => array('' => '--')))
        ->add('agenda', 'choice', array('choices' => array('' => '--')))
        ->add('hora', 'choice', array('choices' => array('' => '--')))
        ->add('nota', 'text', array('required' => false))
        ;
    }

    public function getName()
    {
        return 'Cupo';
    }
    
    public function getDefaultOptions(array $options){    
        return $options;
    }
}