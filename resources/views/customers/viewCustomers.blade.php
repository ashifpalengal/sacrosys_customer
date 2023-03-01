@extends('template.master')
@section('title')
Customer List
@endsection
@section('content')
<div class="content">

    <!-- Basic datatable -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Customer List</h5>
            <div class="text-right">
                <a href="{{ route('customer.viewAddCustomer') }}" type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-popup="tooltip" title data-original-title="Add New Customer"><b><i class="icon-add"></i></b> Customer</a>
            </div>
        </div>

        <table class="table datatable-basic" id="customer_table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Address 1</th>
                    <th>Address 2</th>
                    <th>State</th>
                    <th>Country</th>
                    {{-- <th>Latitude</th>
                    <th>Longitude</th> --}}
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>


    <script>
        $(document).ready(function() {

            var customerTable = $('#customer_table');
            if ($.fn.DataTable.isDataTable(customerTable)) {
                customerTable.DataTable().clear().destroy();
            }

            var datatable = $('#customer_table').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                responsive: true,
                select: true,
                filter: true,
                order: [
                    [0, "desc"]
                ],
                ajax: '{{ route('customer.getCustomersData') }}',

                columns: [

                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: 'image'
                    },
                    {
                        data: 'address_1'
                    },
                    {
                        data: 'address_2'
                    },
                    {
                        data: 'state'
                    },
                    {
                        data: 'country'
                    },
                    // {
                    //     data: 'latitude'
                    // },
                    // {
                    //     data: 'longitude'
                    // },
                    {
                        data: 'status'
                    },
                    {
                        data: 'action'
                    },

                ],

            });
        });
    </script>


</div>
@endsection
