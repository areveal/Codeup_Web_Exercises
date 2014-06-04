<?php

function save($filename, $list) {
    //open the file for writing
	$write = fopen($filename, 'w');
	//write contact to the file
	foreach ($list as $address) {
		fputcsv($write, $address);
	}
	//close the handle
	fclose($write);
}

$places = ['Alcatraz','Astrodome','Augusta National Golf Club','Biltmore Estate','Central Park','Daytona Speedway', 'Fenway Park', 'Golden Gate Bridge', 'Hoover Dam', 'Lambeau Field', 'Stone Mountain'];

$streets = ['Cherry', 'Lannister', 'Stark', 'Dermatographic', 'mountain', 'interruptedness', 'outcity', 'forever', 'intermediary', 'terms', 'brickish', 'horticulture', 'gasp', 'vitrioled', 'cameos', 'prexistent', 'nonpaying', 'Prill', 'guru', 'preconformity', 'fourposter', 'reoffer', 'browsing', 'reinecke', 'retrogradely', 'articulability', 'outwish', 'derogate', 'prebesetting', 'defalcator', 'nondetrimental', 'Chordate', 'kolchak', 'eraser', 'heavyweight', 'postapostolic'];
$street_ends = ['street', 'lane', 'end', 'circle', 'boulevard'];

$cities = ['Dallas', 'Houston', 'Gotham', 'Smallville', 'Anderson', 'Vancouver', 'Whistler', 'San Franscisco', 'Seattle', 'Boulder', 'Denver', 'Los Angeles'];
$states = ['TX','FL','NY','CA','OK'];

$address_book = [];
for ($i=0; $i < 2; $i++) { 
	$place = $places[array_rand($places)];
	$street = ucfirst($streets[array_rand($streets)]);
	$end = ucfirst($street_ends[array_rand($street_ends)]);
	$city = $cities[array_rand($cities)];
	$state = $states[array_rand($states)];
	$nums = [];
	$zip = [];
	$phone = [];

	while(count($nums) < 4){
		$nums[] = mt_rand(0,9);
	}
	$nums = implode($nums);
	while(count($zip) < 5){
		$zip[] = mt_rand(0,9);
	}
	$zip = implode($zip);
	while(count($phone) < 9){
		$phone[] = mt_rand(0,9);
	}
	$phone = implode($phone);

	$address = $nums . ' ' . $street . ' ' . $end;
	$contact = [$place,$address,$city,$state,$zip,$phone];
	$address_book[] = $contact;


}

print_r($address_book);

save('address_import_list.csv', $address_book);

?>