<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Repository\ProjetsRepository;
use App\Entity\Projets;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Controller\LoginController;
use App\Entity\Taches;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProjetsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class ProjetsController extends AbstractController
{       
    #[Route('/', name: 'app_projets')]
    public function listingproject(TokenStorageInterface $tokenStorage, AuthenticationUtils $authenticationUtils): Response
    {
        if($this->container->get('security.token_storage')->getToken() !== null)
        {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $projets = $user->GetSesProjets();
            if(isset($projets)){
                return $this->render('projets/index.html.twig', [
                    'projets' => $projets,
                ]);
            }
        }else{
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('login/index.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]);
        }          
    }   
        #[Route('projets/new', name: 'app_projets_new', methods: ['GET', 'POST'])]
        public function new(Request $request, EntityManagerInterface $entityManager): Response
        {
            $projet = new Projets();
            $form = $this->createForm(ProjetsType::class, $projet);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($projet);
                $entityManager->flush();

                return $this->redirectToRoute('app_projets', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('projets/new.html.twig', [
                'projet' => $projet,
                'form' => $form,
            ]);
        }

        #[Route('projets/{id}', name: 'app_projets_show', methods: ['GET'])]
        public function show(Projets $projet): Response
        {
            return $this->render('projets/show.html.twig', [
                'projet' => $projet,
            ]);
        }

        #[Route('projets/{id}/edit', name: 'app_projets_edit', methods: ['GET', 'POST'])]
        public function edit(Request $request, Projets $projet, EntityManagerInterface $entityManager): Response
        {
            $form = $this->createForm(ProjetsType::class, $projet);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->flush();

                return $this->redirectToRoute('app_projets', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('Projets/edit.html.twig', [
                'projet' => $projet,
                'form' => $form,
            ]);
        }

        #[Route('projets/{id}', name: 'app_projets_delete', methods: ['POST'])]
        public function delete(Request $request, Projets $projet, EntityManagerInterface $entityManager): Response
        {
            if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
                $entityManager->remove($projet);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_projets', [], Response::HTTP_SEE_OTHER);
        }

        #[Route('projets/{id}/task', name: 'app_taches_ofproject', methods: ['GET'])]
        public function listingtaches(Projets $Projet): Response
        {
            $tachesafaire = array();
            $tachesencours = array();
            $tachesterminee = array();
            foreach($Projet->getTaches() as $taches){
                if($taches->getIdStatut()->getLibelle() === "à faire"){
                    array_push($tachesafaire,$taches);
                }
                else if ($taches->getIdStatut()->getLibelle() === "en cours"){
                    array_push($tachesencours,$taches);
                }
                else if ($taches->getIdStatut()->getLibelle() === "terminée"){
                    array_push($tachesterminee,$taches);
                }
            }
            return $this->render('taches/index.html.twig', [
                'tachesafaire' => $tachesafaire,
                'tachesencours' => $tachesencours,
                'tachesterminee' => $tachesterminee,
                'projet' => $Projet,
            ]);  
        }
}
