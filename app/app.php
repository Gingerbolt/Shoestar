<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost:8889;dbname=shoestar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/", function() use ($app) {
      $name = $_POST['name'];
      $location = $_POST['location'];
      $new_store = new Store($name, $location);
      $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    // $app->get("/store/{id}", function($id) use ($app) {
    //
    //     return $app['twig']->render('store.html.twig', array('brands' => ))
    // });
    return $app;
?>
