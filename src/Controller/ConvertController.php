<?php

namespace App\Controller;

use App\Entity\CalculationsDone;
use App\Form\ConvertType;
use App\Service\Calculator;
use App\Service\Converter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
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

            if(!$valuesConverted) {
                $form->get('currency_result')->addError(new FormError('La conversion sélectionnée n\'est pas définie'));
                return $this->render('convert/index.html.twig', [
                    'form' => $form->createView(),
                    'history' => $_SESSION['history'] ?? null
                ]);
            }

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

            $_SESSION['history'][] = $calcDesc;

            return $this->render('convert/index.html.twig', [
                'form' => $form->createView(),
                'result' => $result,
                'history' => $_SESSION['history'] ?? null
            ]);
        }



        return $this->render('convert/index.html.twig', [
            'form' => $form->createView(),
            'history' => $_SESSION['history'] ?? null
        ]);
    }

}