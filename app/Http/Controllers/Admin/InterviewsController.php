<?php

namespace App\Http\Controllers\Admin;

use App\Model\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admission;
use Auth;

class InterviewsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function create() {

        $types = Admission::all();
        return view('admin.interviews.create', compact('types'));

    }

    public function index() {

        $interviews = Interview::distinct('admission_id')->get();
        //dd($interviews);
        return view('admin.interviews.index', compact('interviews'));

    }

    public function show() {
        $interviews = Interview::where('user_id', auth()->id())->get();
        return view('admin.interviews.show', compact('interviews'));
    }

    public function interviews() {
        $interviews = Interview::all();
        return view('admin.interviews.interviews', compact('interviews'));
    }

    public function ajaxReq() {

        $data = request()->validate([
            'date' => 'required|date',
            'id' => 'required|integer'
        ]);
        $posibleTime = [9, 10, 11, 12, 13, 14];
        $time = Interview::where('date', \request('date'))->where('admission_id', \request('id'))->pluck('time')->all();
        $timeVal = array_diff($posibleTime, $time);

        $html = '<div class="form-group">
                    <label>Interview time</label>
                        <select class="form-control" name="time" id="typeId">
                            <option value="">-- Choose interview type --</option>';

        foreach ($timeVal as $value) {
            $html .= '<option value=' . $value . '>' . $value . ':00h</option >';
         }

        $html .= '</select></div>';

        return $html;
    }

    public function store() {
        $user = Auth::getUser();
        $posibleTime = "9, 10, 11, 12, 13, 14";
        $possibleInt = Interview::where('user_id', $user['id'])->pluck('admission_id')->all();
        $admissionId = Admission::pluck('id')->all();
        $interviews = array_diff($admissionId, $possibleInt);
        $interviews = implode(',', $interviews);

        $data = request()->validate([
            'admission_id' => 'required|integer|in:' . $interviews,
            'date' => 'required|date',
            'time' => 'required|integer|in:'. $posibleTime
        ]);
        $data['user_id'] = $user['id'];

        Interview::create($data);

        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully aplied for interview!!!');

        return redirect()->route('interviews.show');
    }

    public function changestatus(Interview $interview){
        $possibleValues = '0,1,2';
        request()->validate(array(
            'status' => 'required|string|in:'.$possibleValues
        ));

        $interview->status = request()->status;
        $interview->staff_id = auth()->user()->id;
        if(request('status') == 2) {
            $interview->date = '1975-01-01';
            $interview->time = 0;
        }
        $interview->save();
        session()->flash('message-type', 'success');
        session()->flash('message-text', 'Successfully changed status for interview ' . $interview->admission->name . '!!!');

        return back();

    }

}
