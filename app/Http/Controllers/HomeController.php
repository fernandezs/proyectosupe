<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Task;
use App\Repositories\TaskRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\GroupRepository;
use App\Repositories\UserRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $user;
    protected $tasks;
    protected $taskRepository;
    protected $projectRepository;
    protected $groupRepository;
    protected $userRepository;
    public function __construct(Task $tasks,
                                TaskRepository $taskRepository,
                                ProjectRepository $projectRepository,
                                GroupRepository $groupRepository,
                                UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->user = Auth::user();
        $this->tasks = $tasks;
        $this->taskRepository = $taskRepository;
        $this->projectRepository = $projectRepository;
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectDashboard()
    {
        return view('home');
    }
    public function index()
    {
        return Auth::user()->getDashboard(); 
    }
    public function getDashboard()
    {
        switch ($this->user->role) {
            case 'admin':
                $n_projects = $this->projectRepository->getAll()->count();
                $n_groups = $this->groupRepository->getAll()->count();
                $n_users = User::all()->count();
                $n_tasks = $this->taskRepository->getAll()->count();
                return view('users.dashboard.admin')->with('n_projects', $n_projects)
                                                       ->with('n_groups', $n_groups)
                                                       ->with('n_users', $n_users)
                                                       ->with('n_tasks', $n_tasks);;
                break;
            case 'director':
                $n_projects = $this->projectRepository->ofDirector($this->user)->count();
                $n_groups = $this->groupRepository->getOfDirector($this->user)->count();
                $n_tasks = $this->taskRepository->getOfDirector($this->user)->count();
                return view('users.dashboard.director')->with('n_projects', $n_projects)
                                                       ->with('n_groups', $n_groups)
                                                       ->with('n_tasks', $n_tasks);
                break;
            case 'investigador':
                $tasks_answers = $this->taskRepository->getTasksAnswers($this->user);
                $tasks_assigned = $this->taskRepository->getTasksAssigned($this->user);
                $tasks_overdues = $this->taskRepository->getTasksOverdues($this->user);
                return view('users.dashboard.investigador')->with('tasks_assigned', $tasks_assigned)
                                                           ->with('tasks_overdues', $tasks_overdues)
                                                           ->with('tasks_answers', $tasks_answers);
                break;
            case 'becario':
                $tasks_assigned = $this->taskRepository->getTasksAssigned($this->user);
                $tasks_overdues = $this->taskRepository->getTasksOverdues($this->user);
                return view('users.dashboard.becario')->with('tasks_assigned', $tasks_assigned)
                                                      ->with('tasks_overdues', $tasks_overdues);
                break;
            default:
                return view('home');
                break;
        }
    }
}
