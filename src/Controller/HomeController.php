<?php
namespace Tornado\Controller;

use Tornado\Http\Request;
use Tornado\Http\Response;
use Tornado\Repository\UserRepository;
use Tornado\Service\View;

class HomeController
{
    public function __construct(
        private UserRepository $users,
        private View $view
    ) {}

    /**
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     */
    public function index(Request $request): Response
    {
        $tpl = $this->view->render(
            template: 'home',
            vars: ['users' => $this->users->findAll()],
            replacements: ['headline' => 'Benutzerliste']
        );

        return new Response($tpl, 200);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \ReflectionException
     */
    public function showUser(Request $request): Response
    {
        $id = $request->getRouteInfo()['uri_params']['user_id'] ?? null;
        $user = $this->users->findOne(['id' => $id]);

        $tpl = $this->view->render(
            template: 'home_single',
            replacements: ['headline' => 'Benutzer', 'username' => $user->getUsername(), 'email' => $user->getEmail()],
        );

        return new Response($tpl, 200);
    }
}
