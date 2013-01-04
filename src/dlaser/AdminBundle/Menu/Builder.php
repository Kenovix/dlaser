<?php

namespace dlaser\AdminBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
	public function mainMenu(FactoryInterface $factory, array $options)
	{
		$menu = $factory->createItem('root');

		$menu->addChild('Home', array('route' => 'cupo_new'));
		$menu->addChild('About Me', array(
				'route' => 'cupo_new',
				'routeParameters' => array('id' => 42)
		));

		return $menu;
	}
}