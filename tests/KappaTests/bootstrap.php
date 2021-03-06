<?php
/**
 * This file is part of the Kappa\Deaw package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 */

if ((!$loader = include __DIR__ . '/../../vendor/autoload.php') && (!$loader = include __DIR__ . '/../../../../autoload.php')) {
	echo 'Install Nette Tester using `composer update --dev`';
	exit(1);
}
/** @var Composer\Autoload\ClassLoader $loader */
$loader->addPsr4("KappaTests\\", __DIR__);

// configure environment
Tester\Environment::setup();

define('TEMP_DIR', __DIR__ . '/../temp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
Tester\Helpers::purge(TEMP_DIR);

function getDatabaseConnection()
{
	$config = parse_ini_file(__DIR__ . '/../config/database.ini', TRUE)['mysql'];

	return $config;
}

function getContainer()
{
	$configurator = new \Nette\Configurator();
	$configurator->setTempDirectory(TEMP_DIR);
	$configurator->addConfig(__DIR__ . '/../config/config.global.neon');
	$configurator->addConfig(__DIR__ . '/../config/config.neon');
	return $configurator->createContainer();
}

function run(Tester\TestCase $testCase)
{
	$testCase->run(isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : NULL);
}
