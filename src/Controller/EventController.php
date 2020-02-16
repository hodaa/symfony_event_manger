<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Validations\EventValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Exception\ValidatorException;

/**
 * Class EventController
 * @package App\Controller
 */
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
     * @Route("/", name="home" ,methods= "get" )
     */
    public function Home()
    {
        return $this->render('event/index.html.twig');
    }

    /**
     * @Route("/api/v1/events", name="get_events" ,methods= "get" )
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return JsonResponse
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $events = $this->eventRepository->findAll();
        $limit = $request->query->get('limit') ??  20;
        $page = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $events, /* query NOT result */
            $page, /*page number*/
            $limit /*limit per page*/
        );


        foreach ($pagination->getItems() as $item) {
            $data[] = $item->toArray();
        }
        $data['total'] = $pagination->getTotalItemCount();
        $data['page'] = $pagination->getCurrentPageNumber();
        return new JsonResponse(['data' => $data], Response::HTTP_OK);
    }




    /**
     * @Route("/api/v1/events", name="create_event" ,methods="POST")
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $violations = $this->eventValidator->validateRequest($request);
        if (count($violations) > 0) {
            return new JsonResponse(['status' => 'fail',
                'validations' => $violations], Response::HTTP_BAD_REQUEST);

        }

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

        return new JsonResponse(['status' => 'success','message' => "Event created"], Response::HTTP_CREATED);
    }

    /**
     * @param $value
     * @param $constraints
     * @return \Symfony\Component\Validator\ConstraintViolationListInterface
     */
    protected function validate($value, $constraints)
    {
        $validator = Validation::createValidator();
        return $validator->validate($value, $constraints);
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

        return new JsonResponse(['data' => $event->toArray()], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/events/{id}", name="update_event" ,methods="put")
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */

    public function update($id, Request $request): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        if ($event === null) {
            throw new NotFoundHttpException();
        }
        $data = $request->request->all();
        $event = $this->eventRepository->updateEvent($event, $data);

        return new JsonResponse(['data' => $event], Response::HTTP_OK);
    }


    /**
     * @Route("api/v1/events/{id}", name="delete_event", methods="DELETE")
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);
        if ($event === null) {
            throw new NotFoundHttpException();
        }

        $this->eventRepository->removeEvent($event);

        return new JsonResponse(['status' => 'Event deleted'], Response::HTTP_NO_CONTENT);
    }
}
