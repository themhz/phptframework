<?php
namespace App\Models;
use App\Components\Model;

class Newsletter_subscribers extends Model
{
    public function GetTable()
    {
        return "newsletter_subscribers";
    }
}

