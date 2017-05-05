<?php
/**
 * Part of the ETD Framework Zenhub Package
 *
 * @copyright  Copyright (C) 2017 ETD Solutions, SARL. All rights reserved.
 * @license    Apache version 2; see LICENSE
 */

namespace EtdSolutions\Zenhub;

use Joomla\Http\Exception\UnexpectedResponseException;
use Joomla\Http\Response;
use Joomla\Uri\Uri;
use Joomla\Registry\Registry;

/**
 * ZenHub API object class for the ETD Framework.
 */
abstract class AbstractZenhubObject {

    /**
     * @var    Registry  Options for the GitHub object.
     */
    protected $options;

    /**
     * @var    Http  The HTTP client object to use in sending HTTP requests.
     */
    protected $client;

    /**
     * @var    string  The package the object resides in
     */
    protected $package = '';

    /**
     * Array containing the allowed hook events
     *
     * @var    array
     * @see    https://github.com/ZenHubIO/API#webhooks
     */
    protected $hookEvents = array(
        '*',
        'issue_transfer',
        'estimate_set',
        'estimate_cleared',
        'issue_reprioritized'
    );

    /**
     * Constructor.
     *
     * @param   Registry  $options  ZenHub options object.
     * @param   Http      $client   The HTTP client object.
     */
    public function __construct(Registry $options = null, Http $client = null) {

        $this->options = isset($options) ? $options : new Registry;
        $this->client  = isset($client) ? $client : new Http($this->options);

        $this->package = get_class($this);
        $this->package = substr($this->package, strrpos($this->package, '\\') + 1);
    }

    /**
     * Method to build and return a full request URL for the request.  This method will
     * add appropriate pagination details if necessary and also prepend the API url
     * to have a complete URL for the request.
     *
     * @param   string   $path   URL to inflect
     *
     * @return  string   The request URL.
     */
    protected function fetchUrl($path) {

        // Get a new Uri object focusing the api url and given path.
        $uri = new Uri($this->options->get('api.url') . $path);

        // Access token
        $uri->setVar('access_token', $this->options->get('zh.token'));

        return (string) $uri;
    }

    /**
     * Process the response and decode it.
     *
     * @param   Response  $response      The response.
     * @param   integer   $expectedCode  The expected "good" code.
     *
     * @return  mixed
     *
     * @since   1.0
     * @throws  UnexpectedResponseException
     */
    protected function processResponse(Response $response, $expectedCode = 200) {

        // Validate the response code.
        if ($response->code != $expectedCode) {

            // Decode the error response and throw an exception.
            $error = json_decode($response->body);
            $message = isset($error->message) ? $error->message : 'Invalid response received from ZenHub.';
            throw new UnexpectedResponseException($response, $message, $response->code);
        }

        return json_decode($response->body);
    }
}
