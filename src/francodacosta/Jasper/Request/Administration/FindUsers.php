<?php

namespace francodacosta\Jasper\Request\Administration;
use francodacosta\Jasper\Exception\JasperException;

use francodacosta\Jasper\Resource\User\User;
use francodacosta\Jasper\Resource\User\UserSearchCriteria;
use francodacosta\Jasper\Request\AbstractRequest;

/**
 * Gets a list of users from the server.
 *
 * @author Nuno Costa <nuno@francodacosta.com>
 *
 */
class FindUsers extends AbstractRequest
{

    const METHOD = 'findUsers';

    private $searchCriteria = null;

    /**
     * executes the request.
     *
     * @return francodacosta\Jasper\Resource\Resource
     */

    public function execute()
    {
        $client = $this->getCli();

        $resources = $client->call(self::METHOD, array('criteria' => $this->getSearchCriteria()));

        if (false === is_array($resources)) {
            throw new JasperException('Unknown response format, expecting array got ' . gettype($reources));
        }

        $ret = array();
        foreach ($resources as $resource) {
            $ret[] = User::fromObject($resource);
        }

        return $ret;
    }

    /**
     * Gets the criteria used to search for an user.
     *
     * @return UserSearchCriteria
     */

    public function getSearchCriteria()
    {
        if (null === $this->searchCriteria) {
            $this->searchCriteria = new UserSearchCriteria();
        }

        return $this->searchCriteria;
    }

    /**
     * Sets the criteria used to search for an user.
     *
     * @param UserSearchCriteria $searchCriteria
     */

    public function setSearchCriteria($searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
    }

}