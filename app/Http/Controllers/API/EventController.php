<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest; // Ganti dengan UpdateEventRequest saat update
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function __construct(private EventService $eventService)
    {
    }

    // --- Endpoint Publik ---
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $events = $this->eventService->getPublicEvents($perPage);
        return response()->json($events);
    }

    // --- Endpoint Admin ---
    public function indexAdmin(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 10);
        $events = $this->eventService->getAllEventsAdmin($perPage);
        return response()->json($events);
    }

    public function store(StoreEventRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        if ($request->hasFile('hero_image_url')) {
            $validatedData['hero_image_url'] = $request->file('hero_image_url');
        }

        $event = $this->eventService->createEvent($validatedData);
        return response()->json($event, Response::HTTP_CREATED);
    }

    public function update(StoreEventRequest $request, Event $event): JsonResponse
    {
        // Sebaiknya gunakan UpdateEventRequest di sini
        $validatedData = $request->validated();
        if ($request->hasFile('hero_image_url')) {
            $validatedData['hero_image_url'] = $request->file('hero_image_url');
        }
        
        $updatedEvent = $this->eventService->updateEvent($event, $validatedData);
        return response()->json($updatedEvent);
    }

    public function destroy(Event $event): Response
    {
        $this->eventService->deleteEvent($event);
        return response()->noContent();
    }
}