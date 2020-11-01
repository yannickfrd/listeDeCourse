<?php

namespace App\Controller\Api;

use App\Repository\CheckListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckListController
 * @package App\Controller\Api
 * @Route("/api/check_list")
 */
class CheckListController extends AbstractController
{
    /**
     * @Route("/get", name="get_check_list")
     */
    public function index(CheckListRepository $listRepository): Response {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'checkLists' => $listRepository->findAll()
        ]);
    }
}
