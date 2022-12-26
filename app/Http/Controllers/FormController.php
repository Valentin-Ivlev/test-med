<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Edu;
use App\Models\Cert;
use App\Models\Job;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    /**
     * Create form
     *
     * @return Response
     */
    
    public function create()
    {
        return view('form');
    }

    /**
     * Store to database
     *
     * @param  Request  $request
     * @return Response
     */

    public function store(Doctor $doctorModel, Edu $eduModel, Cert $certModel, Job $jobModel, Request $request)
    {
        $request->validate([
          'doctor.city_id' => 'required|integer',
          'doctor.lmf_name' => 'required|string|min:10|max:255',
          'doctor.gender' => 'required|string',
          'doctor.phone' => 'required|string|min:16|max:16',
          'doctor.email' => 'sometimes|nullable|email|min:6|max:100',
          'doctor.speciality_id' => 'required|integer',
          'doctor.edu_city_id.0' => 'required|integer',
          'doctor.edu_org.0' => 'required|string|min:3|max:255',
          'doctor.edu_end_year.0' => 'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y'),
          'doctor.job_city_id.0' => 'required|integer',
          'doctor.job_name.0' => 'required|string|min:3|max:255',
        ]);

         $edu_count = count($request->doctor['edu_city_id']);

        if ($edu_count>1) {
          for ($i = 1; $i < $edu_count; $i++) {
            if ($request->doctor['edu_city_id'][$i]!=NULL
            or $request->doctor['edu_org'][$i]!=NULL
            or $request->doctor['edu_end_year'][$i]!=NULL) {
              $request->validate([
                'doctor.edu_city_id.'.$i => 'required|integer',
                'doctor.edu_org.'.$i => 'required|string|min:3|max:255',
                'doctor.edu_end_year.'.$i => 'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y'),
              ]);
            }
          }
        }

        $cert_count = count($request->doctor['cert_name']);

        for ($i = 0; $i < $cert_count; $i++) {
          if ($request->doctor['cert_name'][$i]!=NULL
          or $request->doctor['cert_year'][$i]!=NULL) {
            $request->validate([
              'doctor.cert_name.'.$i => 'required|string|min:3|max:255',
              'doctor.cert_year.'.$i => 'required|digits:4|integer|min:'.(date('Y')-100).'|max:'.date('Y'),
            ]);
          }
        }

        $job_count = count($request->doctor['job_city_id']);

        if ($job_count>1) {
          for ($i = 1; $i < $job_count; $i++) {
            if ($request->doctor['job_city_id'][$i]!=NULL
            or $request->doctor['job_name'][$i]!=NULL) {
              $request->validate([
                'doctor.job_city_id.'.$i => 'required|integer',
                'doctor.job_name.'.$i => 'required|string|min:3|max:255',
              ]);
            }
          }
        }

        $phone=preg_replace('/[\-\s]/i', '', $request->doctor['phone']);
        $phone=preg_replace('/^(\+7)/i', '', $phone);

        $doctor=$doctorModel->create([
          'city_id' => $request->doctor['city_id'],
          'lmf_name' => $request->doctor['lmf_name'],
          'gender' => $request->doctor['gender'],
          'phone' => $phone,
          'email' => $request->doctor['email'],
          'speciality_id' => $request->doctor['speciality_id'],
          'additional_info' => $request->doctor['additional_info']
        ]);

        for ($i = 0; $i < $edu_count; $i++) {
          if ($request->doctor['edu_city_id'][$i]!=NULL) {
            $eduModel->create([
              'doctor_id' => $doctor->id,
              'city_id' => $request->doctor['edu_city_id'][$i],
              'org' => $request->doctor['edu_org'][$i],
              'end_year' => $request->doctor['edu_end_year'][$i]
            ]);
          }
        }

        for ($i = 0; $i < $cert_count; $i++) {
          if ($request->doctor['cert_name'][$i]!=NULL) {
            $certModel->create([
              'doctor_id' => $doctor->id,
              'name' => $request->doctor['cert_name'][$i],
              'year' => $request->doctor['cert_year'][$i]
            ]);
          }
        }

        for ($i = 0; $i < $job_count; $i++) {
          if ($request->doctor['job_city_id'][$i]!=NULL) {
            $jobModel->create([
              'doctor_id' => $doctor->id,
              'city_id' => $request->doctor['job_city_id'][$i],
              'name' => $request->doctor['job_name'][$i]
            ]);
          }
        }

        if ($request->hasFile('cv_file')) {
            $file = $request->file('cv_file');
            $ext = $file->getClientOriginalExtension();
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file->move(public_path() . '/cv', $filename.'.'.$ext);
        }

        return view('doctor', $request->all());
    }
}
