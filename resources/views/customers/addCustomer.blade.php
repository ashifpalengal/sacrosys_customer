@extends('template.master')
@section('title')
Add Customer
@endsection
@section('content')
<div class="content">
    <div class="row ">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Add New Customer</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('customer.addNewCustomer') }}" method="POST" enctype="multipart/form-data">
                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Name <label class="text-danger">*</label></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter Customer Name" name="name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Contact <label class="text-danger">*</label></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter Customer Contact Number" name="phone" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Photo </label>
                            <div class="col-lg-10">
                                <input type="file" class="form-input-styled" data-fouc name="photo" accept=".png,.jpg,.jpeg">
                                <span class="form-text text-muted">Accepted formats: png, jpg, jpeg. Max file size 2Mb</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Address Line 1 <label class="text-danger">*</label></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter Address Line 1" name="address_line_1" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Address Line 2</label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter Address Line 2" name="address_line_2">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Country <label class="text-danger">*</label></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select class="form-control form-control-select2" data-fouc name="country" required id="country">
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach ($countries as $country)
                                        <option value={{ $country->id }} data-lat="{{ $country->latitude }}" data-lng="{{ $country->longitude }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">State <label class="text-danger">*</label></label>
                            <div class="col-lg-10">
                                <div class="input-group">
                                    <select class="form-control form-control-select2" data-fouc name="state" required id="states">
                                        <option value="" disabled selected>Select State</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                        <div class="text-right">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#map_modal">View Map <i class="icon-map ml-2"></i></button>
                        </div>

                        <div class="row mt-3">
                            <div class="form-group row col-md-6">
                                <label class="col-form-label col-lg-3">Latitude <label class="text-danger">*</label></label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Get Your Latitude From Map" name="latitude" id="latitude" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row col-md-6">
                                <label class="col-form-label col-lg-3">Longitude <label class="text-danger">*</label></label>
                                <div class="col-lg-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Get Your Longitude From Map" name="longitude" id="longitude" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit form <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-2 ">
        </div>
    </div>
</div>

<div id="map_modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Choose Customer Location</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="map-container" id="map_basic">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-primary" data-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
    var $countrySelect = $('#country');
    var $stateSelect = $('#states');

    $countrySelect.on('change', function() {
        var countryId = $countrySelect.val();

        $.ajax({
            url: '/states/' + countryId,
            method: 'GET',
            success: function(data) {

                $stateSelect.empty();

                $stateSelect.append($('<option>', {
                    value: '',
                    text: 'Select State',
                    disabled: true,
                    selected: true
                }));

                $.each(data, function(key, value) {
                    $stateSelect.append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(xhr.responseText);
            }
        });
    });
});

</script>

  <script>

   function initMap() {
        // Define a global map variable
        var map;

        // Define a global marker variable
        var marker;

        // Handle country selection
        var countrySelect = document.getElementById("country");
        countrySelect.addEventListener("change", function() {

            var countryOption = countrySelect.options[countrySelect.selectedIndex];
            var lat = parseFloat(countryOption.getAttribute("data-lat"));
            var lng = parseFloat(countryOption.getAttribute("data-lng"));

            console.log(lat, lng, 'sdfhdsjgfjsd');
            // Create a new map centered on the selected country
            map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: lat, lng: lng },
            zoom: 6
            });

            // Add a marker for the selected country
            marker = new google.maps.Marker({
            position: { lat: lat, lng: lng },
            map: map,
            title: countryOption.text
            });

            // Enable the "View Map" button
            document.getElementById("view_map_button").disabled = false;
        });

        // Handle "View Map" button click
        document.getElementById("view_map_button").addEventListener("click", function() {
            $('#map_modal').modal('show');
        });

        // Handle map click
        google.maps.event.addListener(map, 'click', function(event) {
            var clickedLat = event.latLng.lat();
            var clickedLng = event.latLng.lng();

            // Update marker position
            marker.setPosition(event.latLng);

            document.getElementById('latitude').value = clickedLat;
            document.getElementById('longitude').value = clickedLng;
            console.log(lat, lng);
        });
    }

    google.maps.event.addDomListener(window, "load", initMap);
  </script>

@endsection
