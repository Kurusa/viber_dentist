<?php
return [
    'phonenumber' => \App\Commands\AskPhonenumber::class,
    'birthday' => \App\Commands\AskBirthday::class,
    'full_name' => \App\Commands\OfferAppointment::class,
    'phone_number' => \App\Commands\OfferAppointment::class,
    'my_record' => \App\Commands\MyRecords::class,
    'how_long_rec' => \App\Commands\MyRecords::class,
    'how_long_time_rec' => \App\Commands\MyRecords::class,
    'select_day_rec' => \App\Commands\MyRecords::class,
    'select_time_rec' => \App\Commands\MyRecords::class,
    'selecting_rec_time' => \App\Commands\CreateAppointment::class,
    'service_list' => \App\Commands\ServiceList::class,
    'select_day' => \App\Commands\OfferAppointment::class,

    'select_time' => \App\Commands\OfferAppointment::class,
    'free_records' => \App\Commands\OfferAppointment::class,
    'how_long' => \App\Commands\OfferAppointment::class,
    'how_long_time' => \App\Commands\OfferAppointment::class,
    'full_name_profile' => \App\Commands\Profile::class,
    'phone_number_profile' => \App\Commands\Profile::class,
];