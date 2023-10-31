<?php

namespace App\Controller;

use App\Entity\CalculationsDone;
use App\Form\ConvertType;
use App\Service\Calculator;
use App\Service\Converter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ConvertController extends AbstractController
{

    public function __construct(
        private Converter $converter,
        private Calculator $calculator,
        private EntityManagerInterface $entityManager

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

            $valuesConverted = $this->converter->convert($dataFields);

            $result = $this->calculator->performCalculation($valuesConverted);

            $calcDesc = $dataFields['value_one'] . ' ' . $dataFields['currency_one']->getCode()
                . ' ' . $dataFields['operand'] . ' ' . $dataFields['value_two']
                . ' ' . $dataFields['currency_two']->getCode() . ' = ' . $result . ' ' . $dataFields['currency_result']->getCode();

            if ($form->get('save')->getData()) {
                $save = new CalculationsDone();
                $save->setDescription($calcDesc);

                $this->entityManager->persist($save);
                $this->entityManager->flush();
            }

            return $this->render('convert/index.html.twig', [
                'form' => $form->createView(),
                'result' => $result
            ]);
        }



        return $this->render('convert/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}