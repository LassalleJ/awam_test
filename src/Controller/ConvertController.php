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

//            Récupérer les données du formulaire
            $dataFields = $form->getData();

//            Conversion des valeurs vers la devise du résultat souhaité
            $valuesConverted = $this->converter->convert($dataFields);

//            Si le taux de change n'existe pas en base, $valueConverted sera false
            if(!$valuesConverted) {

//              Renvoi vers le formulaire avec l'erreur
                $form->get('currency_result')->addError(new FormError('La conversion sélectionnée n\'est pas définie'));
                return $this->render('convert/index.html.twig', [
                    'form' => $form->createView(),
                    'history' => $_SESSION['history'] ?? null
                ]);
            }

//          Calcul, avec la possibilité d'additionner ou soustraire
            $result = $this->calculator->performCalculation($valuesConverted);

//          Génération du string permettant d'enregistrer le calcul en base et en session
            $calcDesc = $dataFields['value_one'] . ' ' . $dataFields['currency_one']->getCode()
                . ' ' . $dataFields['operand'] . ' ' . $dataFields['value_two']
                . ' ' . $dataFields['currency_two']->getCode() . ' = ' . $result . ' ' . $dataFields['currency_result']->getCode();

//          Si la case est cochée, le calcul est stocké en base
            if ($form->get('save')->getData()) {
                $save = new CalculationsDone();
                $save->setDescription($calcDesc);

                $this->entityManager->persist($save);
                $this->entityManager->flush();
            }

//          Le calcul est stocké en session
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