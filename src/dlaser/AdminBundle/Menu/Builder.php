<?php

namespace dlaser\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
	public function adminMenu(FactoryInterface $factory, array $options)
	{
		$menu = $factory->createItem('root');
		$menu->setChildrenAttributes(array('id' => 'menu'));

		$menu->addChild('Parametrizar', array('uri' => '#'));	
			$menu['Parametrizar']->addChild('Empresa', array('route' => 'empresa_list'));
			$menu['Parametrizar']->addChild('Cliente', array('route' => 'cliente_list'));
			$menu['Parametrizar']->addChild('Cargo', array('route' => 'cargo_list'));
			$menu['Parametrizar']->addChild('Paciente', array('uri' => '#'));
				$menu['Parametrizar']['Paciente']->addChild('Consultar', array('route' => 'paciente_list'));
				$menu['Parametrizar']['Paciente']->addChild('Listar', array('route' => 'paciente_list'));
			$menu['Parametrizar']->addChild('Usuarios', array('route' => 'usuario_list'));
		
		
		/*$menu->addChild('About Me', array(
				'route' => 'cupo_new',
				'routeParameters' => array('id' => 42)
		));*/

		return $menu;
	}
}