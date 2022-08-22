<?php

namespace App\Traits;

trait Trans
{
    public function getTransNameAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)[app()->currentLocale()];
        }
        return $this->name;
    }

    public function getNameEnAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['en'];
        }
        return '';
    }

    public function getNameArAttribute()
    {
        if($this->name) {
            return json_decode($this->name, true)['ar'];
        }

        return '';
    }


    // Content

    public function getTransContentAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)[app()->currentLocale()];
        }
        return $this->content;
    }

    public function getContentEnAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)['en'];
        }
        return '';
    }

    public function getContentArAttribute()
    {
        if($this->content) {
            return json_decode($this->content, true)['ar'];
        }

        return '';
    }
}
