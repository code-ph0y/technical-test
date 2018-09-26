<?php

namespace App\DataFixtures;

use App\Entity\Service;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public const WEB_SERVICE_REFERENCE = 'web-service';
    public const PPC_REFERENCE         = 'ppc';
    public const SEO_REFERENCE         = 'seo';

    public function load(ObjectManager $manager)
    {
        $webService = new Service();

        $webService->setServiceName('Web Development');
        $webService->setSlug('web-development');

        $manager->persist($webService);

        $ppc = new Service();

        $ppc->setServiceName('PPC');
        $ppc->setSlug('ppc');

        $manager->persist($ppc);

        $seo = new Service();

        $seo->setServiceName('SEO');
        $seo->setSlug('seo');

        $manager->persist($seo);

        $manager->flush();

        $this->addReference(self::WEB_SERVICE_REFERENCE, $webService);
        $this->addReference(self::PPC_REFERENCE, $ppc);
        $this->addReference(self::SEO_REFERENCE, $seo);

    }
}
