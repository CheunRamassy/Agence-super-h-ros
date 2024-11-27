<?php

namespace App\Controller;

use App\Repository\SuperHerosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{

    private $superherosrepository;
    public function __construct(SuperHerosRepository $superherosrepository)
    {
        $this->superherosrepository = $superherosrepository;
    }

    #[Route('/', name: 'app_dashboard')]
    public function index(): Response
    {

        $hero=$this->superherosrepository->findall();

        return $this->render('dashboard/index.html.twig', [
            'hero' => $hero,
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
