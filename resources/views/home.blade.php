@extends('layouts.app')

@section('content')
<div class="container main-container">

    <div class="row">

        <div class="col-md">
            @component('partials.dashboard-card', [
                'title' => 'Practice',
                'link' => route('practice.index'),
                'text' => 'Take a picture of each one of your targets and add some values for your analytics'
            ])
            @endcomponent
        </div>

        <div class="col-md">
            @component('partials.dashboard-card', [
                'title' => 'Ammo',
                'link' => route('ammo.index'),
                'text' => 'Add a picture of the ammo you will use in your practice.'
            ])
            @endcomponent
        </div>

        <div class="col-md">
            @component('partials.dashboard-card', [
                'title' => 'Gear',
                'link' => route('gear.index'),
                'text' => 'You have the option on include a photo of the gear configuration you are using today even is rental, borrow or owned.'
            ])
            @endcomponent
        </div>

        <div class="col-md">
            @component('partials.dashboard-card', [
                'title' => 'Locations',
                'link' => route('locations.index'),
                'text' => 'Add a photo or just the name of the gun range location you are practicing.'
            ])
            @endcomponent
        </div>

    </div>

</div>
@endsection
