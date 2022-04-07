<?php

namespace App\Repositories\Interfaces;

interface AuthInterface
{
    /**
     * @param array $credentials
     * @return object
     */
    public function auth_login(array $credentials): object;

    /**
     * @return object
     */
    public function auth_logout(): object;

    /**
     * @return object
     */
    public function auth_refresh(): object;

    /**
     * @return object
     */
    public function auth_me(): object;
}
