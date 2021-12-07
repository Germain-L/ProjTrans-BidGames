<?php

namespace App\Controller;

use App\Entity\Bids;
use App\Repository\ImagesRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route('/api', name: 'api')]
class ImagesController extends AbstractController
{
    #[Route('/images', name: 'images', methods: 'POST')]
    public function index(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $images = $serializer->deserialize($request->getContent(), Bids::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($images);
        $entityManager->flush();

        $response = new Response();

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    #[Route('/images', name: 'images', methods: 'GET')]
    public function get_images(Request $request, ImagesRepository $imagesRepository): Response
    {
        $response = new Response();

        $id_entity = json_decode($request->getContent(), true);
        $imagesModel = $imagesRepository->findOneBy(['product' => $id_entity]);

        $serializer = $this->getSerializer();

        $images = $serializer->serialize($imagesModel, 'json');

        if ($images) {
            $response->setContent($images);
        } else {
            $response->setContent(json_encode([
                "image" => "not found"
            ]));
        }

        return $response;
    }
}
