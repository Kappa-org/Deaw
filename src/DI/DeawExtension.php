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
		'tables' => []
	];

	public function loadConfiguration()
	{
		$config = $this->getConfig($this->defaultConfig);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('dibiConnection'))
			->setClass('\DibiConnection', [$config['connection']]);

		$tableServices = [];
		foreach ($config['tables'] as $tableName) {
			$tableServices[] = new Statement('Kappa\Deaw\Table', [
				$this->prefix("@dibiConnection"),
				$tableName
			]);
		}

		$builder->addDefinition($this->prefix('tableManager'))
			->setClass('Kappa\Deaw\TableManager', [$tableServices]);

		$builder->addDefinition($this->prefix('table'))
			->setClass('Kappa\Deaw\Table')
			->setFactory('@Kappa\Deaw\TableManager::getTable', array(new PhpLiteral('$tableName')))
			->setParameters(array('tableName'))
			->setInject(FALSE);
	}
}
