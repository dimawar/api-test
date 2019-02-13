<?php

namespace App\Infrastructure\Http\Rest\Controller;


use App\Application\Service\ApiService;
use App\Domain\Model\Group\Group;
use App\Domain\Model\User\User;
use App\Infrastructure\Form\Type\GroupType;
use App\Infrastructure\Form\Type\UserType;
use App\Infrastructure\Repository\GroupRepository;
use App\Infrastructure\Repository\UserRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ArticleController
 * @package App\Infrastructure\Http\Rest\Controller
 */
final class ApiController extends FOSRestController
{
    /**
     * @var ApiService
     */
    private $apiService;
    private $userRepository;
    private $groupRepository;

    /**
     * ApiController constructor.
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService, UserRepository $userRepository, GroupRepository $groupRepository)
    {
        $this->apiService = $apiService;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
    }

    /**
     * Creates an User resource
     * @Rest\Post("/users/")
     * @return View
     */
    public function postUser(Request $request): View
    {
        $data = json_decode($request->getContent(), true);
        var_dump($data);die();
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);
            $data = unserialize($user->serialize());
            return View::create($data, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
    }

    /**
     * Retrieves an User resource
     * @Rest\Get("/users/{userId}/")
     * @param int $userId
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getUserById(int $userId): View
    {
        $user = $this->apiService->getUser($userId);

        $data = unserialize($user->serialize());
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($data, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of User resource
     * @Rest\Get("/users")
     * @return View
     */
    public function getUsers(): View
    {
        $users = $this->apiService->getAllUsers();

        $data = [];
        foreach ($users as $user) {
            $data[] = unserialize($user->serialize());
        }


        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of user object
//        return View::create($users, Response::HTTP_OK);
        return View::create($data, Response::HTTP_OK);
    }

    /**
     * Replaces User resource
     * @Rest\Put("/users/{userId}")
     * @param int $userId
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function putUser(int $userId, Request $request): View
    {
        $user = $this->apiService->getUser($userId);
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);
            $data = unserialize($user->serialize());
            return View::create($data, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
    }

    /**
     * Creates an Group resource
     * @Rest\Post("/groups/")
     * @return View
     */
    public function postGroup(Request $request): View
    {
        $data = json_decode($request->getContent(), true);
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupRepository->save($group);
            $data = unserialize($group->serialize());
            return View::create($data, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
    }

    /**
     * Retrieves a collection of Group resource
     * @Rest\Get("/groups")
//     * @return View
     */
//    public function getGroups(): View
    public function getGroups()
    {
        $groups = $this->apiService->getAllGroups();

        $data = [];
        foreach ($groups as $group){
            $data[] = unserialize($group->serialize());
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of group object
//        return View::create($groups, Response::HTTP_OK);
        return View::create($data, Response::HTTP_OK);
    }

    /**
     * Replaces Group resource
     * @Rest\Put("/groups/{groupId}")
     * @param int $groupId
     * @return View
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function putGroup(int $groupId, Request $request): View
    {
        $group = $this->apiService->getGroup($groupId);
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(GroupType::class, $group);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->groupRepository->save($group);
            $data = unserialize($group->serialize());
            return View::create($data, Response::HTTP_CREATED);
        }

        return View::create($form->getErrors(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
    }

}
