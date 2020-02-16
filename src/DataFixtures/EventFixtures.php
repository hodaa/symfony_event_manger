<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Event;

class EventFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $event = new Event();
        $event->setName("Event1");
        $event->setPeriod(30);
        $event->setType(1);
        $event->setAttendance(1);
        $event->setlocation("Egypt");
        $event->setDate('2020-03-01');

        $manager->persist($event);
        $manager->flush();
    }
}
