<?php

namespace TmApi\Model;

use TmApi\ApiAbstract;
use TmApi\Client;

/**
 * Class BaseModel
 * @package TmApi\Model
 */
abstract class BaseModel extends ApiAbstract
{
    /**
     * @var object
     */
    private $_attributes;

    /**
     * BaseModel constructor.
     * @param Client $client
     * @param $data
     */
    public function __construct(Client $client, $data)
    {
        parent::__construct($client);
        $this->_attributes = $data;
    }

    /**
     * Getter magic method.
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if(property_exists($this->_attributes, $name)) {
            return $this->_attributes->$name;
        }

        throw new \Exception("Property {$name} is not defined in model data object.");
    }

    /**
     * Setter magic method.
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $this->_attributes[$name] = $value;
    }
}