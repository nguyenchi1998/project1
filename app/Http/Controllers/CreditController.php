<?php

namespace App\Http\Controllers;

use App\Repositories\IScheduleDetailRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
{
    protected $scheduleDetailRepository;

    public function __construct(IScheduleDetailRepository $scheduleDetailRepository)
    {
        $this->scheduleDetailRepository = $scheduleDetailRepository;
    }
    public function index(Request $request)
    {
        $studentId = Auth::user()->id;
        $credits = $this->scheduleDetailRepository->where('student_id', '=', $studentId)
            ->where('result', '=', null)
            ->get();
        if ($credits) {
            $credits->load(['subject', 'schedule']);
        }

        return view('credit.index', compact('credits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $filter = $request->get('filter');
        $student = Auth::user();

        return view('credit.create', compact('filter', 'student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
