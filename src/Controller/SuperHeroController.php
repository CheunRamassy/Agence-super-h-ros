<?php

namespace App\Controller;

use App\Entity\SuperHeros;
use App\Form\SuperHeroType;
use App\Repository\SuperHerosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/superhero')]
class SuperHeroController extends AbstractController
{
    private $superherosrepository;
    public function __construct(SuperHerosRepository $superherosrepository)
    {
        $this->superherosrepository = $superherosrepository;
    }
    
    #[Route('/show', name: 'show_hero')]
    public function index(): Response
    {

        $hero=$this->superherosrepository->findall();

        return $this->render('super_hero/index.html.twig', [
            'heros' => $hero,
        ]);
    }

    #[Route('/create', name: 'create_hero')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $hero= new SuperHeros();
        $form= $this->createForm(SuperHeroType::class, $hero);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hero=$form->getData();
            $em->persist($hero);
            $em->flush();
            return $this->redirectToRoute('show_hero');

        }
        return $this->render('super_hero/create.html.twig', [
            'form' => $form,
            'heros' => $hero,
        ]);
    }
    #[Route('/edit/{id}', name: 'edit_hero')]
    public function edit(int $id, Request $request, EntityManagerInterface $em , SuperHeros $heros): Response
    {
        $hero=$this->superherosrepository->find($id);
        $form= $this->createForm(SuperHeroType::class, $hero);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $file = $form->get('imageName')->getData();
            $filename = $heros->getName() . '.' . $file->getClientOriginalExtension();
            $file->move($this->getParameter('kernel.project_dir') . '/public/heros/images', $filename);
            $heros->setImageName($filename);
            $hero=$form->getData();
            $em->persist($hero);
            $em->flush();
            return $this->redirectToRoute('show_hero');
        }
        return $this->render('super_hero/edit.html.twig', [
            'form' => $form,
            'hero' => $hero,
            'heros' => $heros,
        ]);
    }
    #[Route('/remove/{id}', name: 'remove_hero')]
    public function remove(int $id, EntityManagerInterface $em): Response
    {
        $hero=$this->superherosrepository->find($id);
        $em->remove($hero);
        $em->flush();
        return $this->redirectToRoute('show_hero');

    }
}
