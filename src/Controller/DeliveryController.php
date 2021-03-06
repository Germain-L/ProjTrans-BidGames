<?php

namespace App\Controller;

use App\Entity\Bids;
use App\Entity\Delivery;
use App\Repository\DeliveryRepository;
use App\Repository\ImagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route("/api", name: "api")]
class DeliveryController extends AbstractController
{
    #[Route("/delivery", name: "delivery", methods: "POST")]
    public function index(Request $request): Response
    {
        $serializer = $this->getSerializer();

        $delivery = $serializer->deserialize($request->getContent(), Delivery::class, "json");

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($delivery);
        $entityManager->flush();

        $response = new Response();

        $response->headers->set("Content-Type", "application/json");
        return $response;
    }

    public function getSerializer(): Serializer
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        return new Serializer($normalizers, $encoders);
    }

    #[Route("/delivery", name: "delivery", methods: "GET")]
    public function get_delivery(Request $request, DeliveryRepository $deliveryRepository): Response
    {
        $response = new Response();

        $id_entity = json_decode($request->getContent(), true);
        $deliveryModel = $deliveryRepository->findOneBy(["product" => $id_entity]);

        $serializer = $this->getSerializer();

        $delivery = $serializer->serialize($deliveryModel, "json");

        if ($delivery) {
            $response->setContent($delivery);
        } else {
            $response->setContent(json_encode([
                "delvery" => "not found"
            ]));
        }

        return $response;
    }
}
