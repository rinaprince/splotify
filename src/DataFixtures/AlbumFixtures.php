<?php

namespace App\DataFixtures;

use App\Entity\Album;
use App\Entity\Band;
use App\Entity\Song;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use LogicException;

class AlbumFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $albums = [];

        $faker = Factory::create();

        //Obtindre les bandes ja creades
        $bands = $manager->getRepository(Band::class)->findAll();
        if (empty($bands)) {
            throw new LogicException("Ningunda banda disponible.");
        }

        //Generar àlbums
        for ($i = 0; $i < 25; $i++) {
            $album = new Album();
            $album->setTitle($faker->sentence(3));
            $album->setReleasedAt($faker->dateTimeThisDecade());
            $album->setCover($faker->file('img', 'public/images/albums', false));
            $album->setBand($faker->randomElement($bands));

            $manager->persist($album);
            $this->addReference('album_' . ($i + 1), $album);

            //Generar cançons per àlbum
            $numSongs = rand(5, 15);
            for ($j = 0; $j < $numSongs; $j++) {
                $song = new Song();

                $song->setTitle($faker->unique()->sentence(3));
                $song->setDuration(rand(120, 600));
                $song->setAlbum($album);

                $manager->persist($song);
            }

            $albums[] = $album;
        }

        // $manager->flush();

        // Asignar àlbums a users
        //$admin = $manager->getRepository(User::class)->findOneBy(['username' => 'admin']);
        //$user = $manager->getRepository(User::class)->findOneBy(['username' => 'user']);

        $admin = $this->getReference('usuari_admin');
        $user = $this->getReference('usuari_normal');

        //$albums = $manager->getRepository(Album::class)->findAll();

        foreach ($albums as $album) {
            if (rand(0, 1)) {
                $admin->addLike($album);
            } else {
                $user->addLike($album);
            }
        }

        $manager->persist($admin);
        $manager->persist($user);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            BandFixtures::class
        ];
    }
}
