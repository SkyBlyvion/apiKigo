<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Media;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class CreatePostController
{
    private $entityManager;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        $post = new Post();
        $media = new Media();

        $post->setTitle($request->get('title'));
        $post->setText($request->get('text'));
        $post->setCreatedDate(new \DateTimeImmutable());
        $post->setUpdatedDate(new \DateTime());

        $file = $request->files->get('imageFile');
        if ($file) {
            $media->setImageFile($file);
            $this->entityManager->persist($media);
            $post->setMedia($media);
        }

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return new JsonResponse(
            $this->serializer->serialize($post, 'jsonld'),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
