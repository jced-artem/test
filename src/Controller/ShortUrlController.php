<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Form\ShortUrlType;
use App\Service\Shortener;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShortUrlController extends AbstractController
{
    /**
     * @Route("/", name="short_url_index", methods={"GET"})
     */
    public function index(): Response
    {
        $shortUrls = $this->getDoctrine()
            ->getRepository(ShortUrl::class)
            ->findAll();

        return $this->render('short_url/index.html.twig', [
            'short_urls' => $shortUrls,
        ]);
    }

    /**
     * @Route("/new", name="short_url_new", methods={"GET","POST"})
	 *
	 * @param Request $request
	 * @param Shortener $shortener
	 * @return Response
	 */
    public function new(Request $request, Shortener $shortener): Response
    {
        $shortUrl = new ShortUrl();
        $form = $this->createForm(ShortUrlType::class, $shortUrl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        	$shortUrl->setCode('tmp');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($shortUrl);
            $entityManager->flush();

            $shortUrl->setCode($shortener->create($shortUrl->getId()));
			$entityManager->flush();

            return $this->redirectToRoute('short_url_index');
        }

        return $this->render('short_url/new.html.twig', [
            'short_url' => $shortUrl,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="short_url_redirect", methods={"GET"})
     */
    public function show(string $id): Response
    {
    	/** @var ShortUrl $shortUrl */
    	$shortUrl = $this->getDoctrine()->getRepository(ShortUrl::class)->findOneByCode($id);
    	if (empty($shortUrl) or $shortUrl->getExpiresAt() < new \DateTime()) {
    		throw $this->createNotFoundException();
		}

    	$shortUrl->setHits($shortUrl->getHits() + 1);
		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->flush();

        return $this->render('short_url/redirect.html.twig', [
            'short_url' => $shortUrl,
        ]);
    }
}
