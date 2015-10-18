<?php

namespace Your\WebApp\Controllers\ImagePanorama;

use Rhubarb\Leaf\Views\WithJqueryViewBridgeTrait;
use Rhubarb\Stem\Filters\Equals;
use Rhubarb\Stem\Repositories\MySql\MySql;
use Your\WebApp\LoginProviders\CustomLoginProvider;
use Your\WebApp\Model\Comment;
use Your\WebApp\Model\CustomUser;

class ImageCommentsPanoramaView extends ImagePanoramaView
{
    use WithJqueryViewBridgeTrait;

    protected function printViewContent()
    {
        $user = CustomLoginProvider::getLoggedInUser();
        ?>
        <div class="__container" style="padding-bottom: 10px">
            <?php

            parent::printViewContent();

            ?>
            <div class="gallery-collection-images">
                <ul>
                    <?php
                    $counter = 0;
                    foreach( $this->images as $image )
                    {
                        $class = $counter === 0 ? 'selected' : '';
                        $commentNums = MySql::returnSingleValue( "SELECT COUNT( CommentID ) FROM tblComment WHERE ImageID = '" . $image->ImageID . "'" );
                        $commentNums = $commentNums == 1 ? $commentNums . " komentārs" : $commentNums . "komentāri";
                        print '<li class="thumbnail-image-container">
                                    <a href="#' . $counter . '">
                                        <img id="img' . $counter . '" class="thumbnail-image ' . $class . '" thumb="' . $counter . '" imgID="' . $image->ImageID . '" src="' .$image->Source. '">
                                    </a>
                                    <span>' . $commentNums . ' </span>
                               </li>';
                        $counter++;
                    }
                    ?>
                </ul>
            </div>
        </div>
        <div class="comments-section">
            <div class="__title-container">
                <h1 class="comments-title">Komentāri</h1>
            </div>
            <div class="comments-bound __container noSpace">
                <?php
                    self::getCommentsForImageID( $this->images[0]->ImageID );
                ?>
            </div>
            <div class="comments-section-new __container">
                <div class="comment-outer-image">
                    <img src="<?= $user->Image ?>">
                </div>
                <textarea id="comment-input"></textarea>
                <button type="submit" id="comment-input-submit">Pievienot</button>
                <div class="__clear-floats"></div>
            </div>
        </div>
        <?php
    }

    protected function printImage( $img )
    {
        print '<div id="img-' . $img->ImageID .  '" class="image-panorama-image-container" style="width:'.$this->smallWidth.'%"><img src="' . $img->Source . '"></div>';
    }

    /**
     * Implement this and return __DIR__ when your ViewBridge.js is in the same folder as your class
     *
     * @returns string Path to your ViewBridge.js file
     */
    public function getDeploymentPackageDirectory()
    {
        return __DIR__;
    }

    public static function getCommentsForImageID( $ImageID, $print = true )
    {
        $comments = Comment::find( new Equals( 'ImageID', $ImageID ) );
        $builder = "";
        foreach( $comments as $comment )
        {
            $user = new CustomUser( $comment->PostedBy );
            $fullname = ucwords( $user->getFullName() );
            $builder .= <<<HTML
                        <div class="comment-outer">
                            <div class="comment-outer-image">
                                <img src="{$user->Image}">
                            </div>
                            <div class="comment-outer-text">
                                <div class="comment-outer-title">
                                    <span class="comment-inner-name">{$fullname}</span><span class="comment-inner-date">{$comment->PostedAt}</span>
                                </div>
                                <div class="comment-inner-text">{$comment->Comment}</div>
                            </div>
                            <div class="__clear-floats"></div>
                         </div>
                         <div class="__clear-floats"></div>
HTML;
        }
        if( $print )
        {
            print $builder;
        }
        else
        {
            return $builder;
        }
    }


}