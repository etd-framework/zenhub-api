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
 * ZenHub API Epics class for the ETD Framework.
 */
class Epics extends AbstractPackage {

    /**
     * Get Epics for a repository.
     *
     * @param   string   $repoId   The ID of the repository, not its full name.
     *
     * @return  object
     *
     * @see     https://github.com/ZenHubIO/API#get-epics-for-a-repository
     */
    public function getList($repoId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/epics';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));

    }

    /**
     * Get a single epic.
     *
     * @param   integer  $repoId   The ID of the repository, not its full name.
     * @param   integer  $epicId   The issue number.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#get-epic-data
     */
    public function get($repoId, $epicId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/epics/' . (int) $epicId;

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

    /**
     * Converts an epic back to an issue.
     *
     * @param   integer    $repoId      The ID of the repository, not its full name.
     * @param   integer    $issueId     The issue number.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#convert-epic-to-issue
     */
    public function convertToIssue($repoId, $issueId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/epics/' . (int) $issueId. '/convert_to_issue';

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), array()));
    }

    /**
     * Bulk add or remove issues to an epic.
     *
     * @param   integer    $repoId         The ID of the repository, not its full name.
     * @param   integer    $issueId        The issue number.
     * @param   object[]   $addIssues      An array that indicates with issues we want to add to the specified epic.
     * @param   object[]   $removeIssues   An array that indicates with issues we want to remove from the specified epic.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#add-or-remove-issues-to-epic
     */
    public function updateIssues($repoId, $issueId, array $addIssues = array(), array $removeIssues = array()) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/epics/' . (int) $issueId. '/update_issues';

        // Build the request data.
        $data = array();

        // Ensure that we have a non-associative array.
        if (!empty($addIssues)) {
            $addIssues = array_values($addIssues);
            $data["add_issues"] = $addIssues;

        }
        if (!empty($removeIssues)) {
            $removeIssues = array_values($removeIssues);
            $data["remove_issues"] = $removeIssues;
        }

        // Send the request.
        return $this->processResponse($this->client->post($this->fetchUrl($path), $data));
    }

}
