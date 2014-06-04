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

$places = ['Alcatraz','BatCave','Hogsmeade','Azkaban','Hogwarts','Disney World','Biltmore Estate','Fenway Park', 'Golden Gate Bridge', 'Hoover Dam', 'Lambeau Field','Gringots','The Wall'];

$streets = ['Cherry', 'Lannister', 'Stark', 'Arya','Sansa','Eddard','Baratheon','Renly','Stannis','theon','Greyjoy','Reek','The Hound','Clegane','Baker','Ice','The Mountain','Hermione','Sirius','Samwise','Gandalf','Ghost','Snow','Frodo','Legolas','PHP','JavaScript'];
$street_ends = ['street', 'lane', 'end', 'circle', 'boulevard','way'];

$cities = ['Dallas', 'Houston', 'Gotham', 'Smallville', 'Anderson','Winterfell','Kings Landing','Dragonstone','Vancouver', 'Whistler', 'San Franscisco', 'Seattle', 'Boulder', 'Denver', 'Los Angeles','London','Rivendale'];
$states = ['TX','FL','NY','CA','OK','Middle Earth'];

$address_book = [];
for ($i=0; $i < 2; $i++) { 
	$place = $places[array_rand($places)];
	$street = ucfirst($streets[array_rand($streets)]);
	switch($street){
		case 'Baratheon':
			$end = 'Way';
			break;
		case 'Lannister':
			$end = 'Lane';
			break;
		case 'Stannis':
			$end = 'Street';
			break;
		case 'Baker':
			$end = 'Street';
			break;
		case 'Eddard':
			$end = 'End';
			break;
		default:
			$end = ucfirst($street_ends[array_rand($street_ends)]);
			break;
	}
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