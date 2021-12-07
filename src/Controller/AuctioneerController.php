<?php

namespace App\Controller;

use App\Entity\Auctioneer;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route('/api', name: 'api')]
class AuctioneerController extends AbstractController
{
    #[Route('/auctioneer', name: 'auctioneer', methods: ['POST'])]
    public function index(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $auctioneer = $serializer->deserialize($request->getContent(), Auctioneer::class, 'json');

        $response = new Response();

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($auctioneer);
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
