<?php

namespace App\Http\Controllers\Admin\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor\DoctorScheduleDay;
use App\Models\Doctor\DoctorScheduleHour;
use App\Models\Doctor\DoctorScheduleJoinHour;
use App\Models\Doctor\Specialitie;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function config(){
        $roles = Role::all();
        $specialities = Specialitie::where("state",1)->get();
        $hours_days = collect([]);

        $doctor_schedule_hours = DoctorScheduleHour::all();
        

        foreach($doctor_schedule_hours->groupBy("hour") as $key => $schedule_hour){
           // dd($schedule_hour);
            $hours_days->push([
                "hour" =>  $key,
                "format_hour" => Carbon::parse(date("Y-m-d").''. $key.":00:00")->format("h:i A")  ,
                "items" => $schedule_hour->map(function($hour_item){
                    // Y-m-d h:i:s 2023-10-2 00:13:30
                    return [
                        "id" => $hour_item->id ,
                        "hour_start" => $hour_item->hour_start,
                        "hour_end" => $hour_item->hour_end,
                        "format_hour_start" => Carbon::parse(date("Y-m-d").''. $hour_item->hour_start)->format("h:i A") ,
                        "format_hour_end" => Carbon::parse(date("Y-m-d").''. $hour_item->hour_end)->format("h:i A") ,
                        "hour" => $hour_item->hour ,
                        
                    ];
                }),
            ]);

        }
        return response()->json([
            "roles" => $roles,
            "specialities" => $specialities,
            "hours_days" => $hours_days
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $schedule_hours = json_decode( $request->schedule_hours,1);

        $users_is_valid = User::where("email",$request->email)->first();
        if( $users_is_valid){
            return response()->json([
                "message" => 403,
                "message_text" => "EL USUARIO CON ESTE MAIL YA EXISTE"
            ]);
        }

        if($request->hasFile("imagen")){
            $path = Storage::putFile("staffs",$request->file("imagen"));
            $request->request->add(["avatar" => $path]);
        }

        if($request->password){
            $request->request->add(["password",bcrypt($request->password)]);   
        }

       // $request->request->add(["birth_date" => Carbon::parse($request->birth_date, 'GMT-0500')->format("Y-m-d h:i:s")]);
        
        $date_clean = preg_replace("/\(.*\)|[A-Z]{3}-\d{4}/", '', $request->birth_date);
 
        $request->request->add(["birth_date" => Carbon::parse($date_clean)->format("Y-m-d h:i:s")]);


        $user = User::create($request->all());

        $role = Role::findOrFail($request->role_id);

        $user->assignRole($role);
        

        //almacenar la disponibilidad de horario del doctor

        foreach ($schedule_hours as $key => $schedule_hour) {
            
           if(sizeof($schedule_hour["children"]) > 0){ //sizeof sirve para contar el nro 
            $schedule_day =  DoctorScheduleDay::create([
                "user_id" => $user->id,
                "day" =>$schedule_hour["day_name"],
            ]);

            foreach ($schedule_hour["children"] as $children) {
                DoctorScheduleJoinHour::create([
                    "doctor_schedule_day_id" => $schedule_day->id,
                    "doctor_schedule_hour_id" => $children["item"]["id"],
                ]);
            }
           }
        }
        return response()->json([
            "message" => 200
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
