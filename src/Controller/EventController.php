<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Validations\EventValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventController extends AbstractController
{
    /**
     * @var EventValidator
     */
    private $eventValidator;

    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * EventController constructor.
     * @param EventValidator $eventValidator
     * @param EventRepository $eventRepository
     */
    public function __construct(EventValidator $eventValidator, EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->eventValidator = $eventValidator;
    }

    /**
     * @Route("/api/v1/events", name="get_events" ,methods= "get" )
     */
    public function index(): JsonResponse
    {
        $events = $this->eventRepository->findAll();
        $data = [];

        foreach ($events as $event) {
            $data[] = $event->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/events", name="create_event" ,methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $violations = $this->eventValidator->validate($request);
        if (!empty($violations)) {
            return new JsonResponse(
                ['status' => 'fail',
                    'message' => $violations['message']],
                Response::HTTP_BAD_REQUEST
            );
        }

        $this->eventRepository->saveEvent(
            $request->get('name'),
            $request->get('location'),
            $request->get('attendance'),
            $request->get('period'),
            $request->get('date'),
            $request->get('type')
            );

        return new JsonResponse(['status' => 'Event created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/v1/events/{id}", name="get_event" ,methods="get")
     * @param $id
     * @return JsonResponse
     */

    public function show($id): JsonResponse
    {
        $event = $this->eventRepository->find($id);

        if ($event === null) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse(['data'=>$event->toArray()], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/events/{id}", name="update_event" ,methods="put")
     * @param $id
     * @return JsonResponse
     */

    public function update($id): JsonResponse
    {
        $event = $this->eventRepository->update($id);

        return new JsonResponse($event, Response::HTTP_OK);
    }


    /**
     * @Route("/events/{id}", name="delete_event", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);
        $this->eventRepository->removeEvent($event);

        return new JsonResponse(['status' => 'Event deleted'], Response::HTTP_NO_CONTENT);
    }
}
