<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mission')]
class MissionController extends AbstractController
{

    private $missionrepository;
    public function __construct(MissionRepository $missionrepository)
    {
        $this->missionrepository = $missionrepository;
    }


    #[Route('/show', name: 'show_mission')]
    public function index(): Response
    {
        $mission=$this->missionrepository->findall();

        return $this->render('mission/index.html.twig', [
            'missions' => $mission,
        ]);
    }

    #[Route('/create', name: 'create_mission')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $mission= new Mission();
        $form= $this->createForm(MissionType::class, $mission);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mission=$form->getData();
            $em->persist($mission);
            $em->flush();
            return $this->redirectToRoute('show_mission');

        }
        return $this->render('mission/create.html.twig', [
            'form' => $form,
            'missions' => $mission,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_mission')]
    public function edit(int $id, Request $request, EntityManagerInterface $em , Mission $missions): Response
    {
        $mission=$this->missionrepository->find($id);
        $form= $this->createForm(MissionType::class, $mission);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $mission=$form->getData();
            $em->persist($mission);
            $em->flush();
            return $this->redirectToRoute('show_mission');
        }
        return $this->render('mission/edit.html.twig', [
            'form' => $form,
            'mission' => $mission,
            'missions' => $missions,
        ]);
    }

    #[Route('/remove/{id}', name: 'remove_mission')]
    public function remove(int $id, EntityManagerInterface $em): Response
    {
        $mission=$this->missionrepository->find($id);
        $em->remove($mission);
        $em->flush();
        return $this->redirectToRoute('show_mission');

    }
}
