<?php

namespace JansenFelipe\LoggiPHP\Contracts;

use JansenFelipe\LoggiPHP\Query;

interface ClientGraphQLContract
{
    /**
     * Execute query
     *
     * @param Query $query
     * @return array
     */
    public function executeQuery(Query $query);
}