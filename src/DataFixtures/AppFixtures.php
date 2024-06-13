<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Competence;
use App\Entity\Filiere;
use App\Entity\Media;
use App\Entity\Post;
use App\Entity\Project;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Créer les filieres
        $filiere = new Filiere();
        $filiere->setLabel('Ciné');
        $manager->persist($filiere);

        // Créer un utilisateur
        $user = new User();
        $user->setEmail('admin@admin.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFirstName('adPrenom');
        $user->setLastName('adNom');
        $user->setBiographie('voici une biographie');
        $user->setReve('voici un reve');
        $user->setFiliere($filiere);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        // Créer des compétences
        $competence1 = new Competence();
        $competence1->setLabel('stratégie marketing');
        $manager->persist($competence1);

        $competence2 = new Competence();
        $competence2->setLabel('analyse de marché');
        $manager->persist($competence2);

        $competence3 = new Competence();
        $competence3->setLabel('seo/sea');
        $manager->persist($competence3);

        // Lier les compétences à l'utilisateur
        $user->addCompetence($competence1);
        $user->addCompetence($competence2);
        $user->addCompetence($competence3);

        // Créer un post
        $post = new Post();
        $post->setTitle('Mon premier post');
        $post->setText('du texte needed pour le post');
        $post->setType(1);
        $post->setCreatedDate(new \DateTimeImmutable('2024-06-13'));
        $post->setUpdatedDate(new \DateTime('2024-06-13 18:31:00'));
        $post->setUser($user);
        $manager->persist($post);

        // Créer un media
        $media = new Media();
        $media->setLabel('texte label de l\'image');
        $media->setUrlImg('upload_21_phpZ0HAib.png');
        $media->setPost($post);
        $manager->persist($media);

        // Créer un projet
        $project = new Project();
        $project->setPost($post);
        $project->setIsFinish(false);
        $project->setIsActive(true);
        $manager->persist($project);

        $manager->flush();
    }
}
