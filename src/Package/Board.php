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
 * ZenHub API Board class for the ETD Framework.
 */
class Board extends AbstractPackage {

    /**
     * Get the ZenHub Board data for a repository.
     *
     * @param   integer  $repoId   The ID of the repository, not its full name.
     *
     * @return  object
     *
     * @throws  \DomainException
     *
     * @see     https://github.com/ZenHubIO/API#get-the-zenhub-board-data-for-a-repository
     */
    public function get($repoId) {

        // Build the request path.
        $path = '/repositories/' . (int) $repoId . '/board';

        // Send the request.
        return $this->processResponse($this->client->get($this->fetchUrl($path)));
    }

}
