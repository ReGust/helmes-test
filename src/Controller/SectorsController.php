<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SectorsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SectorsController extends AbstractController
{

    public function view(Request $request, EntityManagerInterface $em, ValidatorInterface $validator) : Response
    {
        $form = $this->createForm(SectorsType::class);

        if ($request->isMethod('POST')) {
            $form->submit($request->request->get($form->getName()));
            if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();

                // get user id from session
                $userId = $this->container->get('session')->get('userid');
                if ($userId) {
                    $user = $em->find(User::class, $userId);
                } else {
                    $user = new User();
                }

                $user->setName($data['name']);
                $user->setSectors($data['sectors']);
                $user->setAgreeToTerms($data['agree_to_terms']);

                $errors = $validator->validate($user);
                if (count($errors) > 0) {
                    $errorsString = (string) $errors;
                }

                $em->persist($user);
                $em->flush();

                // save created user id to session
                $this->container->get('session')->set('userid', $user->getId());
            }
        }

        return $this->render('sectors/sectors.html.twig',
            [
                'form' => $form->createView(),
                'errors' => $errorsString ?? null
            ]
        );
    }

}