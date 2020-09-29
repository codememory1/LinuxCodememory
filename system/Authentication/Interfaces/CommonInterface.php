<?php

namespace System\Authentication\Interfaces;

interface CommonInterface
{

    const SESSION_AUTH = 'authorization';

    const SESSION_ERROR = 'auth_error';

    const PATH_TEMPLATES = 'system.Authentication.Views.%s.%s';
    
}