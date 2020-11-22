<?php

namespace App\Controller;

use App\Form\CheckListFormType;
use App\Repository\CheckListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CheckListController
 * @package App\Controller
 * @Route("/check_list")
 */
class CheckListController extends AbstractController
{
    /**
     * @param CheckListRepository $checkListRepository
     * @return Response
     * @Route("/", name="check_list")
     */
    public function index(CheckListRepository $checkListRepository): Response
    {
        $checklistForm = $this->createForm(CheckListFormType::class);

        return $this->render('check_list/index.html.twig', [
            'checklists' => $checkListRepository->findBy([], ['createdAt' => 'desc']), // par "date" + à - récente
            'checklistForm' => $checklistForm->createView()
        ]);
    }
}
