<?php

namespace App\Controller;

use App\Form\CheckListFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CheckListController extends AbstractController
{
    /**
     * @Route("/check/list", name="check_list")
     */
    public function index(): Response
    {
        $checklistForm = $this->createForm(CheckListFormType::class);

        return $this->render('check_list/index.html.twig', [
            'checklistForm' => $checklistForm->createView()
        ]);
    }
}
