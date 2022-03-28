<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    
    public function courseRegistration(Request $request)
    {
        
        $this->validate($request,[
            'course_id'=>'required|exists:courses,id',
            'student_id' => 'required|exists:students,id|unique:registrations,student_id,NULL,id,course_id,'.$request->course_id
        ],['student_id.unique'=>'This student already registered for this course']);
        
        
        $slotsInfo=$this->checkCourseAvailibility($request->course_id);

        $capacity=$slotsInfo[0];
        $enrollements=$slotsInfo[1];
        if($enrollements >= $capacity){
            DB::table('courses')->where('id',$request->course_id)->update(['availibility'=>'No']);
            return response()->json(['error'=>'There is no available slots for this course!']);

        }
       
        $data=[];
        $data['student_id']=$request->student_id;
        $data['course_id']=$request->course_id;
        DB::table('registrations')->insert($data);
        DB::table('courses')->where('id',$request->course_id)->update(['enrollments'=>$enrollements+1]);
        return response()->json(['success'=>'Successfully registered for the course!']);

    }

    public function checkCourseAvailibility($courseId){
        $course = Course::findOrfail($courseId);
        $capacity=$course['capacity'];
        $registerdCount=0;
        $regInfo=[];
        $registerdCount= DB::table('registrations')->where('course_id',$courseId)->count();
        $regInfo=[$capacity,$registerdCount];
        
        return $regInfo;

    }

  

   
}
