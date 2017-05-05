<?php
/**
 * Part of the ETD Framework Zenhub Package
 *
 * @copyright  Copyright (C) 2017 ETD Solutions, SARL. All rights reserved.
 * @license    Apache version 2; see LICENSE
 */

namespace EtdSolutions\Zenhub\Package\Issues;

use EtdSolutions\Zenhub\AbstractPackage;

/**
 * ZenHub API Issues Events class for the ETD Framework.
 */
class Events extends AbstractPackage {

    /**
     * List events for an issue.
     *
     * @param   string   $repoId   The ID of the repository, not its full name.
     * @param   integer  $issueId  The issue number.
     *
     * @return object
     */
    public function getList($repoId, $issueId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/issues/' . (int) $issueId . '/events';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));

    }

}
