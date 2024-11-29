<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\SuperHerosRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/team')]
class TeamController extends AbstractController
{
    private $teamrepository;
    private $superherosrepository;
    public function __construct(TeamRepository $teamrepository, SuperHerosRepository $superherosrepository)
    {
        $this->teamrepository = $teamrepository;
        $this->superherosrepository = $superherosrepository;
    }
    #[Route('/show', name: 'show_team')]
    public function index(): Response
    {

        $team=$this->teamrepository->findall();
        // dd($team[0]->getCurrentMission()->getTitle());

        return $this->render('team/index.html.twig', [
            'teams' => $team,
        ]);
    }
    #[Route('/create', name: 'create_team')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $team= new Team();
        $form= $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $team=$form->getData();
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('show_team');

        }
        return $this->render('team/create.html.twig', [
            'form' => $form,
            'teams' => $team,
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_team')]
    public function edit(int $id, Request $request, EntityManagerInterface $em , Team $teams): Response
    {
        $team=$this->teamrepository->find($id);
        $form= $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $team=$form->getData();
            $em->persist($team);
            $em->flush();
            return $this->redirectToRoute('show_team');
        }
        return $this->render('team/edit.html.twig', [
            'form' => $form,
            'team' => $team,
            'teams' => $teams,
        ]);
    }
    #[Route('/remove/{id}', name: 'remove_team')]
    public function remove(int $id, EntityManagerInterface $em): Response
    {
        $team=$this->teamrepository->find($id);
        $heros=$this->superherosrepository->findAll();
        $teamsMembers = $team->getMembers();
        $missions = $team->getMissions(); 
        $team->setLeader(null);
        foreach( $heros as $hero){
            foreach($teamsMembers as $teamsMember){
                if($hero == $teamsMember){
                   $team->removeMember($hero);
                } 
            }
        }
        foreach( $missions as $mission){
            if($mission == $team->getCurrentMission()){
                $team->removeMission($mission);
            }
            
        }
        $em->remove($team);
        $em->flush();
        return $this->redirectToRoute('show_team');

    }
}
