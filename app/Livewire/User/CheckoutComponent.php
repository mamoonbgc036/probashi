<?php

namespace App\Livewire\User;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Room;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Http\Request;

class CheckoutComponent extends Component
{
    public $package;
    public $packageId;
    public $fromDate;
    public $toDate;
    public $name;
    public $email;
    public $phone;
    public $paymentOption = 'booking_only';
    public $priceType = 'Day';
    public $totalAmount;
    public $bookingPrice;
    public $discountPrice;
    public $prices = [];
    public $numberOfDays;
    public $selectedRooms;
    public $has_rooms;
    public $roomPrices = []; // Make sure this is an array
    public $selectedMaintains = [];
    public $selectedAmenities = [];

    public $roomPriceTypes = []; // Add this property
    public $paymentAmount;
    public $paymentMethod = 'cash';
    public $stripePaymentIntent;
    public $bankDetails;
    public $bankTransferReference; // New property for bank transfer reference
    public $showPaymentModal = false;



    public function mount()
    {
        $data = session()->get('checkout_data', []);

        $this->packageId = $data['packageId'] ?? null;
        $this->fromDate = $data['fromDate'] ?? null;
        $this->toDate = $data['toDate'] ?? null;
        $this->name = $data['name'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
        $this->roomPrices = $data['roomPrices'] ?? [];
        $this->selectedMaintains = $data['selectedMaintains'] ?? [];
        $this->selectedAmenities = $data['selectedAmenities'] ?? [];
        $this->selectedRooms = $data['selectedRooms'] ?? [];

        $this->package = Package::with('rooms')->findOrFail($this->packageId);

        // Fetch the room details if needed
        $this->selectedRooms = Room::whereIn('id', $this->selectedRooms)->get();
        $this->numberOfDays = (new \DateTime($this->toDate))->diff(new \DateTime($this->fromDate))->days;
        $this->fetchPrices();
        $this->calculatePrices();
        $this->bankDetails = "Netsoftuk Solution A/C 17855008 S/C 04-06-05";
    }


    public function calculateTotalAmount()
    {
        if ($this->paymentOption === 'full') {
            return $this->totalAmount + $this->bookingPrice;
        } else {
            return $this->bookingPrice;
        }
    }

    public function shouldEnablePayNow()
    {
        return $this->calculateTotalAmount() > 0;
    }


    public function selectRoom($roomId)
    {
        if (!in_array($roomId, $this->selectedRooms)) {
            $this->selectedRooms[] = $roomId;
        }
        $this->calculatePrices(); // Recalculate prices when a room is selected
    }

    public function deselectRoom($roomId)
    {
        if (($key = array_search($roomId, $this->selectedRooms)) !== false) {
            unset($this->selectedRooms[$key]);
            $this->selectedRooms = array_values($this->selectedRooms);
        }
        $this->calculatePrices(); // Recalculate prices when a room is deselected
    }

    public function fetchPrices()
    {
        if ($this->package->rooms) {
            foreach ($this->package->rooms as $room) {
                $roomPrices = $room->roomPrices->pluck(null, 'type')->toArray();
                $this->roomPrices[$room->id] = $roomPrices;
                $this->setRoomPriceType($room); // Set default value dynamically
            }
        }
    }

    public function setRoomPriceType($room)
    {
        $availablePriceTypes = $room->roomPrices->pluck('type')->toArray();

        if (in_array('Day', $availablePriceTypes)) {
            $this->roomPriceTypes[$room->id] = 'Day';
        } elseif (in_array('Week', $availablePriceTypes)) {
            $this->roomPriceTypes[$room->id] = 'Week';
        } elseif (in_array('Month', $availablePriceTypes)) {
            $this->roomPriceTypes[$room->id] = 'Month';
        } else {
            $this->roomPriceTypes[$room->id] = 'Day'; // Default to 'Day' if no price types are available
        }
    }

    public function calculatePrices()
    {
        $this->totalAmount = 0;
        $this->bookingPrice = 0; // Reset the bookingPrice

        // Calculate the total amount and booking price for the selected rooms
        $roomTotal = 0;
        $roomBookingTotal = 0; // Initialize the room booking total
        foreach ($this->selectedRooms as $room) {
            $roomPriceType = $this->roomPriceTypes[$room->id] ?? 'Day'; // Default to 'Day' if not set
            $roomPrice = $room->roomPrices()->where('type', $roomPriceType)->first();
            if ($roomPrice) {
                $pricePerUnit = isset($roomPrice['discount_price']) ? $roomPrice['discount_price'] : $roomPrice['fixed_price'];

                if ($roomPriceType === 'Day') {
                    $roomTotal += $pricePerUnit * $this->numberOfDays;
                } elseif ($roomPriceType === 'Week') {
                    $roomTotal += ($pricePerUnit / 7) * $this->numberOfDays;
                } elseif ($roomPriceType === 'Month') {
                    $roomTotal += ($pricePerUnit / 28) * $this->numberOfDays;
                }

                $roomBookingTotal += $roomPrice['booking_price']; // Add the room's booking price
            }
        }
        $this->totalAmount += $roomTotal;
        $this->bookingPrice += $roomBookingTotal;

        // Add selected maintains and amenities prices
        foreach ($this->selectedMaintains as $maintain) {
            $this->totalAmount += $maintain['price'];
        }

        foreach ($this->selectedAmenities as $amenity) {
            $this->totalAmount += $amenity['price'];
        }
    }


    public function updatedPriceType()
    {
        $this->calculatePrices();
    }

    public function updatedRoomPriceTypes()
    {
        $this->calculatePrices();
    }

    public function submitBooking()
    {
        $this->showPaymentModal = true;
    }


    public function proceedPayment(Request $request)
    {
        if ($this->paymentOption === 'full') {
            $paymentAmount = $this->paymentAmount = round($this->totalAmount + $this->bookingPrice);
        } else {
            $paymentAmount = $this->paymentAmount = round($this->bookingPrice);
        }

        $roomIds = $this->selectedRooms->pluck('id')->toArray();

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'package_id' => $this->packageId,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
            'room_ids' => json_encode($roomIds),
            'number_of_days' => $this->numberOfDays,
            'price_type' => $this->priceType,
            'price' => $this->totalAmount,
            'booking_price' => $this->bookingPrice,
            'payment_option' => $this->paymentOption,
            'total_amount' => $paymentAmount,
            'payment_status' => 'pending'
        ]);

