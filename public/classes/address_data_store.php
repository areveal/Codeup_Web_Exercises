<?
//some fixed values for our address book

require_once('filestore.php');

class AddressDataStore extends Filestore {

    public $filename = '';

    function __construct($filename = '')
    {
        $filename = strtolower($filename);
        parent::__construct($filename);
    }


    function read_address_book()
    {
        // TODO: refactor to use new $this->read_csv() method
        $addresses = $this->read();
        return $addresses;
    }

    function write_address_book($addresses_array) 
    {
        // TODO: refactor to use new write_csv() method
        $this->write($addresses_array);
    }

}

?>