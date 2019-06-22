<?php
declare(strict_types=1);

/**
 * Test suite bootstrap
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

use Cake\Core\Configure;

$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception("Cannot find the root of the application, unable to run tests");
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);
require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';
if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
}

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}
Configure::write('App', [
    'namespace' => 'CsvView\Test\App',
    'paths' => [
        'templates' => [dirname(__FILE__) . DS . 'test_app' . DS . 'templates' . DS],
    ],
]);
