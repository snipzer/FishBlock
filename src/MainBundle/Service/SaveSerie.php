<?php

namespace MainBundle\Service;


class SaveSerie extends TvdbConnector
{
    public function __construct($apiKey, $username, $userKey)
    {
        parent::__construct($apiKey, $username, $userKey);
    }


}

?>