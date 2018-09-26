<?php

namespace App\DataFixtures;

use App\Entity\Agency;
use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\ServiceFixtures;

class AgencyFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $agency = new Agency();

        $agency->setAgencyName("RoRo's Rocket Chips");
        $agency->setContactEmail('hello@roro.com');
        $agency->setWebAddress('http://roro.com');
        $agency->setShortDescription('The fieriest chips known to man.');
        $agency->setEstablished('2019');

        $agency->addService($this->getReference(ServiceFixtures::WEB_SERVICE_REFERENCE));
        $agency->addService($this->getReference(ServiceFixtures::PPC_REFERENCE));

        $manager->persist($agency);
        $manager->flush();

        $agency2 = new Agency();

        $agency2->setAgencyName("Heavy Profesh Web Dev");
        $agency2->setContactEmail('us@greatdevs.biz');
        $agency2->setWebAddress('https://greatdevs.biz');
        $agency2->setShortDescription('The most professional developers in town.');
        $agency2->setEstablished('1994');

        $agency2->addService($this->getReference(ServiceFixtures::WEB_SERVICE_REFERENCE));
        $agency2->addService($this->getReference(ServiceFixtures::SEO_REFERENCE));

        $manager->persist($agency2);
        $manager->flush();

        $agency3 = new Agency();

        $agency3->setAgencyName("Shass Kinsalott");
        $agency3->setContactEmail('sounds@shasskinsal.ot');
        $agency3->setWebAddress('https://shasskinsal.ot');
        $agency3->setShortDescription('Post-modern audio branding agency based in London.');
        $agency3->setEstablished('2000');

        $agency3->addService($this->getReference(ServiceFixtures::PPC_REFERENCE));
        $agency3->addService($this->getReference(ServiceFixtures::SEO_REFERENCE));

        $manager->persist($agency3);

        $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            ServiceFixtures::class,
        );
    }
}
