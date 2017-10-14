<?php

namespace Rafni\Auth\Exceptions;

use Illuminate\Contracts\Auth\Guard;
use Exception;

class ForbiddenUserException extends Exception
{
    /**
     * Guard that were checked.
     *
     * @var array
     */
    protected $guard;

    /**
     * Create a new authentication exception.
     *
     * @param  string  $message
     * @param  array  $guard
     * @return void
     */
    public function __construct($message = 'Forbidden user', Guard $guard = null)
    {
        parent::__construct($message, 403);
        
        $this->guard = $guard;
    }

    /**
     * Get the guards that were checked.
     *
     * @return array
     */
    public function guard()
    {
        return $this->guard;
    }
    
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()
                ->view('auth::errors.auth.forbidden-user', [], 403);
    }
}
