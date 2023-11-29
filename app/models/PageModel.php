<?php

class PageModel extends Model
{
    function tableFill()
    {
        return 'products';
    }

    function fieldFill()
    {
        return '*';
    }

    function primaryFill()
    {
        return '';
    }

    public function getPerPageItems()
    {
        
    }
}
