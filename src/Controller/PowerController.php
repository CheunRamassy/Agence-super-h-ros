<?php

namespace App\Controller;

use App\Entity\Power;
use App\Form\PowerType;
use App\Repository\PowerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/power')]
class PowerController extends AbstractController
{

    private $powerrepository;
    public function __construct(PowerRepository $powerrepository)
    {
        $this->powerrepository = $powerrepository;
    }

    #[Route('/show', name: 'show_power')]
    public function index(): Response
    {

        $power=$this->powerrepository->findall();
        // dd($power[0]->getCurrentMission()->getTitle());

        return $this->render('power/index.html.twig', [
            'powers' => $power,
        ]);
    }
    #[Route('/create', name: 'create_power')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $power= new Power();
        $form= $this->createForm(PowerType::class, $power);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $power=$form->getData();
            $em->persist($power);
            $em->flush();
            return $this->redirectToRoute('show_power');

        }
        return $this->render('power/create.html.twig', [
            'form' => $form,
            'powers' => $power,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_power')]
    public function edit(int $id, Request $request, EntityManagerInterface $em , Power $powers): Response
    {
        $power=$this->powerrepository->find($id);
        $form= $this->createForm(PowerType::class, $power);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $power=$form->getData();
            $em->persist($power);
            $em->flush();
            return $this->redirectToRoute('show_power');
        }
        return $this->render('power/edit.html.twig', [
            'form' => $form,
            'power' => $power,
            'powers' => $powers,
        ]);
    }
    #[Route('/remove/{id}', name: 'remove_power')]
    public function remove(int $id, EntityManagerInterface $em): Response
    {
        $hero=$this->powerrepository->find($id);
        $em->remove($hero);
        $em->flush();
        return $this->redirectToRoute('show_power');

    }
}
