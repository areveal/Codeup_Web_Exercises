<?
//some fixed values for our address book

class AddressDataStore {

	//declare class attributes
    public $filename = '';
    public $addresses_array = [];
    //construct
    public function __construct($filename = 'address_book.csv') {
    	$this->filename = $filename;
    }
    //method to read from address book
    public function read_address_book() {
        //open the file for reading
        $read = fopen($this->filename, 'r');
        //while not at the end of file, add each contact to the array
		while(!feof($read)) {
			$contact = fgetcsv($read);
			//only if it is an array
			if(is_array($contact)) {
				$this->addresses_array[] = $contact;
			}
		}
		//close the handle
		fclose($read);
    }
    //method to write to address book
    public function write_address_book() {
        //open the file for writing
		$write = fopen($this->filename, 'w');
		//write contact to the file
		foreach ($this->addresses_array as $address) {
			fputcsv($write, $address);
		}
		//close the handle
		fclose($write);
    }

}

?>