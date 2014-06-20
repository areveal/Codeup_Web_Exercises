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
                throw new InvalidInputException("We're sorry. Your {$key} must be shorter than 125 characters.");
            }
        }
    }

}

?>