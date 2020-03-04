<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\UploadedFile;

require '../vendor/autoload.php';
require '../assets/php/class.user.php';

//$app = new \Slim\App;
$app = new \Slim\App(['settings' => ['displayErrorDetails' => false,'addContentLengthHeader' => false]]);

// Upload images in uploads folder
$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';



//fetch model details by model id
$app->get('/model_details/{model_id}', function ($request, $response, $args) {

	$model_id=$args['model_id'];
	$user = new User();

	$query=$user->get_model_details($model_id);
	$jsondata=json_encode(array("error"=>false,"model_details" => $query));
	
	return $response->write($jsondata);
	});



// fetch manufacturer lists
	$app->get('/manufacturer_lists', function ($request, $response, $args) {

		$user = new User();
		
			$query=$user->get_manufacturer_lists();
			$responseData = array();
			while($res=mysqli_fetch_array($query))
			{
			   $temp = array();
			   $temp['manufacturer_id'] =  $res['manufacturer_id'];
			   $temp['manufacturer_name'] =  $res['manufacturer_name'];
			   array_push($responseData, $temp);
			  
			}
			$jsondata=json_encode($responseData);
	
			return $response->write($jsondata);
		});

		
// Fetch Inventory lists
		$app->get('/model_lists', function ($request, $response, $args) {

			$user = new User();
			
				$query=$user->get_model_lists();
				$responseData = array();
				while($res=mysqli_fetch_array($query))
				{
				   $temp = array();
				   $temp['model_id'] =  $res['model_id'];
				   $temp['model_name'] =  $res['model_name'];
				   $temp['model_color'] =  $res['model_color'];
				   $temp['model_manufacturer_year'] =  $res['model_manufacturer_year'];
                   $temp['manufacturer_id'] =  $res['manufacturer_id'];
				   $temp['manufacturer_name'] =  $res['manufacturer_name'];
				   $temp['registration_number'] =  $res['registration_number'];
				   $temp['Note'] =  $res['Note'];
				   $temp['count'] =  $res['inventory'];
				   array_push($responseData, $temp);
				  
				}
				$jsondata=json_encode($responseData);
		
				return $response->write($jsondata);
			});
	


// Add Manufacturer
$app->post('/add_manufacturer', function (Request $request, Response $response) {
    
        $requestData = $request->getParsedBody();
        $manufacturer_name = $requestData['manufacturer_name'];
       
		$user = new User();
        $responseData = array();

        $result = $user->add_new_manufaturer($manufacturer_name);

        if ($result) {
            $responseData['error'] = false;
            $responseData['message'] = 'Manufacturer added successfully';
           
         } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Error in adding manufacturer';
        }

        $response->getBody()->write(json_encode($responseData));
   
});

//Upload images
$app->post('/upload_images', function(Request $request, Response $response) {
	$requestData = $request->getParsedBody();
	$model_id = $requestData['model_id'];
    $directory = $this->get('upload_directory');
	$user = new User();
	$responseData = array();
	$result="";
    $uploadedFiles = $request->getUploadedFiles();
	foreach ($uploadedFiles['modelimages'] as $uploadedFile) {
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
			 $result = $user->add_images($model_id,$filename);
        }
    }

    $response->getBody()->write(json_encode($result));
});

/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFile $uploadedFile file uploaded file to move
 * @return string filename of moved file
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%0.8s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}

$app->post('/add_model', function (Request $request, Response $response) {
    
        $requestData = $request->getParsedBody();
		$model_name = $requestData['model_name'];
		$model_color = $requestData['model_color'];
		$model_manufacturer_year = $requestData['model_manufacturer_year'];
		$manufacturer_id = $requestData['manufacturer_id'];
		$registration_number = $requestData['registration_number'];
		$note = $requestData['note'];
		$count = 1;

		$user = new User();
        $responseData = array();
		
		$model_id = mt_rand(10000, 99999);
        $result = $user->add_new_model($model_id,$model_name, $model_color,$model_manufacturer_year,$manufacturer_id,$count,$registration_number,$note);

        if ($result) {
            $responseData['error'] = false;
			$responseData['message'] = 'Model added successfully';
			$responseData['model_id'] = $model_id;
           
         } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Error in adding model';
        }

        $response->getBody()->write(json_encode($responseData));
    
});

$app->post('/delete_model', function (Request $request, Response $response) {
    
        $requestData = $request->getParsedBody();
		$model_id = $requestData['model_id'];
		
       
		$user = new User();
        $responseData = array();
        $result = $user->delete_model($model_id);

        if ($result) {
            $responseData['error'] = false;
            $responseData['message'] = 'Model sold successfully';
           
         } else {
            $responseData['error'] = true;
            $responseData['message'] = 'Error in updating data';
        }

        $response->getBody()->write(json_encode($responseData));
    
});


// Run application
$app->run();




?>
