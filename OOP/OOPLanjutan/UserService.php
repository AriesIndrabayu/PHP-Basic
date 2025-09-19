<?php
require_once 'Logger.php';

class UserService
{
    private $logger;
    private $user;

    public function __construct(Logger $logger, $userName)
    {
        $this->logger = $logger;  // dependency injection
        $this->user = $userName;
        $this->logger->log("UserService dibuat untuk $this->user");
    }

    public function greet()
    {
        $this->logger->log("Halo, $this->user");
    }
}
