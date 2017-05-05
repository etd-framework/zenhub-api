<?php
/**
 * Part of the ETD Framework Zenhub Package
 *
 * @copyright  Copyright (C) 2017 ETD Solutions, SARL. All rights reserved.
 * @license    Apache version 2; see LICENSE
 */

namespace EtdSolutions\Zenhub;

use Joomla\Registry\Registry;

/**
 * ZenHub API package class for the ETD Framework.
 */
abstract class AbstractPackage extends AbstractZenhubObject {

    /**
     * Constructor.
     *
     * @param   Registry  $options  GitHub options object.
     * @param   Http      $client   The HTTP client object.
     */
    public function __construct(Registry $options = null, Http $client = null) {

        parent::__construct($options, $client);

        $this->package = get_class($this);
        $this->package = substr($this->package, strrpos($this->package, '\\') + 1);
    }

    /**
     * Magic method to lazily create API objects
     *
     * @param   string  $name  Name of property to retrieve
     *
     * @throws \InvalidArgumentException
     *
     * @return  AbstractPackage  ZenHub API package object.
     */
    public function __get($name) {

        $class = '\\EtdSolutions\\Zenhub\\Package\\' . $this->package . '\\' . ucfirst($name);

        if (!class_exists($class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument %1$s produced an invalid class name: %2$s in package %3$s',
                    $name, $class, $this->package
                )
            );
        }

        if (!isset($this->$name)) {
            $this->$name = new $class($this->options, $this->client);
        }

        return $this->$name;
    }
}
