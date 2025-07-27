<div class="container mt-5">
<h5 class="m-4">Checkout</h5>
<div class="d-md-block d-flex align-items-center justify-content-between px-4">
    <h6 class="mb-4"> {{ $package->name }}</h6>
    <h6> {{ $numberOfDays }} Days</h6>
</div>
    <div class="row">
        <div class="col-lg-8">
            <div class="row mb-4">
                <div class="col-md-6">
                    <ul class="list-group">
                        {{-- <li class="list-group-item"><strong>Total Days:</strong> {{ $numberOfDays }}</li> --}}
                    </ul>
                </div>

                <div class="col-md-6">
                    @if ($selectedAmenities )
                        <ul class="list-group">
                            @forelse($selectedAmenities as $amenity)
                                <li class="list-group-item">{{ $amenity['name'] }} - £{{ number_format($amenity['price'], 2) }} (Only available for month)</li>
                            @empty
                                <li class="list-group-item"></li>
                            @endforelse
                        </ul>
                    @endif
                    @if ($selectedMaintains)
                    <ul class="list-group">
                        @forelse($selectedMaintains as $maintain)
                            <li class="list-group-item">{{ $maintain['name'] }} - £{{ number_format($maintain['price'], 2) }} (Only available for month)</li>
                        @empty
                            <li class="list-group-item"></li>
                        @endforelse
                    </ul>
                    @endif
                </div>
            </div>
            @if($selectedRooms->isEmpty())
                <p>No rooms selected.</p>
            @else
                <div class="row">
                    @foreach($selectedRooms as $room)
                        <div class="col-md-5">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-header">
                                    <h5 class="card-title">{{ $room->name }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-2">
                                        <select id="priceType_{{ $room->id }}" class="form-control mb-2" wire:model.live="roomPriceTypes.{{ $room->id }}">
                                            @if(isset($roomPrices[$room->id]['Day']))
                                                <option value="Day">Day</option>
                                            @endif
                                            @if(isset($roomPrices[$room->id]['Week']) && $numberOfDays > 7)
                                                <option value="Week">Week</option>
                                            @endif
                                            @if(isset($roomPrices[$room->id]['Month']) && $numberOfDays > 28)
                                                <option value="Month">Month</option>
                                            @endif
                                        </select>
                                    </div>
                                    @php
                                        $priceType = $roomPriceTypes[$room->id] ?? 'Day';
                                    @endphp
                                    @if(isset($roomPrices[$room->id][$priceType]))
                                        @php
                                            $price = $roomPrices[$room->id][$priceType];
                                        @endphp
                                        <div class="d-flex align-items-center px-md-0 px-4 justify-content-between mb-2">
                                            <div class="{{ isset($price['discount_price']) ? 'text-success' : 'text-danger' }}">
                                                <strong>Price:</strong>
                                                <span class="h5">£{{ number_format($price['discount_price'] ?? $price['fixed_price'], 2) }}</span>
                                            </div>
                                            <div>
                                                <strong>Booking Price:</strong>
                                                <span class="h5 text-secondary">£{{ number_format($price['booking_price'], 2) }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <p>No price available for the selected type.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif


        </div>

        <div class="col-lg-4 mb-8">

            <div class="card sticky-top shadow-sm">
                <div class="">
                    <div class="d-md-block d-flex justify-content-between align-items-center pt-6 px-4">
                        <h6><strong>Total Amount:</strong> £{{ number_format($totalAmount, 2) }}</h6>
                        <h6><strong>Booking Total:</strong> £{{ number_format($bookingPrice, 2) }}</h6>
                    </div>
                </div>
                <div class="card-body">
                    <h4>Payment Details</h4>
                    <div class="form-group mb-2">
                        <label for="paymentOption">Payment Option</label>
                        <select id="paymentOption" class="form-control form-control-lg" wire:model.live="paymentOption">
                            <option value="booking_only">Pay Booking Price Only</option>
                            <option value="full">Pay Full Amount</option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        @if($paymentOption === 'full')
                            <p><strong>Total Amount to Pay:</strong> £{{ number_format(round($totalAmount + $bookingPrice), 0) }}</p>
                        @else
                            <p><strong>Total Amount to Pay:</strong> £{{ number_format(round($bookingPrice), 0) }}</p>
                        @endif
                    </div>

                    <button type="button" class="btn btn-primary btn-lg btn-block"
                        wire:click="submitBooking"
                        @if(!$this->shouldEnablePayNow()) disabled @endif>
                        Pay Now
                    </button>

                </div>
            </div>
        </div>
    </div>

    @if($showPaymentModal)
    <div class="modal fade show d-block" tabindex="-1" role="dialog" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Choose Payment Method</h5>
                    <button type="button" class="close" aria-label="Close" wire:click="$set('showPaymentModal', false)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent="proceedPayment"> <!-- Add form element here -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="paymentMethod">Payment Method</label>
                            <select id="paymentMethod" class="form-control" wire:model.live="paymentMethod">
                                <option value="cash">Cash</option>
                                <option value="card">Card (Stripe)</option>
                                <option value="bank_transfer">Bank Transfer</option>
                            </select>
                        </div>

                        @if($paymentMethod == 'card')
                            <!-- Content for card payment method if needed -->
                        @endif

                        @if($paymentMethod == 'bank_transfer')
                            <div>
                                <p>Bank Details: {{ $bankDetails }}</p>
                            </div>
                            <div>
                                <label for="bankTransferReference">Reference</label>
                                <input type="text" wire:model="bankTransferReference" id="bankTransferReference" class="form-control" required>
                                @error('bankTransferReference') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        @endif

                        @if($paymentMethod == 'cash')
                            <div>
                                <p>Please bring cash to the venue.</p>
                            </div>
                        @endif

                        {{-- Error messages --}}
                        @if(session()->has('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$set('showPaymentModal', false)">Close</button>
                        <button type="submit" class="btn btn-primary">Proceed Payment</button> <!-- Change button type to submit -->
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