        if ($this->paymentMethod === 'card') {
            return $this->handleStripePayment($booking, $paymentAmount);

        }  else {
            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => $this->paymentMethod,
                'amount' => $paymentAmount,
                'status' => 'pending',
                'transaction_id' => $this->bankTransferReference
            ]);

            flash()->success('Booking submitted! Please follow the instructions to complete the payment.');
            session()->flush();
            return redirect()->route('booking.complete', $booking->id);
        }


    }

    protected function handleStripePayment($booking, $paymentAmount)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

        try {
            // Create a Checkout session
            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'gbp', // Change as per your currency
                        'product_data' => [
                            'name' => 'Booking Payment', // Customize as needed
                        ],
                        'unit_amount' => $paymentAmount * 100, // Stripe accepts amount in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('sucsess').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);

            // Redirect to Stripe Checkout page
            return redirect($session->url);

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle Stripe API errors
            return redirect()->back()->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        try {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $checkout_session = $stripe->checkout->sessions->retrieve(
                $sessionId,
                []
            );

            // Check if payment is successful
            if ($checkout_session->payment_status === 'paid') {

                $bookingId = $checkout_session->metadata->booking_id;
                $booking = Booking::findOrFail($bookingId);
                $booking->payment_status = 'paid';
                $booking->save();
                flash()->success('Booking submitted! Please follow the instructions to complete the payment.');
                return redirect()->route('booking.complete', $booking->id);
            } else {
                // Payment not successful
                return redirect()->route('cancel')->with('error', 'Payment unsuccessful.');
            }

        } catch (\Stripe\Exception\ApiErrorException $e) {
            return redirect()->route('cancel')->with('error', 'Stripe Error: ' . $e->getMessage());
        }
    }


    public function cancel()
    {
        return redirect()->route('package.list')->with('error', 'Payment cancelled.');
    }


    public function render()
    {
        return view('livewire.user.checkout-component', [
            'package' => $this->package,
            'totalAmount' => $this->totalAmount,
            'bookingPrice' => $this->bookingPrice,
            'prices' => $this->prices,
            'numberOfDays' => $this->numberOfDays,
            'stripePaymentIntent' => $this->stripePaymentIntent,
            'bankDetails' => $this->bankDetails,
            'selectedMaintains' => $this->selectedMaintains,
            'selectedAmenities' => $this->selectedAmenities,
        ])->layout('layouts.guest');
    }
}
