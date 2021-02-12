<?php

namespace Controllers;

interface IRoutes
{
    public function getRoutes(): array;
    public function getAuthenticator(): Authenticator;
    public function checkPermission($permission): bool;
}
