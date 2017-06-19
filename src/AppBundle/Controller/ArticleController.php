<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{

    /**
     * @Route("/article/convert", name="article_convert")
     * @Method("POST")
     * @Template()
     */
    public function convertAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
