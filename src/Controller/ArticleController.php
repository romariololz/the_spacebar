<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 14/07/18
 * Time: 09:32
 */

namespace App\Controller;


use App\Entity\Article;
use App\Service\MarkdownHelper;
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
    public function homepage(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        dump($repository);die;
        $articles = $repository->findBy([], ['publishedAt' => 'DESC']);

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @param $slug
     * @param MarkdownHelper $markdownHelper
     * @param SlackClient $slack
     * @return Response
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function show($slug, SlackClient $slack, EntityManagerInterface $em)
    {
        if ($slug == 'khaaaaaaaan')
        {
            $slack->sendMessage('Khan', 'Ah, Kirk, my old friend!');
        }

        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(['slug' => $slug]);

        if (!$article)
        {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
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
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        //TODO - actually heart/unheart the article!

        $logger->info('Article is being hearted');

        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}