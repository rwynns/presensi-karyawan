<?php

// Test location calculation
echo "Testing location calculation...\n";

$lat1 = -7.18290000; // Stasiun Doplang
$lon1 = 111.28796000;
$lat2 = -7.18290000; // Same location
$lon2 = 111.28796000;
$radius = 200;

$earthRadius = 6371000; // Earth radius in meters

$dLat = deg2rad($lat2 - $lat1);
$dLon = deg2rad($lon2 - $lon1);

$a = sin($dLat / 2) * sin($dLat / 2) +
    cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
    sin($dLon / 2) * sin($dLon / 2);

$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
$distance = $earthRadius * $c;

echo "Distance: " . $distance . " meters\n";
echo "Radius: " . $radius . " meters\n";
echo "Valid: " . ($distance <= $radius ? 'YES' : 'NO') . "\n";

// Test with slight difference
echo "\n--- Test with small difference ---\n";
$lat2 = -7.18295000; // Slightly different
$lon2 = 111.28801000;

$dLat = deg2rad($lat2 - $lat1);
$dLon = deg2rad($lon2 - $lon1);

$a = sin($dLat / 2) * sin($dLat / 2) +
    cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
    sin($dLon / 2) * sin($dLon / 2);

$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
$distance = $earthRadius * $c;

echo "Distance: " . $distance . " meters\n";
echo "Radius: " . $radius . " meters\n";
echo "Valid: " . ($distance <= $radius ? 'YES' : 'NO') . "\n";
