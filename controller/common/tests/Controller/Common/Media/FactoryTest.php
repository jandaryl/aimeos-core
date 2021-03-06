<?php

namespace Aimeos\Controller\Common\Media;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 */
class FactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testCreateController()
	{
		$target = \Aimeos\Controller\Common\Media\Iface::class;

		$controller = \Aimeos\Controller\Common\Media\Factory::createController( \TestHelperCntl::getContext() );
		$this->assertInstanceOf( $target, $controller );

		$controller = \Aimeos\Controller\Common\Media\Factory::createController( \TestHelperCntl::getContext(), 'Standard' );
		$this->assertInstanceOf( $target, $controller );
	}


	public function testCreateControllerInvalidImplementation()
	{
		$this->setExpectedException( \Aimeos\Controller\Common\Exception::class );
		\Aimeos\Controller\Common\Media\Factory::createController( \TestHelperCntl::getContext(), 'Invalid' );
	}


	public function testCreateControllerInvalidName()
	{
		$this->setExpectedException( \Aimeos\Controller\Common\Exception::class );
		\Aimeos\Controller\Common\Media\Factory::createController( \TestHelperCntl::getContext(), '%^' );
	}


	public function testCreateControllerNotExisting()
	{
		$this->setExpectedException( \Aimeos\Controller\Common\Exception::class );
		\Aimeos\Controller\Common\Media\Factory::createController( \TestHelperCntl::getContext(), 'notexist' );
	}
}
