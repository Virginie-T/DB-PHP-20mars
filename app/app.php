<?php  

    require_once __DIR__."/../vendor/autoload.php";
	require_once __DIR__."/../src/Stylist.php";
	require_once __DIR__."/../src/Client.php";

	$app = new Silex\Application();
	$app['debug'] = true;


    $DB = new PDO('pgsql:host=localhost;dbname=hair_salon');

	$app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

	use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('stylist_form.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post('/add_stylist', function() use ($app) {
    	$name = $_POST['name'];
    	$id = null;
    	$new_stylist = new Stylist($name, $id);
    	$new_stylist->save();
    	return $app['twig']->render('stylist_form.twig', array('stylists' => Stylist::getAll()));
    });

	$app->get('/stylist_form/{id}', function($id) use ($app) {
		$stylist = Stylist::find($id);
		return $app['twig']->render('client_form.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
	});

	$app->post('/delete_all_the_stylists', function() use ($app) {
		Stylist::deleteAll();
		return $app['twig']->render('stylist_form.twig', array('stylists' => Stylist::getAll()));
	});

	$app->post('/add_client', function() use ($app) {
		$name = $_POST['name'];
		$id = null;
		$stylist_id = $_POST['stylist_id'];
		$new_client = new Client($name, $id, $stylist_id);
		$new_client->save();
		$stylist = Stylist::find($stylist_id);
		return $app['twig']->render('client_form.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
	});

	$app->post('/delete_all_the_clients', function() use ($app) {
		$stylist_id = $_POST['stylist_id'];
		$stylist = Stylist::find($stylist_id);
		Client::deleteAll();

		return $app['twig']->render('client_form.twig', array('stylist' => $stylist, 'clients' => Client::getAll()));
	});

    return $app;

?>