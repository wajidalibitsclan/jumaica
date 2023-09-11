<?php

	namespace Modules\Sms\Listeners;

	use Illuminate\Support\Facades\Log;
	use Modules\Booking\Events\BookingCreatedEvent;
	use Modules\Sms\Core\Facade\Sms;
	use Propaganistas\LaravelPhone\PhoneNumber;

	class SendSmsBookingListen
	{
		/**
		 * Create the event listener.
		 *
		 * @return void
		 */
		public $user;

		const CODE = [
			'id'           => '[booking_id]',
			'total'        => '[price]',
			'service_name' => '[service_name]',
			'start_date'   => '[start_date]',
			'total_guests' => '[total_guests]',
			'full_name' => '[full_name]',
			'pickup_location' => '[pickup_location]',
			'dropoff_location' => '[dropoff_location]',
			'customer_phone' => '[customer_phone]',
		];

		public function __construct()
		{
		}

		/**
		 * Handle the event.
		 *
		 * @param BookingCreatedEvent $event
		 * @return void
		 */
		public function handle(BookingCreatedEvent $event)
		{
			$booking = $event->booking;
			$vendor = $booking->vendor;
			$adminPhone = setting_item('admin_phone_has_booking');
			$adminCountry = setting_item('admin_country_has_booking');

			if (!empty($booking->phone) and !empty($booking->country) and !empty(setting_item('enable_sms_user_has_booking'))) {
				$message = $this->replaceMessage($booking, setting_item_with_lang('sms_message_user_when_booking', app()->getLocale()));
				try {
					$to = (string)PhoneNumber::make($booking->phone)->ofCountry($booking->country);
					Sms::to($to)->content($message)->send();
				} catch (\Exception $e) {
					Log::error($e->getMessage());
				}
			}

			if (!empty($vendor->phone) and !empty($vendor->country) and !empty(setting_item('enable_sms_vendor_has_booking'))) {
				$message = $this->replaceMessage($booking, setting_item_with_lang('sms_message_vendor_when_booking', app()->getLocale()));
				try {
					$to = (string)PhoneNumber::make($vendor->phone)->ofCountry($vendor->country);
					Sms::to($to)->content($message)->send();
				} catch (\Exception $e) {
					Log::error($e->getMessage());
				}
			}

			if (!empty($adminPhone) and !empty($adminCountry) and !empty(setting_item('enable_sms_admin_has_booking')) and !empty(setting_item('admin_phone_has_booking'))) {
				$message = $this->replaceMessage($booking, setting_item_with_lang('sms_message_admin_when_booking', app()->getLocale()));
				try {
					$to = (string)PhoneNumber::make($adminPhone)->ofCountry($adminCountry);
					Sms::to($to)->content($message)->send();
				} catch (\Exception $e) {
					Log::error($e->getMessage());
				}
			}
		}

		public function replaceMessage($booking, $content)
		{

			if (!empty($content)) {

                $meta = $booking->getJsonMeta('booking_car_information');

				foreach (self::CODE as $item => $value) {
					if ($value == '[service_name]') {
						if (!empty($booking->service->title)) {
							$content = str_replace('[service_name]', $booking->service->title, $content);
						}
					} elseif($value == '[full_name]') {
                        $name = $booking->first_name.' '.$booking->last_name;
                        $content = str_replace('[full_name]', $name, $content);

					} elseif($value == '[pickup_location]') {
                        $pickup_address = $meta['from_address'] ?? '';
                        $content = str_replace('[pickup_location]', $pickup_address, $content);

					} elseif($value == '[dropoff_location]') {
                        $drop_address = $meta['to_address'] ?? '';
                        $content = str_replace('[dropoff_location]', $drop_address, $content);

					} elseif($value == '[customer_phone]') {
                        $phone = $booking->phone ?? '';
                        $content = str_replace('[customer_phone]', $phone, $content);

					}else {
						$content = str_replace($value, @$booking->$item, $content);

					}
				}

			} else {
				return $this->replaceMessage($booking, $this->defaultContent());
			}
			return $content;
		}

		public function defaultContent()
		{
			return 'Service Name: [service_name]
					Price: [price]
					Date: [start_date]
					Total: [total_guests]
                    Full Name: [full_name]
                    Pickup Location: [pickup_location]
                    Dropoff Location: [dropoff_location]
                    Customer Phone: [customer_phone]'
                ;
		}
	}
