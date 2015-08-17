<?php

namespace Your\WebApp\Controllers\ImagePanorama;

use Your\WebApp\LoginProviders\CustomLoginProvider;
use Your\WebApp\Model\Comment;
use Your\WebApp\Model\Image;

class ImageCommentsPanorama extends ImagePanorama
{

    /**
     * @param $imageUrls Image[]
     * @param string $name
     */
    public function __construct($images, $name = "")
    {
        parent::__construct($images, $name);
    }

    protected function createView()
    {
        $view =new ImageCommentsPanoramaView( $this->imgs );



        return $view;
    }

    protected function configureView()
    {

        $this->view->attachEventHandler( 'PostComment', function( $commentText, $imageID )
        {
            $comment = new Comment();
            $comment->ImageID = $imageID;
            $comment->Comment = $commentText;
            $comment->PostedBy = CustomLoginProvider::getLoggedInUser()->UserID;
            $comment->save();
        });

        return parent::configureView();
    }
}