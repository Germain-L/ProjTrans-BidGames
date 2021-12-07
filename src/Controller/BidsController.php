<?php

namespace App\Controller;

use App\Entity\Bids;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route('/api', name: 'api')]
class BidsController extends AbstractController
{
    #[Route('/bids', name: 'bids')]
    public function index(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $bids = $serializer->deserialize($request->getContent(), Bids::class, 'json');

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($bids);
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
}