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

	$app->delete('/stylist_form/{id}/delete_all_clients', function($id) use ($app) {
		$stylist = Stylist::find($id);
		$clients = $stylist->getClients();
		$single_client = $clients[0];
		$single_client->deleteClients();

		return $app['twig']->render('client_form.twig', array('stylist' => $stylist, 'clients' => $stylist->getClients()));
	});

	$app->delete('/stylist_form/{id}/deleteSingle', function($id) use ($app) {
		$client_id = $_POST['client_id'];
		$stylist = Stylist::find($id);

		$stylist_clients = $stylist->getClients();
		$that_client = null;
		foreach ($stylist_clients as $client) {
			if ($client->getId() == $client_id) {
				$that_client = $client;
			}
		}	
		$that_client->deleteSingle();
		return $app['twig']->render('client_form.twig', array('client_id' => $client_id, 'stylist' => $stylist, 'clients' => $stylist->getClients()));	
	});

	$app->post("/stylist_form/{id}/client/edit", function($id) use ($app) {
		$stylist = Stylist::find($id);
		$client_id = $_POST['client_id'];

		$stylist_clients = $stylist->getClients();
		$that_client = null;
		foreach ($stylist_clients as $client) {
			if ($client->getId() == $client_id) {
				$that_client = $client;
			}
		}	

        return $app['twig']->render('edit_client.twig', array('stylist' => $stylist, 'client_id' => $client_id, 'client' => $that_client));
    });

    $app->patch("/stylist_form/{id}/client/edit_client", function($id) use ($app) {
		$stylist = Stylist::find($id);
		$new_name = $_POST['new_name'];
		$client_id = $_POST['client_id'];

		$stylist_clients = $stylist->getClients();
		$that_client = null;
		foreach ($stylist_clients as $client) {
			if ($client->getId() == $client_id) {
				$that_client = $client;
			}
		}	
		$that_client->update($new_name);
		return $app['twig']->render('client_form.twig', array('client_id' => $client_id, 'stylist' => $stylist, 'clients' => $stylist->getClients()));	
	});


    return $app;

?>