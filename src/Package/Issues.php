<?php
/**
 * Part of the ETD Framework Zenhub Package
 *
 * @copyright  Copyright (C) 2017 ETD Solutions, SARL. All rights reserved.
 * @license    Apache version 2; see LICENSE
 */

namespace EtdSolutions\Zenhub\Package;

use EtdSolutions\Zenhub\AbstractPackage;

/**
 * ZenHub API Issues class for the ETD Framework.
 *
 * @property-read  Issues\Events  $events  ZenHub API object for events.
 */
class Issues extends AbstractPackage {

    /**
     * Get a single issue.
     *
     * @param   integer  $repoId   The ID of the repository, not its full name.
     * @param   integer  $issueId  The issue number.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#get-issue-data
     */
    public function get($repoId, $issueId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/issues/' . (int) $issueId;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Move an issue between pipelines.
     *
     * @param   integer         $repoId      The ID of the repository, not its full name.
     * @param   integer         $issueId     The issue number.
     * @param   string          $pipelineId  The id for one of the pipelines in your repository
     * @param   integer|string  $position    Can be either a String with the values "top" or "bottom", can also be specified as numbers.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#move-issue-between-pipelines
     */
    public function moves($repoId, $issueId, $pipelineId, $position) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/issues/' . (int) $issueId. '/moves';

        // Create the data object.
        $data = [
            "pipeline_id" => $pipelineId
        ];

        if (isset($position)) {
            if (is_string($position)) {

                if (!in_array($position, array('top', 'bottom'))) {
                    throw new \InvalidArgumentException('Invalid position type');
                }

                $data["position"] = $position;
            } else {
                $data["position"] = (int) $position;
            }
        }

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data));
    }

    /**
     * Sets an estimate value for an issue.
     *
     * @param   integer         $repoId      The ID of the repository, not its full name.
     * @param   integer         $issueId     The issue number.
     * @param   integer         $estimate    A number that represents the value that we want to set as estimate.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#set-estimate-for-issue
     */
    public function estimate($repoId, $issueId, $estimate) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/issues/' . (int) $issueId. '/estimate';

        // Build the request data.
        $data = array(
            "estimate" => (int) $estimate
        );

        // Send the request.
        return $this->processResponse($this->client->put($this->fetchUrl($path), $data));
    }

    /**
     * Converts an issue to an epic, along with any issues that should be part of it.
     *
     * @param   integer    $repoId      The ID of the repository, not its full name.
     * @param   integer    $issueId     The issue number.
     * @param   object[]   $issues      The issues that we want to be added to the epic.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#convert-issue-to-epic
     */
    public function convertToEpic($repoId, $issueId, array $issues = array()) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/issues/' . (int) $issueId. '/convert_to_epic';

        // Ensure that we have a non-associative array.
        if (!empty($issues)) {
            $issues = array_values($issues);
        }

        // Build and encode the request data.
        $data = json_encode(array(
            "issues" => $issues
        ));

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data));
    }

}
