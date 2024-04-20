<?php

namespace App\Controller;

use classes\GraphqlServer;

class GraphQL
{
    static public function handle()
    {
        $server = GraphqlServer::get();
        $server->handleRequest();
    }
}
