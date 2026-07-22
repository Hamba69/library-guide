<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassLevel;
use App\Models\Resource;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminDashboardController extends Controller
{
    // ------------------------------------------------------------------ //
    //  DASHBOARD
    // ------------------------------------------------------------------ //

    public function index()
    {
        $stats = [
            'class_levels' => ClassLevel::count(),
            'subjects'     => Subject::count(),
            'topics'       => Topic::count(),
            'resources'    => Resource::count(),
            'verified'     => Resource::where('is_verified', true)->count(),
            'pending'      => Resource::where('is_verified', false)->count(),
            'students' => \App\Models\User::where('role', 'student')->count(),
        ];

        $recentResources = Resource::with('topic.subject.classLevel')
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentResources'));
    }

    // ------------------------------------------------------------------ //
    //  CLASS LEVELS
    // ------------------------------------------------------------------ //

    public function classLevels()
    {
        $classLevels = ClassLevel::withCount('subjects')->orderBy('name')->get();
        return view('admin.class-levels.index', compact('classLevels'));
    }

    public function storeClassLevel(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', 'unique:class_levels,name'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        ClassLevel::create($data);
        return redirect()->route('admin.class-levels')->with('success', 'Class level created successfully.');
    }

    public function updateClassLevel(Request $request, ClassLevel $classLevel)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100', Rule::unique('class_levels', 'name')->ignore($classLevel)],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $classLevel->update($data);
        return redirect()->route('admin.class-levels')->with('success', 'Class level updated successfully.');
    }

    public function destroyClassLevel(ClassLevel $classLevel)
    {
        $classLevel->delete();
        return redirect()->route('admin.class-levels')->with('success', 'Class level deleted.');
    }

    // ------------------------------------------------------------------ //
    //  SUBJECTS
    // ------------------------------------------------------------------ //

    public function subjects()
    {
        $subjects = Subject::with('classLevel')->withCount('topics')->orderBy('name')->get();
        $classLevels = ClassLevel::orderBy('name')->get();
        return view('admin.subjects.index', compact('subjects', 'classLevels'));
    }

    public function storeSubject(Request $request)
    {
        $data = $request->validate([
            'class_level_id' => ['required', 'exists:class_levels,id'],
            'name'           => ['required', 'string', 'max:150'],
            'code'           => ['nullable', 'string', 'max:20'],
        ]);

        Subject::create($data);
        return redirect()->route('admin.subjects')->with('success', 'Subject created successfully.');
    }

    public function updateSubject(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'class_level_id' => ['required', 'exists:class_levels,id'],
            'name'           => ['required', 'string', 'max:150'],
            'code'           => ['nullable', 'string', 'max:20'],
        ]);

        $subject->update($data);
        return redirect()->route('admin.subjects')->with('success', 'Subject updated successfully.');
    }

    public function destroySubject(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('admin.subjects')->with('success', 'Subject deleted.');
    }

    // ------------------------------------------------------------------ //
    //  TOPICS
    // ------------------------------------------------------------------ //

    public function topics()
    {
        $topics = Topic::with('subject.classLevel')->withCount('resources')->orderBy('title')->get();
        $subjects = Subject::with('classLevel')->orderBy('name')->get();
        return view('admin.topics.index', compact('topics', 'subjects'));
    }

    public function storeTopic(Request $request)
    {
        $data = $request->validate([
            'subject_id'              => ['required', 'exists:subjects,id'],
            'title'                   => ['required', 'string', 'max:200'],
            'competency_description'  => ['nullable', 'string'],
        ]);

        Topic::create($data);
        return redirect()->route('admin.topics')->with('success', 'Topic created successfully.');
    }

    public function updateTopic(Request $request, Topic $topic)
    {
        $data = $request->validate([
            'subject_id'              => ['required', 'exists:subjects,id'],
            'title'                   => ['required', 'string', 'max:200'],
            'competency_description'  => ['nullable', 'string'],
        ]);

        $topic->update($data);
        return redirect()->route('admin.topics')->with('success', 'Topic updated successfully.');
    }

    public function destroyTopic(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('admin.topics')->with('success', 'Topic deleted.');
    }

    // ------------------------------------------------------------------ //
    //  STUDENT ACCOUNTS
    // ------------------------------------------------------------------ //
 
    public function students()
    {
        $students = User::where('role', 'student')->orderBy('name')->get();
        return view('admin.students.index', compact('students'));
    }
 
    public function storeStudent(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:150'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);
 
        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'student',
        ]);
 
        return redirect()->route('admin.students')->with('success', 'Student account created.');
    }
 
    public function destroyStudent(User $user)
    {
        // Safety: never delete a librarian from this route
        if ($user->role !== 'student') {
            return redirect()->route('admin.students')->with('error', 'Only student accounts can be deleted here.');
        }
        $user->delete();
        return redirect()->route('admin.students')->with('success', 'Student account deleted.');
    }
 
    public function resetStudentPassword(Request $request, User $user)
    {
        $data = $request->validate([
            'password' => ['required', 'string', 'min:6'],
        ]);
 
        $user->update(['password' => Hash::make($data['password'])]);
        return redirect()->route('admin.students')->with('success', "Password reset for {$user->name}.");
    }
 

    // ------------------------------------------------------------------ //
    //  RESOURCES
    // ------------------------------------------------------------------ //

    public function resources()
    {
        $resources = Resource::with('topic.subject.classLevel')
            ->orderByDesc('created_at')
            ->paginate(20);
        $topics = Topic::with('subject')->orderBy('title')->get();
        return view('admin.resources.index', compact('resources', 'topics'));
    }

    public function storeResource(Request $request)
    {
        $data = $request->validate([
            'topic_id'      => ['required', 'exists:topics,id'],
            'title'         => ['required', 'string', 'max:255'],
            'resource_type' => ['required', Rule::in(['Link', 'PDF', 'Video', 'Simulation'])],
            'url'           => ['required', 'url', 'max:2048'],
            'annotation'    => ['nullable', 'string', 'max:2000'],
            'is_verified'   => ['boolean'],
        ]);

        $data['is_verified'] = $request->boolean('is_verified');
        Resource::create($data);
        return redirect()->route('admin.resources')->with('success', 'Resource added successfully.');
    }

    public function updateResource(Request $request, Resource $resource)
    {
        $data = $request->validate([
            'topic_id'      => ['required', 'exists:topics,id'],
            'title'         => ['required', 'string', 'max:255'],
            'resource_type' => ['required', Rule::in(['Link', 'PDF', 'Video', 'Simulation'])],
            'url'           => ['required', 'url', 'max:2048'],
            'annotation'    => ['nullable', 'string', 'max:2000'],
            'is_verified'   => ['boolean'],
        ]);

        $data['is_verified'] = $request->boolean('is_verified');
        $resource->update($data);
        return redirect()->route('admin.resources')->with('success', 'Resource updated.');
    }

    public function destroyResource(Resource $resource)
    {
        $resource->delete();
        return redirect()->route('admin.resources')->with('success', 'Resource deleted.');
    }

    /**
     * Toggle the verified flag directly (AJAX-friendly redirect fallback).
     */
    public function toggleVerify(Resource $resource)
    {
        $resource->update(['is_verified' => !$resource->is_verified]);
        return back()->with('success', 'Verification status updated.');
    }
}
