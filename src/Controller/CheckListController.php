<?php

namespace App\Controller;

use App\Form\CheckListFormType;
use App\Repository\CheckListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckListController extends AbstractController
{
    /**
     * @Route("/check/list", name="check_list")
     */
    public function index(CheckListRepository $checkListRepository): Response
    {
        $checklistForm = $this->createForm(CheckListFormType::class);

        return $this->render('check_list/index.html.twig', [
                'checklists' => $checkListRepository->findAll(),
            'checklistForm' => $checklistForm->createView()
        ]);
    }
}
