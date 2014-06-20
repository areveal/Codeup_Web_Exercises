<?
//some fixed values for our address book

require_once('filestore.php');

class AddressDataStore extends Filestore {

    public $filename = '';
    public $isValid = false;

    public function __construct($filename = '')
    {
        $filename = strtolower($filename);
        parent::__construct($filename);
    }


    public function read_address_book()
    {
        // TODO: refactor to use new $this->read_csv() method
        $addresses = $this->read();
        return $addresses;
    }

    public function write_address_book($addresses_array) 
    {
        // TODO: refactor to use new write_csv() method
        $this->write($addresses_array);
    }

    public function validate($input) 
    {
        foreach ($input as $key => $value) {
            if (strlen($value) > 125) {
                throw new Exception("We're sorry. Your {$key} must be shorter than 125 characters.");
            }
        }
    }
    
    public function add_item($input)
    {
        if(!empty($input['name']) && !empty($input['address']) && !empty($input['city']) && !empty($input['state']) && !empty($input['zip'])) {
            //validate inputs
            $this->validate($input);
            
            $this->isValid = true;
            //create new address to add
            $new_address = $input;
            //add new address
            return $new_address;
        }
    }

}

?>