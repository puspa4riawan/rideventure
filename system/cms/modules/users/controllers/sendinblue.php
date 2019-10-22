<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User controller for the users module (frontend)
 *
 * @author		 Phil Sturgeon
 * @author		MaxCMS Dev Team
 * @package		MaxCMS\Core\Modules\Users\Controllers
 */
class Sendinblue extends Public_Controller
{
	public function __construct(){

	}

	public function addContactToList($listId,$contactEmails){
		require_once(__DIR__ . '/vendor/autoload.php');

		// Configure API key authorization: api-key
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'YOUR_API_KEY');
		// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
		// $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('api-key', 'Bearer');
		// Configure API key authorization: partner-key
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('partner-key', 'YOUR_API_KEY');
		// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
		// $config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKeyPrefix('partner-key', 'Bearer');

		$apiInstance = new SendinBlue\Client\Api\ContactsApi(
		    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
		    // This is optional, `GuzzleHttp\Client` will be used as default.
		    new GuzzleHttp\Client(),
		    $config
		);
		$listId = 789; // int | Id of the list
		$contactEmails = new \SendinBlue\Client\Model\AddContactToList(); // \SendinBlue\Client\Model\AddContactToList | Emails addresses of the contacts

		try {
		    $result = $apiInstance->addContactToList($listId, $contactEmails);
		    print_r($result);
		} catch (Exception $e) {
		    echo 'Exception when calling ContactsApi->addContactToList: ', $e->getMessage(), PHP_EOL;
		}
	}
}