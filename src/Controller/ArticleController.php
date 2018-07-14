<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 14/07/18
 * Time: 09:32
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @return Response
     */
    public function homepage()
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $comments = [
          'I ate a normal rock once. It did NOT taste like bacon!',
          'Woohoo! I\'m going on all-asteroid diet!',
          'I like bacon too! Buy some from my site! bakinsomebacon.com'
        ];

        return $this->render('article/show.html.twig', [
            'title'     => ucwords(str_replace('-',' ', $slug)),
            'comments'  => $comments
        ]);
    }
}