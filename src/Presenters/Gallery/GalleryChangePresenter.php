<?php

namespace Your\WebApp\Presenters\Gallery;

use Rhubarb\Crown\Layout\LayoutModule;
use Rhubarb\Patterns\Mvp\Crud\ModelForm\ModelFormPresenter;
use Your\WebApp\Layouts\PortalLayout;

class GalleryChangePresenter extends ModelFormPresenter
{
    protected function createView()
    {
        LayoutModule::setLayoutClassName( PortalLayout::class );
        return new GalleryChangeView();
    }
}