<?php
/**
 * Created by PhpStorm.
 * User: himik
 * Date: 20.07.17
 * Time: 12:32
 */

namespace Sndmart\ServiceHelper;

class ResetableMysqlService
{

    protected $config = [
        'host'     => '127.0.0.1',
        'port'     => 3306,
        'dbname'   => 'mysql',
        'user'     => 'root',
        'password' => null,
        'charset'  => 'utf8',
    ];

    /** @var  callable */
    protected $testFunction;

    /** @var  \PDO */
    protected $connection;

    public function __construct(array $options)
    {
        $this->config = array_merge($this->config, $options);
    }

    protected function resetConnection()
    {
        $this->connection = new \PDO(sprintf('mysql:dbname=%s;host=%s;port=%s;charset=%s', $this->config['dbname'],
            $this->config['host'], $this->config['port'], $this->config['charset']), $this->config['user'],
            $this->config['password']);
    }

    public function getConnection()
    {
        if (!$this->testFunction) {
            throw new \InvalidArgumentException('You must provide test function first');
        }

        if (!$this->connection) {
            $this->resetConnection();
        }

        if (!call_user_func($this->testFunction, $this->connection)) {
            $this->resetConnection();
        }

        return $this->connection;
    }

    public function setTestFunction(callable $customTestFunction = null)
    {
        $this->testFunction = $customTestFunction;

        return $this;
    }
}