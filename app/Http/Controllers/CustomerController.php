<?php

namespace App\Http\Controllers;

use App\Http\Services\CustomerServices;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function viewCustomer()
    {
        return view('customers.viewCustomers');
    }

    public function viewAddCustomer(CustomerServices $service)
    {
        $countries = $service->getCountries();
        return view('customers.addCustomer',['countries' => $countries]);
    }

    public function addNewCustomer(Request $request, CustomerServices $service)
    {
        $validation = $service->validateForm($request);

        if (!$validation['success']) {
            return redirect()->back()->with(['error' => $validation['errorMsg']]);
        }

        $customer = $service->createCustomer($request);

        if ($customer['success']) {
            return redirect()->route('customer.viewCustomer')->with(['success' => 'Customer created successfully']);
        }

        return redirect()->route('customer.viewCustomer')->with(['error' => 'Something went wrong !']);
    }

    public function getCustomersData()
    {
        $customers = Customer::with('state','country')->orderBy('id', 'desc')->get();

        return DataTables::of($customers)
            ->addColumn('id', function ($customer) {
                return $customer->id;
            })
            ->addColumn('name', function ($customer) {
                return $customer->name;
            })
            ->addColumn('code', function ($customer) {
                return $customer->customer_code;
            })
            ->addColumn('phone', function ($customer) {
                return $customer->phone;
            })

            ->addColumn('image', function ($customer) {

                if ($customer->photo) {
                    $html = '
                        <div class="symbol symbol-50px">
                            <img src="' . asset($customer->photo) . '" style="width:5vw;object-fit:cover; " />
                        <div>';
                    return $html;
                } else {
                    $html = '
                        <div class="symbol symbol-50px">
                            <img src="' . asset('customers/avatar.jpg') . '" style="width:5vw;object-fit:cover; " />
                        <div>';
                    return $html;
                }
            })

            ->addColumn('address_1', function ($customer) {
                return $customer->address_line_1;
            })

            ->addColumn('address_2', function ($customer) {
                return $customer->address_line_2;
            })

            ->addColumn('state', function ($customer) {
                return $customer->state->name;
            })

            ->addColumn('country', function ($customer) {
                return $customer->country->name;
            })

            // ->addColumn('latitude', function ($customer) {
            //     return $customer->latitude;
            // })

            // ->addColumn('longitude', function ($customer) {
            //     return $customer->longitude;
            // })

            ->addColumn('status', function ($customer) {
                if ($customer->status) {
                    $html = 'Active';
                } else {
                    $html = 'Inactive';
                }
                return $html;
            })

            ->addColumn('action', function ($customer) {
                $html = '<td class="text-center">
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="' . route('customer.editCustomer', $customer->id) . '" class="dropdown-item"><i class="icon-pencil4"></i> Edit</a>
                                        <a class="dropdown-item" data-toggle="modal" data-target="#modal_theme_danger' . $customer->id . '"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <div id="modal_theme_danger' . $customer->id . '" class="modal fade" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                        <h6 class="modal-title">Delete Customer ' . $customer->name . '</h6>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <h6 class="font-weight-semibold">Are you sure to delete the customer ' . $customer->name . ' ?</h6>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                                        <a href="' . route('customer.deleteCustomer', $customer->id) . '" type="button" class="btn bg-danger">Yes Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                return $html;
            })

            ->rawColumns(['id', 'name', 'code', 'phone', 'image', 'address_1', 'address_2', 'state', 'country', 'action'])
            ->make(true);
    }

    public function getStates($id, CustomerServices $service)
    {
        return response()->json($service->getStates($id));
    }

    public function getCountry($id, CustomerServices $service)
    {
        return response()->json($service->getCountry($id));
    }

    public function activateCustomer($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->status = 1;
            $customer->save();

            $header = 'Success!';
            $message = 'Customer activated successfully.';
        } else {
            $header = 'Oops !';
            $message = 'Customer not found !';
        }

        return view('customers.activate',['header' => $header, 'message' => $message]);
    }

    public function editCustomer($id, CustomerServices $service)
    {
        $customer = $service->getCustomer($id);

        if (!isset($customer->id)) {
            return redirect()->back()->with(['error' => 'Customer Not Found !']);
        }

        $countries = $service->getCountries();
        return view('customers.editCustomer', ['customer' => $customer, 'countries' => $countries]);
    }

    public function updateCustomer(Request $request, CustomerServices $service)
    {
        $validation = $service->validateForm($request);

        if (!$validation['success']) {
            return redirect()->back()->with(['error' => $validation['errorMsg']]);
        }

        $customer = $service->updateCustomer($request);

        if ($customer['success']) {
            return redirect()->route('customer.viewCustomer')->with(['success' => 'Customer updated successfully']);
        }
        return redirect()->back()->with(['error' => $customer['errorMsg']]);
    }

    public function deleteCustomer($id, CustomerServices $service)
    {
        $customer = $service->getCustomer($id);

        if (!isset($customer->id)) {
            return redirect()->back()->with(['error' => 'Customer Not Found !']);
        }

        if ($customer->photo) {
            @unlink(public_path($customer->photo));
        }

        $customer->delete();

        return redirect()->back()->with(['success' => 'Customer deleted successfully']);
    }
}
