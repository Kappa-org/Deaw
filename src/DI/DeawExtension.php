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

use Dibi\Event;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;
use Nette\PhpGenerator\PhpLiteral;

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

		$useProfiler = isset($config['profiler'])
			? $config['profiler']
			: class_exists('Tracy\Debugger') && $builder->parameters['debugMode'];

		$connection = $builder->addDefinition($this->prefix('dibiConnection'))
			->setClass('Dibi\Connection', [$config['connection']])
			->setAutowired($config['autowiredDibiConnection']);

		$builder->addDefinition($this->prefix('queryBuilder'))
			->setClass('Kappa\Deaw\Query\QueryBuilder', [
				$this->prefix('@dibiConnection')
			]);

        $builder->addDefinition($this->prefix('dibiWrapper'))
            ->setClass('Kappa\Deaw\Utils\DibiWrapper');
		
		$builder->addDefinition($this->prefix('table'))
			->setClass('Kappa\Deaw\Table');

		if (class_exists('Tracy\Debugger')) {
			$connection->addSetup(
				[new Statement('Tracy\Debugger::getBlueScreen'), 'addPanel'],
				[['Dibi\Bridges\Tracy\Panel', 'renderException']]
			);
		}

		if ($useProfiler) {
			$panel = $builder->addDefinition($this->prefix('panel'))
				->setClass('Dibi\Bridges\Tracy\Panel', [
					isset($config['explain']) ? $config['explain'] : TRUE,
					isset($config['filter']) && $config['filter'] === FALSE ? Event::ALL : Event::QUERY,
				]);
			$connection->addSetup([$panel, 'register'], [$connection]);
		}
	}
}