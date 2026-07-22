<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ClassLevel;
use App\Models\Resource;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Homepage – show all class levels.
     */
    public function index()
    {
        $classLevels = ClassLevel::withCount('subjects')->orderBy('name')->get();
        return view('browse.index', compact('classLevels'));
    }

    /**
     * Show all subjects for a given class level.
     */
    public function showClassLevel(ClassLevel $classLevel)
    {
        $subjects = $classLevel->subjects()->withCount('topics')->orderBy('name')->get();
        return view('browse.class-level', compact('classLevel', 'subjects'));
    }

    /**
     * Show all topics for a given subject.
     * Note: $classLevel is received as a string (the ID) — we don't need it here,
     * Laravel resolves $subject via model binding on the second segment.
     */
    public function showSubject(string $classLevel, Subject $subject)
    {
        $subject->load('classLevel');
        $topics = $subject->topics()->withCount('resources')->orderBy('title')->get();
        return view('browse.subject', compact('subject', 'topics'));
    }

    /**
     * Show all verified resources for a given topic.
     */
    public function showTopic(string $classLevel, string $subject, Topic $topic)
    {
        $topic->load('subject.classLevel');
        $resources = $topic->verifiedResources()->orderBy('resource_type')->get();
        return view('browse.topic', compact('topic', 'resources'));
    }

    /**
     * Full-text search across resource titles and annotations.
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');
        $results = collect();

        if (strlen(trim($query)) >= 2) {
            $results = Resource::where('is_verified', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                      ->orWhere('annotation', 'like', "%{$query}%");
                })
                ->with('topic.subject.classLevel')
                ->orderBy('title')
                ->paginate(15)
                ->withQueryString();
        }

        return view('browse.search', compact('query', 'results'));
    }
}