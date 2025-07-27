<div>
    <section class="d-flex flex-column">
        <div  style="background-image: url('{{ asset('storage/' . $heroSection?->background_image) }}');"
             class="bg-cover d-flex align-items-center custom-vh-60" wire:ignore.self>
            <div wire:ignore.self class="container pt-lg-4 py-4" data-animate="zoomIn">
                <p class="text-white fs-md-20 fs-16 font-weight-500 letter-spacing-367 mb-2 text-center text-uppercase">{{$heroSection?->title_small}}</p>
                <h2 class="text-white display-2 text-center mb-sm-4 mb-4">
                  {{$heroSection?->title_big }}
                </h2>
                <div class="container mb-4">
                  <div class="row justify-content-center">
                      <div class="col-lg-8">
                          <div class="d-flex flex-column flex-lg-row align-items-center">
                            <div class="mr-lg-2 mb-2 mb-lg-0 w-100">
                                <select wire:model.live="selectedCountry" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                              <div class="mr-lg-2 mb-2 mb-lg-0 w-100">
                                  <select wire:model.live="selectedCity" class="form-control">
                                      <option value="">Select City</option>
                                      @foreach($cities as $city)
                                          <option value="{{ $city->id }}">{{ $city->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mr-lg-2 mb-2 mb-lg-0 w-100">
                                  <select wire:model.live="selectedArea" class="form-control">
                                      <option value="">Services Area</option>
                                      @foreach($areas as $area)
                                          <option value="{{ $area->id }}">{{ $area->name }}</option>
                                      @endforeach
                                  </select>
                              </div>
                              <div class="mr-lg-2 mb-2 mb-lg-0 w-100 d-none">
                                  <input type="text" wire:model.live.debounce.300ms="keyword" class="form-control" placeholder="Or Keyword">
                              </div>
                              <div class="w-100">
                                  <button wire:click="searchPackages" class="btn btn-primary btn-block">Search</button>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>



            </div>
        </div>
    </section>

    @if($packages)
    <div id="filterPackage" class="container">
        <div class="row">
            @foreach($packages as $package)
              <div class="col-md-4 mb-4">
                <a href="{{ route('package.show', ['id' => $package->id]) }}" class="text-decoration-none">
                    <div class="card py-3">
                        <div class="position-relative hover-change-image bg-hover-overlay rounded-lg card-img">
                            @if($package->photos->isNotEmpty())
                                <img src="{{ asset('storage/'.$package->photos->first()->url) }}" alt="Thumbnail" class="img-thumbnail">
                            @else
                                <img src="{{ asset('default-thumbnail.jpg') }}" alt="Thumbnail" class="img-thumbnail">
                            @endif
                        </div>
                        <div class="card-body pt-3 px-3 pb-1">
                            <h2 class="fs-16 mb-1">
                                {{ $package->name }}
                            </h2>
                            <p class="font-weight-500 text-gray-light mb-0">
                                {{ $package->address }}
                            </p>
                            @php
                                $roomPrices = $package->rooms->flatMap(function($room) {
                                    return $room->prices;
                                });

                                $roomPriceData = $this->getFirstAvailablePrice($roomPrices);
                                $roomPrice = $roomPriceData['price'] ?? null;
                                $roomPriceType = $roomPriceData['type'] ?? null;
                                $roomPriceIndicator = $roomPriceType ? $this->getPriceIndicator($roomPriceType) : '';

                                $propertyPrices = $package->entireProperty->prices ?? [];
                                $propertyPriceData = $this->getFirstAvailablePrice($propertyPrices);
                                $propertyPrice = $propertyPriceData['price'] ?? null;
                                $propertyPriceType = $propertyPriceData['type'] ?? null;
                                $propertyPriceIndicator = $propertyPriceType ? $this->getPriceIndicator($propertyPriceType) : '';
                            @endphp

                            @if($roomPrice)
                                @if($roomPrice->discount_price)
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                        <del class="text-muted mr-2"> £{{ $roomPrice->fixed_price }}</del>
                                        <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $roomPrice->discount_price }}</span>
                                        <span class="price-indicate">{{ $roomPriceIndicator }}</span>
                                    </p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $roomPrice->fixed_price }}<span class="price-indicate">{{ $roomPriceIndicator }}</span></p>
                                @endif
                            @endif

                            @if($propertyPrice)
                                @if($propertyPrice->discount_price)
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                        <del class="text-muted mr-2"> £{{ $propertyPrice->fixed_price }}</del>
                                        <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->discount_price }}</span>
                                        <span class="price-indicate">{{ $propertyPriceIndicator }}</span>
                                    </p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->fixed_price }}<span class="price-indicate">{{ $propertyPriceIndicator }}</span></p>
                                @endif
                            @endif


                            @if($propertyPrice)
                                @if($propertyPrice->discount_price)
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                        <del class="text-muted mr-2"> £{{ $propertyPrice->fixed_price }}</del>
                                        <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->discount_price }}</span>
                                        <span class="price-indicate">(p/n by property)</span>
                                    </p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->fixed_price }}<span class="price-indicate">(p/n by property)</span></p>
                                @endif
                            @endif

                        </div>
                        <div class="card-footer bg-transparent px-3 pb-0 pt-2">
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item text-gray font-weight-500 fs-13 mr-sm-7" data-toggle="tooltip" title="{{ $package->bedrooms }} Bedroom">
                                    <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-bedroom"></use>
                                    </svg>
                                    {{ $package->rooms->count() }} Br
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13 mr-sm-7" data-toggle="tooltip" title="{{ $package->common_bathrooms }} Bathrooms">
                                    <svg class="icon icon-shower fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-shower"></use>
                                    </svg>
                                    {{ $package->common_bathrooms }} Ba
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13" data-toggle="tooltip" title="{{ $package->seating }} Seating">
                                    <svg class="icon icon-square fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-square"></use>
                                    </svg>
                                    {{ $package->seating }} Seating
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    @if($noPackagesFound)
    <div id="filterPackage"  class="alert alert-warning text-center" role="alert">
            No packages found.
        </div>
    @endif
    <script>
        function scrollToFilterPackage() {
            var element = document.getElementById('filterPackage');
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    </script>


<div>
      <section class="py-4">
        <div class="container">
          <div class="">
            <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="fs-4">Best Place to Book</h4>
                    <div class="text-md-right">
                        <a href="{{route('package.list')}}" class="fs-8 text-light btn-accent p-2 bg-primary">
                          <i class="fas fa-share-all"></i>
                        </a>
                      </div>
                </div>

                <span class="heading-divider"></span>
                <p class="mb-2">Choose Your Package</p>
            </div>

          </div>
          <div wire:ignore class="slick-slider slick-dots-mt-0 custom-arrow-spacing-30"
		     data-slick-options='{"slidesToShow": 4,"dots":true,"arrows":false,"responsive":[{"breakpoint": 1600,"settings": {"slidesToShow":3}},{"breakpoint": 992,"settings": {"slidesToShow":2,"arrows":false}},{"breakpoint": 768,"settings": {"slidesToShow": 2,"arrows":false,"dots":true,"autoplay":true}},{"breakpoint": 576,"settings": {"slidesToShow": 1,"arrows":false,"dots":true,"autoplay":true}}]}'>
             @foreach($featuredPackages as $package)
              <div class="box box pb-7 pt-2" data-animate="fadeInUp">
                <a href="{{ route('package.show', ['id' => $package->id]) }}" class="text-dark text-decoration-none">
                    <div class="card shadow-hover-2">
                        <div class="hover-change-image bg-hover-overlay rounded-lg card-img-top">
                            @if($package->photos->isNotEmpty())
                                <img src="{{ asset('storage/'.$package->photos->first()->url) }}" alt="Thumbnail" class="img-thumbnail">
                            @else
                                <img src="{{ asset('default-thumbnail.jpg') }}" alt="Thumbnail" class="img-thumbnail">
                            @endif
                            <div class="card-img-overlay p-2 d-flex flex-column">
                                <div>
                                    {{-- Optional badges or overlays can go here --}}
                                </div>
                                {{-- Optional additional content such as image counts or videos can go here --}}
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <h2 class="card-title fs-16 lh-2 mb-0">
                                {{ $package->name }}
                            </h2>
                            <p class="card-text font-weight-500 text-gray-light mb-2">
                                {{ $package->address }}
                            </p>

                            <div class="mb-2">
                                @php
                                    $roomPrices = $package->rooms->flatMap(function($room) {
                                        return $room->prices;
                                    });

                                    $roomPriceData = $this->getFirstAvailablePrice($roomPrices);
                                    $roomPrice = $roomPriceData['price'] ?? null;
                                    $roomPriceType = $roomPriceData['type'] ?? null;
                                    $roomPriceIndicator = $roomPriceType ? $this->getPriceIndicator($roomPriceType) : '';

                                    $propertyPrices = $package->entireProperty->prices ?? [];
                                    $propertyPriceData = $this->getFirstAvailablePrice($propertyPrices);
                                    $propertyPrice = $propertyPriceData['price'] ?? null;
                                    $propertyPriceType = $propertyPriceData['type'] ?? null;
                                    $propertyPriceIndicator = $propertyPriceType ? $this->getPriceIndicator($propertyPriceType) : '';
                                @endphp

                                @if($roomPrice)
                                    @if($roomPrice->discount_price)
                                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                            <del class="text-muted mr-2"> £{{ $roomPrice->fixed_price }}</del>
                                            <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $roomPrice->discount_price }}</span>
                                            <span class="price-indicate">{{ $roomPriceIndicator }}</span>
                                        </p>
                                    @else
                                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $roomPrice->fixed_price }}<span class="price-indicate">{{ $roomPriceIndicator }}</span></p>
                                    @endif
                                @endif

                                @if($propertyPrice)
                                    @if($propertyPrice->discount_price)
                                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                            <del class="text-muted mr-2"> £{{ $propertyPrice->fixed_price }}</del>
                                            <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->discount_price }}</span>
                                            <span class="price-indicate">{{ $propertyPriceIndicator }}</span>
                                        </p>
                                    @else
                                        <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->fixed_price }}<span class="price-indicate">{{ $propertyPriceIndicator }}</span></p>
                                    @endif
                                @endif
                            </div>
                            <ul class="list-inline d-flex mb-0 flex-wrap mr-n5">
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="{{ $package->bedrooms }} Bedroom">
                                    <svg class="icon icon-bedroom fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-bedroom"></use>
                                    </svg>
                                    {{ $package->rooms->count() }} Br
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="{{ $package->common_bathrooms }} Bathrooms">
                                    <svg class="icon icon-shower fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-shower"></use>
                                    </svg>
                                    {{ $package->common_bathrooms }} Ba
                                </li>
                                <li class="list-inline-item text-gray font-weight-500 fs-13 d-flex align-items-center mr-5"
                                    data-toggle="tooltip" title="Size">
                                    <svg class="icon icon-square fs-18 text-primary mr-1">
                                        <use xlink:href="#icon-square"></use>
                                    </svg>
                                    {{ $package->seating }} Seating
                                </li>
                                {{-- Additional list items can go here --}}
                            </ul>




                            @if($propertyPrice)
                                @if($propertyPrice->discount_price)
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16">
                                        <del class="text-muted mr-2"> £{{ $propertyPrice->fixed_price }}</del>
                                        <span class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->discount_price }}</span>
                                        <span class="price-indicate">(p/n by property)</span>
                                    </p>
                                @else
                                    <p class="fs-17 font-weight-bold text-heading mb-0 lh-16"> £{{ $propertyPrice->fixed_price }}<span class="price-indicate">(p/n by property)</span></p>
                                @endif
                            @endif
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center py-3">

                        </div>
                    </div>
                </a>
            </div>

            @endforeach

          </div>
        </div>
      </section>

      @livewire('user.home-data-user')
</div>



</div>
