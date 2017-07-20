<?php
/**
 * Created by PhpStorm.
 * User: himik
 * Date: 20.07.17
 * Time: 12:41
 */

use Sndmart\ServiceHelper\ResetableMysqlService;

require_once __DIR__ . '/../vendor/autoload.php';

$resetableService = new ResetableMysqlService([
    'user'     => 'root',
    'password' => 'secret',
    'dbname'   => 'dbname',
]);

$resetableService->setTestFunction(function (\PDO $dbh) {
    return $dbh->query('SELECT NOW();')
               ->execute();
});
while (true) {
    var_dump($resetableService->getConnection() instanceof \PDO);
    sleep(1);
}

