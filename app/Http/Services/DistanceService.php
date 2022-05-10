<?php

namespace App\Http\Services;

class DistanceService {

    private $base_longitude;
    private $base_latitude;
    private const Radius = 6371000;

    public function __construct($base_longitude, $base_latitude)
    {
        $this->base_longitude = $base_longitude;
        $this->base_latitude = $base_latitude;
    }

    public function calculate($latitudeTo, $longitudeTo)
    {
          // convert from degrees to radians
        $latFrom = deg2rad($this->base_latitude);
        $lonFrom = deg2rad($this->base_longitude);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(
            sqrt(
                pow(sin($latDelta / 2), 2) + 
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
            )
        );
        return round($angle * self::Radius);
    }

    public function __toString()
    {
        return "Lat: $this->base_latitude \t Long: $this->base_longitude";
    }
}