<div class="container mt-5">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <form wire:submit.prevent="save">
        <div class="group-2 form-grid mb-4 room-section">
            <div class="form-group">
                <label for="country_id">Country</label>
                <select wire:model.live.prevent="country_id" id="country_id" class="form-control">
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                </select>
                @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="city_id">City</label>
                <select wire:model.live.prevent="city_id" id="city_id" class="form-control">
                    <option value="">Select City</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('city_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="area_id">Area</label>
                <select wire:model.live="area_id" id="area_id" class="form-control">
                    <option value="">Select Area</option>
                    @foreach($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
                @error('area_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="property_id">Property</label>
                <select wire:model="property_id" id="property_id" class="form-control">
                    <option value="">Select Property</option>
                    @foreach($properties as $property)
                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                    @endforeach
                </select>
                @error('property_id') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="name">Package Name</label>
                <input type="text" wire:model="name" id="name" class="form-control">
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" wire:model="address" id="address" class="form-control">
                @error('address') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="map_link">Map Link</label>
                <input type="text" wire:model="map_link" id="map_link" class="form-control">
                @error('map_link') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="number_of_rooms">Rooms</label>
                <input type="number" wire:model="number_of_rooms" id="number_of_rooms" class="form-control">
                @error('number_of_rooms') <span class="text-danger">{{ $message }}</span> @enderror
            </div>


            <div class="form-group">
                <label for="number_of_kitchens">Kitchens</label>
                <input type="number" wire:model="number_of_kitchens" id="number_of_kitchens" class="form-control">
                @error('number_of_kitchens') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="common_bathrooms">Common Bathrooms</label>
                <input type="number" wire:model="common_bathrooms" id="common_bathrooms" class="form-control">
                @error('common_bathrooms') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="seating">Seating</label>
                <input type="number" wire:model="seating" id="seating" class="form-control">
                @error('seating') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>


        <div>
            <!-- Selection for Entire Property or Room Wise -->
            <div class="form-group">
                <label for="selection">Select Type</label>
                <select wire:model.live="selection" id="selection" class="form-control">
                    <option value="entire">Entire Property</option>
                    <option value="room">Room Wise</option>
                </select>
            </div>

            <!-- Entire Property Fields -->
            @if($selection == 'entire')
    <div class="form-group">
        <h2>Entire Property</h2>
        <div class="pricing-options form-grid">
            @foreach($entireProperty['prices'] as $priceIndex => $price)
                <div class="pricing-option">
                    <div class="form-group">
                        <label for="entireProperty-prices-{{ $priceIndex }}-type">Price Type</label>
                        <select wire:model.live="entireProperty.prices.{{ $priceIndex }}.type" id="entireProperty-prices-{{ $priceIndex }}-type" class="form-control">
                            <option value="">Select Option</option>
                            <option value="Day">Day</option>
                            <option value="Week">Week</option>
                            <option value="Month">Month</option>
                        </select>
                        @error('entireProperty.prices.' . $priceIndex . '.type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    @if($price['type'] === 'Day')
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-fixed_price">Day Fixed Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.fixed_price" id="entireProperty-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-discount_price">Day Discount Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.discount_price" id="entireProperty-prices-{{ $priceIndex }}-discount_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-booking_price">Day Booking Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.booking_price" id="entireProperty-prices-{{ $priceIndex }}-booking_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @elseif($price['type'] === 'Week')
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-fixed_price">Week Fixed Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.fixed_price" id="entireProperty-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-discount_price">Week Discount Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.discount_price" id="entireProperty-prices-{{ $priceIndex }}-discount_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-booking_price">Week Booking Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.booking_price" id="entireProperty-prices-{{ $priceIndex }}-booking_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @elseif($price['type'] === 'Month')
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-fixed_price">Month Fixed Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.fixed_price" id="entireProperty-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-discount_price">Month Discount Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.discount_price" id="entireProperty-prices-{{ $priceIndex }}-discount_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="entireProperty-prices-{{ $priceIndex }}-booking_price">Month Booking Price</label>
                            <input type="number" wire:model.live="entireProperty.prices.{{ $priceIndex }}.booking_price" id="entireProperty-prices-{{ $priceIndex }}-booking_price" class="form-control">
                            @error('entireProperty.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
        @if(count($entireProperty['prices']) < 3)
            <button type="button" class="btn btn-secondary" wire:click="addEntirePropertyPrice"><i class="fas fa-plus"></i></button>
        @endif
        @if(count($entireProperty['prices']) > 1)
                        <button type="button" class="btn btn-danger" wire:click="removeEntirePropertyPrice({{ $priceIndex }})"><i class="fas fa-times"></i></button>
                    @endif
    </div>
@endif


            <!-- Room Wise Fields -->
            @if($selection == 'room')
            <div class="form-group group-2">
                <h2>Rooms</h2>
                <div class="mb-4 group-2">
                    @foreach($rooms as $roomIndex => $room)
                    <div class="room-section mb-4 form-grid-2">
                        <div class="form-group">
                            <label for="rooms-{{ $roomIndex }}-name">Room Name</label>
                            <input type="text" wire:model="rooms.{{ $roomIndex }}.name" id="rooms-{{ $roomIndex }}-name" class="form-control">
                            @error('rooms.' . $roomIndex . '.name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="rooms-{{ $roomIndex }}-number_of_beds">Beds</label>
                            <input type="number" wire:model="rooms.{{ $roomIndex }}.number_of_beds" id="rooms-{{ $roomIndex }}-number_of_beds" class="form-control">
                            @error('rooms.' . $roomIndex . '.number_of_beds') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="rooms-{{ $roomIndex }}-number_of_bathrooms">Attach Bathrooms</label>
                            <input type="number" wire:model="rooms.{{ $roomIndex }}.number_of_bathrooms" id="rooms-{{ $roomIndex }}-number_of_bathrooms" class="form-control">
                            @error('rooms.' . $roomIndex . '.number_of_bathrooms') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Pricing Options -->
                    <div class="pricing-options form-grid">
                        @foreach($room['prices'] as $priceIndex => $price)
                        <div class="pricing-option">
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-type">Price Type</label>
                                <select wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.type" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-type" class="form-control">
                                    <option value="">Select Option</option>
                                    <option value="Day">Day</option>
                                    <option value="Week">Week</option>
                                    <option value="Month">Month</option>
                                </select>
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            @if($price['type'] === 'Day')
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price">Day Fixed Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.fixed_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price">Day Discount Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.discount_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price">Day Booking Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.booking_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @elseif($price['type'] === 'Week')
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price">Week Fixed Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.fixed_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price">Week Discount Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.discount_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price">Week Booking Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.booking_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @elseif($price['type'] === 'Month')
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price">Month Fixed Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.fixed_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-fixed_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.fixed_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price">Month Discount Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.discount_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-discount_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.discount_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label for="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price">Month Booking Price</label>
                                <input type="number" wire:model.live="rooms.{{ $roomIndex }}.prices.{{ $priceIndex }}.booking_price" id="rooms-{{ $roomIndex }}-prices-{{ $priceIndex }}-booking_price" class="form-control">
                                @error('rooms.' . $roomIndex . '.prices.' . $priceIndex . '.booking_price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Add/Remove Pricing Options -->
                    <div>
                        <button type="button" class="btn btn-secondary" wire:click="addPriceOption({{ $roomIndex }})"><i class="fas fa-plus"></i></button>
                        @if(count($room['prices']) > 1)
                            <button type="button" class="btn btn-danger" wire:click="removePriceOption({{ $roomIndex }}, {{ $priceIndex }})"><i class="fas fa-times"></i></button>
                        @endif
                    </div>

                    <!-- Remove Room -->
                    <button type="button" class="btn btn-danger" wire:click="removeRoom({{ $roomIndex }})"><i class="fas fa-times"></i></button>
                    @endforeach
                </div>

                <!-- Add Room -->
                <button type="button" class="btn btn-secondary" wire:click="addRoom"><i class="fas fa-plus"></i> Add Room</button>
            </div>
            @endif
        </div>



        <div class="form-group group-2">
            <div wire:ignore class="form-grid">
                <div class="form-group">
                    <label for="freeMaintains">Select Free Maintains</label>
                    <select wire:model.live="freeMaintains" multiple id="freeMaintains" class="form-control selectpicker border">
                        @foreach($maintains as $maintain)
                            <option value="{{ $maintain->id }}">{{ $maintain->name }}</option>
                        @endforeach
                    </select>
                    @error('freeMaintains') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="freeAmenities">Select Free Amenities</label>
                    <select wire:model.live="freeAmenities" multiple id="freeAmenities" class="form-control selectpicker border">
                        @foreach($amenities as $amenity)
                            <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                        @endforeach
                    </select>
                    @error('freeAmenities') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="form-group group-2">
            <h2>Paid Maintains</h2>
            <div class="form-grid">
                @foreach($paidMaintains as $index => $maintain)
                <div class="room-section mb-4">
                    <div class="form-group">
                        <label for="paidMaintains-{{ $index }}-maintain_id">Select Maintain</label>
                        <select wire:model="paidMaintains.{{ $index }}.maintain_id" id="paidMaintains-{{ $index }}-maintain_id" class="form-control">
                            <option value="">Select Maintain</option>
                            @foreach($maintains as $maintainOption)
                                <option value="{{ $maintainOption->id }}">{{ $maintainOption->name }}</option>
                            @endforeach
                        </select>
                        @error('paidMaintains.' . $index . '.maintain_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="paidMaintains-{{ $index }}-price">Price</label>
                        <input type="number" wire:model="paidMaintains.{{ $index }}.price" id="paidMaintains-{{ $index }}-price" class="form-control">
                        @error('paidMaintains.' . $index . '.price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                @endforeach
            </div>
            @if(count($paidMaintains) > 1)
                <button type="button" class="btn btn-lg btn-danger mb-3" wire:click="removePaidMaintain({{ $index }})">Remove Maintain</button>
            @endif
            <button type="button" class="btn btn-lg btn-primary mb-3" wire:click="addPaidMaintain">Add Paid Maintain</button>
        </div>

        <div class="form-group group-2">
            <h2>Paid Amenities</h2>
            <div class="form-grid">
                @foreach($paidAmenities as $index => $amenity)
                <div class="room-section mb-4">
                    <div class="form-group">
                        <label for="paidAmenities-{{ $index }}-amenity_id">Select Amenity</label>
                        <select wire:model="paidAmenities.{{ $index }}.amenity_id" id="paidAmenities-{{ $index }}-amenity_id" class="form-control">
                            <option value="">Select Amenity</option>
                            @foreach($amenities as $amenityOption)
                                <option value="{{ $amenityOption->id }}">{{ $amenityOption->name }}</option>
                            @endforeach
                        </select>
                        @error('paidAmenities.' . $index . '.amenity_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group">
                        <label for="paidAmenities-{{ $index }}-price">Price</label>
                        <input type="number" wire:model="paidAmenities.{{ $index }}.price" id="paidAmenities-{{ $index }}-price" class="form-control">
                        @error('paidAmenities.' . $index . '.price') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                @endforeach
            </div>
            @if(count($paidAmenities) > 1)
                <button type="button" class="btn btn-lg btn-danger mb-3" wire:click="removePaidAmenity({{ $index }})">Remove Amenity</button>
            @endif
            <button type="button" class="btn btn-lg btn-primary mb-3" wire:click="addPaidAmenity">Add Paid Amenity</button>
        </div>

        <div class="form-group group-2">
            <h2>Photos</h2>
            <div class="upload-box" id="upload-box">
                <input type="file" wire:model="photos" multiple id="photo-upload">
            </div>
            @error('photos') <span class="text-danger">{{ $message }}</span> @enderror

            <div class="image-preview">
                @if($photos)
                    @foreach($photos as $photo)
                        <img src="{{ $photo->temporaryUrl() }}" alt="Photo Preview" class="img-thumbnail w-24 h-50">
                    @endforeach
                @endif
            </div>
        </div>

        <div class="form-group group-2">
            <label for="video_link">Video Link</label>
            <input type="text" id="video_link" wire:model="video_link" class="form-control">
            @error('video_link') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group group-2">
            <div class="form-group">
                <label for="details">Package Details</label>
                <textarea wire:model="details" id="details" class="form-control"></textarea>
                @error('details') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
