<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    protected EventService $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index()
    {
        $featuredEvents = $this->eventService->getFeaturedEvents(6);
        $upcomingEvents = Event::approved()->upcoming()->orderBy('event_date')->take(8)->get();
        $latestEvents = Event::approved()->latest()->take(8)->get();
        $categories = Event::approved()->select('category')->distinct()->get()->pluck('category');
        $totalEvents = Event::approved()->count();
        $totalOrganizers = Event::approved()->select('organizer_id')->distinct()->count();

        return view('home', compact(
            'featuredEvents',
            'upcomingEvents',
            'latestEvents',
            'categories',
            'totalEvents',
            'totalOrganizers'
        ));
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function events(Request $request)
    {
        $category = $request->query('category');
        $province = $request->query('province');
        $search = $request->query('search');

        $query = Event::approved()->upcoming()->orderBy('event_date');

        if ($category) {
            $query->byCategory($category);
        }

        if ($province) {
            $query->byProvince($province);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(12)->withQueryString();
        $categories = Event::CATEGORIES;
        $provinces = Event::PROVINCES;

        return view('events.index', compact('events', 'categories', 'provinces'));
    }

    public function eventShow(string $slug)
    {
        $event = Event::where('slug', $slug)->approved()->with(['organizer'])->firstOrFail();
        $relatedEvents = Event::approved()
            ->where('category', $event->category)
            ->where('id', '!=', $event->id)
            ->upcoming()
            ->take(4)
            ->get();

        return view('events.show', compact('event', 'relatedEvents'));
    }

    /**
     * API: Search events for live dropdown.
     */
    public function searchApi(Request $request): JsonResponse
    {
        $query = $request->query('q', '');

        if (strlen($query) < 2) {
            return response()->json(['events' => []]);
        }

        $events = Event::approved()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('location', 'like', "%{$query}%")
                  ->orWhere('category', 'like', "%{$query}%");
            })
            ->upcoming()
            ->orderBy('event_date')
            ->take(8)
            ->get(['id', 'title', 'slug', 'event_date', 'location', 'category', 'event_image']);

        $events->transform(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'date' => $event->event_date->format('M d, Y'),
                'location' => $event->location,
                'category' => $event->category_name,
                'image' => $event->event_image ? Storage::url($event->event_image) : null,
            ];
        });

        return response()->json(['events' => $events]);
    }
}
