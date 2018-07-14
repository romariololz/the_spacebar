<?php
/**
 * Created by PhpStorm.
 * User: romariololz
 * Date: 14/07/18
 * Time: 09:32
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;

class ArticleController
{
    /**
     * @return Response
     */
    public function homepage()
    {
        return new Response('OMG! My first page already! Woooo!');
    }

    /**
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        return new Response(sprintf('Future page to show the article: %s', $slug));
    }
}