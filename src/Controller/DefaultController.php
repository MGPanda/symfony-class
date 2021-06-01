<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Service\MovieService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/movie", name="moviesPage")
     * @param MovieService $movieService
     * @return Response
     */
    public function moviesPage(MovieService $movieService): Response
    {
        $movies = $movieService->getPopularMovies();
        return $this->render('movies/moviesPage.html.twig', [
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movieDetailPage")
     */
    public function movieDetailPage(MovieService $movieService, $id): Response
    {
        $movie = $movieService->getMovieById($id);
        $recommendations = $movieService->getRecommendations($id);
        $recommendations = array_slice($recommendations, 0, 10);
        return $this->render('movies/movieDetailPage.html.twig', [
            'movie' => $movie,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * @Route("/movieform")
     * @IsGranted("ROLE_USER")
     */
    public function movieFormPage(EntityManagerInterface $entityManager, Request $request) {
        $form = $this->createForm(MovieFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movie = $form->getData();
            $entityManager->persist($movie);
            $entityManager->flush();
        }

        return $this->render('movies/movieFormPage.html.twig', ['form'=>$form->createView()]);
    }

    /**
     * @Route("/mymovies")
     * @IsGranted("ROLE_USER")
     */
    public function myMoviesPage(EntityManagerInterface $entityManager): Response
    {
//        $this->getUser();
        $repository = $entityManager->getRepository(Movie::class);
        $movies = $repository->findAll();
        return $this->render('movies/myMoviesPage.html.twig', ['movies'=>$movies]);
    }


}