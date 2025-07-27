<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h2>Package Details</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Basic Information</h4>
                    <p><strong>Name:</strong> {{ $package->name }}</p>
                    <p><strong>Address:</strong> {{ $package->address }}</p>
                    <p><strong>Country:</strong> {{ $package->country->name }}</p>
                    <p><strong>City:</strong> {{ $package->city->name }}</p>
                    <p><strong>Area:</strong> {{ $package->area->name }}</p>
                    <p><strong>Property:</strong> {{ $package->property->name }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Details</h4>
                    <p><strong>Map Link:</strong> <a href="{{ $package->map_link }}" target="_blank">View Map</a></p>
                    <p><strong>Number of Kitchens:</strong> {{ $package->number_of_kitchens }}</p>
                    <p><strong>Seating Capacity:</strong> {{ $package->seating }}</p>
                    <p><strong>Details:</strong> {{ $package->details }}</p>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4>Rooms</h4>
                    <div class="row">
                        @foreach($package->rooms as $room)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $room->name }}</h5>
                                        <p class="card-text">
                                            <strong>Number of Beds:</strong> {{ $room->number_of_beds }}<br>
                                            <strong>Number of Bathrooms:</strong> {{ $room->number_of_bathrooms }}<br>
                                            @foreach($room->prices as $price)
                                                <h6>{{ ucfirst($price->type) }} Prices</h6>
                                                <p>
                                                    <strong>Fixed Price:</strong> £{{ $price->fixed_price }}<br>
                                                    @if($price->discount_price)
                                                        <strong>Discount Price:</strong> £{{ $price->discount_price }}<br>
                                                    @endif
                                                    @if($price->booking_price)
                                                        <strong>Booking Price:</strong> £{{ $price->booking_price }}<br>
                                                    @endif
                                                </p>
                                            @endforeach
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Free Maintains</h4>
                    <ul class="list-group">
                        @foreach($package->maintains()->wherePivot('is_paid', false)->get() as $maintain)
                            <li class="list-group-item">{{ $maintain->name }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Free Amenities</h4>
                    <ul class="list-group">
                        @foreach($package->amenities()->wherePivot('is_paid', false)->get() as $amenity)
                            <li class="list-group-item">{{ $amenity->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h4>Paid Maintains</h4>
                    <ul class="list-group">
                        @foreach($package->maintains()->wherePivot('is_paid', true)->get() as $maintain)
                            <li class="list-group-item">
                                {{ $maintain->name }} - £{{ $maintain->pivot->price }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <h4>Paid Amenities</h4>
                    <ul class="list-group">
                        @foreach($package->amenities()->wherePivot('is_paid', true)->get() as $amenity)
                            <li class="list-group-item">
                                {{ $amenity->name }} - £{{ $amenity->pivot->price }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4>Photos</h4>
                    <div class="row">
                        @foreach($package->photos as $photo)
                            <div class="col-md-3">
                                <div class="card mb-3">
                                    <img src="{{ asset('storage/' . $photo->url) }}" class="card-img-top" alt="Photo">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <a href="{{ route('admin.packages') }}" class="btn btn-secondary">Back to Packages</a>
                    <a href="{{ route('admin.package.edit', ['packageId' => $package->id]) }}"class="btn btn-primary"><i class="fad fa-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
