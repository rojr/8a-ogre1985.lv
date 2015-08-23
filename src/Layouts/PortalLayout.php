<?php

namespace Your\WebApp\Layouts;

use Rhubarb\Crown\Html\ResourceLoader;
use Rhubarb\Patterns\Layouts\BaseLayout;
use Your\WebApp\LoginProviders\CustomLoginProvider;

class PortalLayout extends BaseLayout
{
    function __construct()
    {
        ResourceLoader::loadResource( "/static/css/base.css" );
    }

    protected function printPageHeading()
    {
        ?>
        <style>
            body
            {
                background-image: url("/static/images/background-blur.jpg");
            }
        </style>
        <div id="content">
            <div id="portal-body">
                <div id="portal-title">
                    <div id="title">
                        <img style="float: left; height: 100%;" src="http://www.ogres1v.lv/assets/templates/ogres1vsk/img/o1v_logo.png"/>
                        <h1 style="float: left;">8a klase</h1>
                    </div>
                    <div class="__clear-floats"></div>
                    <div id="portal-title-actions">
                        <a href="/users/">Mans Profils</a> |
                        <a href="logout/">Iziet</a>
                    </div>
                </div>
                <?php
                parent::printPageHeading();
                ?>
        <?php
    }

    protected function printContent( $content )
    {
       ?>

            <div id="portal-content-body">
                <?php
                  parent::printContent( $content );
                ?>
            </div>
        </div>

        <?php
    }


    protected function printTail()
    {
        parent::printTail();

        ?>
        </div>
        <div id="tail">

        </div>
        <?php
    }
}