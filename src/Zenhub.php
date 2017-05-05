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
 * ETD Framework class for interacting with a ZenHub server instance.
 *
 * @property-read  Package\Board    $board    ZenHub API object for the board package.
 * @property-read  Package\Epics    $epics    ZenHub API object for the epics package.
 * @property-read  Package\Issues   $issues   ZenHub API object for the issues package.
 */
class Zenhub {

    /**
     * @var    array  Options for the GitHub object.
     */
    protected $options;

    /**
     * @var    Http  The HTTP client object to use in sending HTTP requests.
     */
    protected $client;

    /**
     * Constructor.
     *
     * @param   Registry  $options  ZenHub options object.
     * @param   Http      $client   The HTTP client object.
     *
     * @since   1.0
     */
    public function __construct(Registry $options = null, Http $client = null) {

        $this->options = isset($options) ? $options : new Registry;
        $this->client  = isset($client) ? $client : new Http($this->options);

        // Setup the default API url if not already set.
        if (!$this->getOption('api.url')) {
            $this->setOption('api.url', 'https://api.zenhub.io/p1');
        }
    }

    /**
     * Magic method to lazily create API objects
     *
     * @param   string  $name  Name of property to retrieve
     *
     * @return  Object  ZenHub API object (gists, issues, pulls, etc).
     * @throws  \InvalidArgumentException If $name is not a valid sub class.
     */
    public function __get($name) {

        $class = 'EtdSolutions\\Zenhub\\Package\\' . ucfirst($name);

        if (class_exists($class)) {

            if (!isset($this->$name)) {
                $this->$name = new $class($this->options, $this->client);
            }

            return $this->$name;
        }

        throw new \InvalidArgumentException(sprintf('Argument %s produced an invalid class name: %s', $name, $class));
    }

    /**
     * Get an option from the ZenHub instance.
     *
     * @param   string  $key  The name of the option to get.
     *
     * @return  mixed  The option value.
     */
    public function getOption($key) {

        return isset($this->options[$key]) ? $this->options[$key] : null;
    }

    /**
     * Set an option for the ZenHub instance.
     *
     * @param   string  $key    The name of the option to set.
     * @param   mixed   $value  The option value to set.
     *
     * @return  Zenhub  This object for method chaining.
     *
     * @since   1.0
     */
    public function setOption($key, $value) {

        $this->options[$key] = $value;

        return $this;
    }
}
