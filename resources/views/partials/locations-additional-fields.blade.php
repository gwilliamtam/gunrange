<div class="btn-group btn-group-toggle location-options-group" data-toggle="buttons" id="add-location-options">
    <label class="btn btn-dark" id="address-input">
        <input type="radio" autocomplete="off" checked> Address
    </label>
    <label class="btn btn-dark" id="map-input">
        <input type="radio" autocomplete="off"> Map
    </label>
    <label class="btn btn-dark" id="coordinates-input">
        <input type="radio" autocomplete="off"> Coordinates
    </label>
</div>

{{-- Additional Fields Buttons--}}
<div class="form-group location-options" id="field-address-input">
    {{--<label for="address">Location Address</label>--}}

    <input type="text" class="form-control" name="address" id="address" aria-describedby="address" placeholder="Enter location address">
    <button type="button" class="close close-field">
        <span aria-hidden="true">&times;</span>
    </button>
    <small id="addressHelp" class="form-text text-muted">Type or paste here the full address of the location (optional)</small>
</div>

{{-- Additional Fields Inputs --}}
<div class="form-group location-options" id="field-map-input">
    {{--<label for="map">Map</label>--}}
    <input type="text" class="form-control" name="map" id="map" aria-describedby="map" placeholder="Enter Google Maps URL">
    <button type="button" class="close close-field">
        <span aria-hidden="true">&times;</span>
    </button>
    <small id="mapHelp" class="form-text text-muted">Paste here Google Maps URL for the location map (optional)</small>
</div>

<div class="form-group location-options" id="field-coordinates-input">
    {{--<label for="coordinates">Coordinates</label>--}}
    <input type="text" class="form-control" name="coordinates" id="coordinates" aria-describedby="coordinates" placeholder="Enter coordinates here">
    <button type="button" class="close close-field">
        <span aria-hidden="true">&times;</span>
    </button>
    <small id="coordinatesHelp" class="form-text text-muted">Paste here the coordinates of the location (optional)</small>
</div>