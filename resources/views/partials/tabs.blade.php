<div class="container tabs-submenu">
    <div class="row">
        <div class="col-md-12">
            <div class="btn-group d-flex" role="group">
                <a class="btn {{ $blade == 'practice' ? 'btn-dark' : 'btn-outline-dark' }} w-100" role="button" href="{{ route('practice.index') }}">Practice</a>
                <a class="btn {{ $blade == 'ammo' ? 'btn-dark' : 'btn-outline-dark' }} w-100" role="button" href="{{ route('ammo.index') }}">Ammo</a>
                <a class="btn {{ $blade == 'gear' ? 'btn-dark' : 'btn-outline-dark' }} w-100" role="button" href="{{ route('gear.index') }}">Gear</a>
                <a class="btn {{ $blade == 'locations' ? 'btn-dark' : 'btn-outline-dark' }} w-100" role="button" href="{{ route('locations.index') }}">Locations</a>
            </div>
        </div>
    </div>
</div>