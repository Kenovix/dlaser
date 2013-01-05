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

		$menu->addChild('Home', array('route' => 'cupo_new'));
		$menu->addChild('About Me', array(
				'route' => 'cupo_new',
				'routeParameters' => array('id' => 42)
		));
		
		$menu->addChild('Comments');
		
		// ArrayAccess
		$menu['Comments']->setUri('#comments');
		$menu['Comments']->addChild('My comments', array('uri' => '/my_comments'));

		return $menu;
	}
}