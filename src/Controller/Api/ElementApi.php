<?php

namespace App\Controller\Api;

use App\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * Class ElementApi
 * @package App\Controller\Api
 * @Route("/api/element")
 */
class ElementApi extends AbstractController {

    /**
     * @param SerializerInterface $serializer
     * @param Request $request
     * @return JsonResponse
     * @Route("/post", name="post_element", methods={"POST"})
     */
    public function add(SerializerInterface $serializer, Request $request): JsonResponse
    {
        $element = $serializer->deserialize($request->getContent(), Element::class, 'json');
        dd($element);
        return $this->json([], 200);
    }

}