<?php

namespace App\Controller;

use Gitlab\Api\Groups;
use Gitlab\Api\Projects;
use Gitlab\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    /**
     * @Route("/{gid}", name="stat-homepage")
     */
    public function index($gid)
    {
        $stat = [];
        $statJson = [];

        $client = Client::create('https://gitlab.com/api/v4');
        $client->authenticate($_ENV['GITLAB_TOKEN'],Client::AUTH_URL_TOKEN);

        $groupsResource = new Groups($client);
        $projectResource = new Projects($client);

        $projects = $groupsResource->projects($gid);

        foreach ($projects as $project) {
            $events = $projectResource->events($project['id']);
            foreach ($events as $event) {
                if (!isset($stat[$event['author_username']])) {
                    $stat[$event['author_username']] = 0;
                }
                $stat[$event['author_username']]++;
            }
        }

        foreach ($stat as $k => $s) {
            $t = [];
            $t['user'] = $k;
            $t['q'] = $s;
            $statJson[] = $t;
        }

        return $this->render('stat/index.html.twig', [
            'stat' => $statJson,
        ]);
    }
}
