<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 14/07/18
 * Time: 09:32
 */

namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    private $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    /**
     * @return Response
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest();

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @param Article $article
     * @param SlackClient $slack
     * @return Response
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() == 'khaaaaaaaan')
        {
            $slack->sendMessage('Khan', 'Ah, Kirk, my old friend!');
        }

        $comments = [
          'I ate a normal rock once. It did NOT taste like bacon!',
          'Woohoo! I\'m going on all-asteroid diet!',
          'I like bacon too! Buy some from my site! bakinsomebacon.com'
        ];

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments'  => $comments
        ]);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function toggleArticleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();

        $em->flush();

        $logger->info('Article is being hearted');

        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}