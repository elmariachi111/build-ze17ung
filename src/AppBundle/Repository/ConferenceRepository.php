<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConferenceRepository extends EntityRepository
{

    public function getUpcomingConferences() {
        return $this->findAll();
    }

}
