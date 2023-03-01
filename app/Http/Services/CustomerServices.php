<?php

namespace App\Http\Services;

use App\Mail\CustomerCreated;
use App\Models\Country;
use App\Models\Customer;
use App\Models\State;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerServices
{
    public function validateForm($request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'phone' => 'required|digits:10|numeric',
                'address_line_1' => 'required|max:255',
                'address_line_2' => 'nullable|max:255',
                'country' => 'required|max:255',
                'state' => 'required|max:255',
                'latitude' => ['required', 'numeric', 'between:-90,90', 'regex:/^[-]?([0-8]?[0-9]|90)\.[0-9]{1,15}$/'],
                'longitude' => ['required', 'numeric', 'between:-180,180', 'regex:/^[-]?([1]?[0-7]?[0-9]|[0-9]?[0-9])\.[0-9]{1,15}$/'],
                'photo' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            ],
            [
                'phone.*' => 'Invalid Phone Number',
                'latitude.*' => 'Invalid Latitude',
                'longitude.*' => 'Invalid Longitude',
            ]
        );

        if ($validator->fails()) {
            return ['success' => false, 'errorMsg' => $validator->errors()->first()];
        }

        return ['success' => true];
    }


    public function createCustomer($request)
    {
        try {

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;

            $customer->address_line_1 = $request->address_line_1;
            $customer->address_line_2 = $request->address_line_2;

            $customer->country_id = $request->country;
            $customer->state_id = $request->state;

            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;

            $customer_code = strtoupper(Str::random(8));

            while (Customer::where('customer_code', $customer_code)->exists()) {
                $customer_code = strtoupper(Str::random(8));
            }

            $customer->customer_code = $customer_code;

            if ($request->file('photo')) {

                $file = $request->file('photo');
                $file_name = time() . $file->getClientOriginalName();
                $file->move(public_path('/customers/'), $file_name);
                $customer->photo = 'customers/' . $file_name;
            }

            $customer->save();

            Mail::to('admin@gmail.com')->send(new CustomerCreated($customer));

            return ['success' => true, 'data' => $customer];

        } catch (Exception $e) {
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }


    }

    public function updateCustomer($request)
    {
        try {

            $customer = $this->getCustomer($request->id);

            if (!isset($customer->id)) {
                return ['success' => false, 'errorMsg' => 'Customer not found !'];
            }

            $customer->name = $request->name;
            $customer->phone = $request->phone;

            $customer->address_line_1 = $request->address_line_1;
            $customer->address_line_2 = $request->address_line_2;

            $customer->country_id = $request->country;
            $customer->state_id = $request->state;

            $customer->latitude = $request->latitude;
            $customer->longitude = $request->longitude;

            if ($request->file('photo')) {
                if ($customer->photo) {
                    @unlink(public_path($customer->photo));
                    $file = $request->file('photo');
                    $file_name = time() . $file->getClientOriginalName();
                    $file->move(public_path('/customers/'), $file_name);
                    $customer->photo = 'customers/' . $file_name;
                } else {
                    $file = $request->file('photo');
                    $file_name = time() . $file->getClientOriginalName();
                    $file->move(public_path('/customers/'), $file_name);
                    $customer->photo = 'customers/' . $file_name;
                }
            }

            $customer->save();

            return ['success' => true, 'data' => $customer];

        } catch (Exception $e) {
            return ['success' => false, 'errorMsg' => $e->getMessage()];
        }
    }

    public function getCountries()
    {
        return Country::with('states')->get();
    }

    public function getCountry($id)
    {
        return Country::find($id);
    }

    public function getStates($id)
    {
        return State::where('country_id', $id)->get();
    }
    public function getCustomer($id)
    {
        return Customer::where('id', $id)->first();
    }


}

