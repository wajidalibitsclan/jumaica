<?php


    namespace Modules\Booking\Models;


    use Illuminate\Database\Eloquent\SoftDeletes;
    use Modules\Booking\Models\Bookable;
    use Modules\Booking\Models\Booking;

    class BookingPassenger extends Bookable
    {
        use SoftDeletes;
        protected $slugField = false;
        protected $slugFromField = false;
        protected $table ='bravo_booking_passengers';

        protected $fillable = [
            'booking_id',
            'seat_type',
            'email',
            'first_name',
            'last_name',
            'phone',
            'dob',
            'price',
            'id_card'
        ];

        public function booking(){
            return $this->belongsTo(Booking::class,'booking_id');
        }
    }
