<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

namespace Kappa\Deaw\DI;

use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\PhpGenerator\PhpLiteral;
use Nette\Utils\Random;

/**
 * Class DeawExtension
 *
 * @package Kappa\Deaw\DI
 * @author Ondřej Záruba <http://zaruba-ondrej.cz>
 */
class DeawExtension extends CompilerExtension
{
	private $defaultConfig = [
		'connection' => [],
		'autowiredDibiConnection' => false
	];

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaultConfig);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('dibiConnection'))
			->setClass('Dibi\Connection', [$config['connection']])
			->setAutowired($config['autowiredDibiConnection']);

		$builder->addDefinition($this->prefix('tableManager'))
			->setClass('Kappa\Deaw\TableFactory', [
				$this->prefix('@dibiConnection')
			]);

		$builder->addDefinition($this->prefix('table'))
			->setClass('Kappa\Deaw\Table')
			->setFactory('@Kappa\Deaw\TableFactory::create', array(new PhpLiteral('$tableName')))
			->setParameters(array('tableName'))
			->setInject(FALSE);
	}
}
