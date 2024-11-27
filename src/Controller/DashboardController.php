<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use App\Repository\SuperHerosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{

    private $superherosrepository;
    private $missionrepository;
    public function __construct(SuperHerosRepository $superherosrepository, MissionRepository $missionrepository)
    {
        $this->superherosrepository = $superherosrepository;
        $this->missionrepository = $missionrepository;
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {

        $hero=$this->superherosrepository->findall();
        $mission=$this->missionrepository->findall();

        return $this->render('dashboard/index.html.twig', [
            'heros' => $hero,
            'missions' => $mission,
        ]);
    }

    #[Route('/statistique', name: 'show_stat')]
    public function showStat(): Response
    {
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
