<?php

namespace App\Controller;

use App\Entity\SuperHeros;
use App\Entity\Team;
use App\Repository\MissionRepository;
use App\Repository\SuperHerosRepository;
use App\Repository\TeamRepository;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/home')]
class DashboardController extends AbstractController
{

    private $superherosrepository;
    private $missionrepository;
    private $teamrepository;
    public function __construct(SuperHerosRepository $superherosrepository, MissionRepository $missionrepository, TeamRepository $teamrepository)
    {
        $this->superherosrepository = $superherosrepository;
        $this->missionrepository = $missionrepository;
        $this->teamrepository = $teamrepository;
    }

    #[Route('/dashboard', name: 'show_dashboard')]
    public function index(): Response
    {

        $hero=$this->superherosrepository->findall();
        $mission=$this->missionrepository->findall();
        $team=$this->teamrepository->findall();

        return $this->render('dashboard/dashboard.html.twig', [
            'heros' => $hero,
            'missions' => $mission,
            'teams' => $team,
        ]);
    }

    #[Route('/statistique', name: 'show_stat')]
    public function showStat(ChartBuilderInterface $chartBuilder): Response
    {
        $hero=$this->superherosrepository->findall();
        $mission=$this->missionrepository->findall();
        $team=$this->teamrepository->findall();

        //for on parcours toute la liste des missions
        //si la mission.status == Success
        //si la mission.date == à la date d'aujourd'hui ou à la même date
        //for on parcourir le tableau des héros[i]
        //for on parcourir le tableau des team[j]
        //si team[j].leader.id ou team[j].member.id == heros[i].id et héros[j].id
        //on fait +1 aux Team[j].tauxSuccessTeam et Héros[i].tauxSuccessHeros
        //sinon on passe à l'indice suivant Team.tauxSuccessTeam[+1] et Héros.tauxSuccessHeros[+1]
        //si team.leader ou team.member == heros.nom
        //on fait +1 aux Team[j].tauxSuccessTeam et Héros[i].tauxSuccessHeros

        $i=0;
        $tab_taux = [0];
        $date= new \DateTimeImmutable();
        foreach ( $mission as $status ){
            $typeStatus = $status->getStatus()->name;
            if($typeStatus == "EN_COURS"){
                // if($status->getStartAt() || $status->getEndAt() === $date){
                    // dd($date, $status->getStartAt(), $status->getEndAt());
                    foreach( $hero as $heros){
                        foreach($team as $teams){
                            $membres=$teams->getMembers();
                            foreach($membres as $membre){
                                if($teams->getLeader() || $teams->getMembers() == $heros->getId()){
                                    $k=0 +1;
                                    $tab_taux[$i] += 1;
                                    $teams->setReussite($tab_taux);
                                    $heros->setReussite($tab_taux);
    
                                    
                                }
                            }
 
                            
                        }
                    }
                } else {
                if( $tab_taux[$i] == null){
                    $k=0 +1;
                    foreach( $hero as $heros){
                        foreach($team as $teams){
                            $membres=$teams->getMembers();
                            foreach($membres as $membre)
                            if($teams->getLeader() || $teams->getMembers() == $heros->getId()){
                                $tab_taux[$i] += 1;
                                $teams->setReussite($tab_taux);
                                $heros->setReussite($tab_taux);
                                dd($teams->getReussite());
                            }
                        }
                    }
                } else {
                    $i+1;
                }

                }
            }
        // }

        // dd($k);

        $chartHero = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chartHero->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [2,3,5],
                ],
            ],
        ]);

        $chartHero->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        $chartTeam = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chartTeam->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chartTeam->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        
        return $this->render('dashboard/statistique.html.twig', [
            'chart' => $chartHero,
            'chart' => $chartTeam,
            'heros' => $hero,
            'teams' => $team,
        ]);
    }
}
