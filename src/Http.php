<?php
/**
 * Part of the ETD Framework Zenhub Package
 *
 * @copyright  Copyright (C) 2017 ETD Solutions, SARL. All rights reserved.
 * @license    Apache version 2; see LICENSE
 */

namespace EtdSolutions\Zenhub;

use Joomla\Http\Http as BaseHttp;
use Joomla\Http\TransportInterface;

/**
 * HTTP client class for connecting to a Zenhub instance.
 */
class Http extends BaseHttp {

    /**
     * Constructor.
     *
     * @param   array               $options    Client options array.
     * @param   TransportInterface  $transport  The HTTP transport object.
     */
    public function __construct($options = array(), TransportInterface $transport = null) {

        // Call the Http constructor to setup the object.
        parent::__construct($options, $transport);

        // Make sure the user agent string is defined.
        if (!isset($this->options['userAgent'])) {
            $this->options['userAgent'] = 'ETDZenHub/1.0';
        }

        // Set the default timeout to 120 seconds.
        if (!isset($this->options['timeout'])) {
            $this->options['timeout'] = 120;
        }
    }
}
