<?php

namespace App\Enums;

enum SocialiteProvider: string
{
    case GOOGLE = 'google';
    case FACEBOOK = 'facebook';
    case TWITTER = 'twitter';
}
