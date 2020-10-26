<?php

namespace App\Validations;

class ArticleRequestValidation
{
    public static function getRules()
    {
        return [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'photo'   => 'sometimes|image|mimes:png,jpeg|max:200',
            "tags"    => "array|max:5",
            "tags.*"  => 'sometimes|regex:/^[a-zA-Z0-9_\-]*$/'
        ];
    }

    public static function getMessages()
    {
        return [
            'tags.*.regex' => 'Only alphanumeric tags are allowed.'
        ];
    }
}