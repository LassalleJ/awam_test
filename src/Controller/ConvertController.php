<?php

namespace App\Controller;

use App\Form\ConvertType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConvertController extends AbstractController
{

    public function __construct(

    )
    {

    }

    #[Route('/', name: 'app_convert')]
    public function convert(Request $request)
    {
        $form = $this->createForm(ConvertType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dataFields = $form->getData();
        }



        return $this->render('convert/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}