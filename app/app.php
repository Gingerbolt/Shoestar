<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $server = 'mysql:host=localhost:8889;dbname=shoestar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $app = new Silex\Application();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app['debug'] = true;

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/{id}/delete", function($id) use ($app) {
        $current_store = Store::find($id);
        $current_store->delete();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->post("/store_post", function() use ($app) {
      $name = $_POST['name'];
      $location = $_POST['location'];
      $name = ucfirst($name);
      $new_store = new Store($name, $location);
      $new_store->save();
        return $app['twig']->render('index.html.twig', array('stores' => Store::getAll()));
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $current_store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $current_store, 'brands' => $current_store->getBrands(), 'all_brands' => Brand::getAll()));
    });

    $app->post("/brand_post", function() use ($app) {
        if (empty($_POST['name'])) {
        $brand_id = $_POST['brand_add'];
        $add_brand = Brand::find($brand_id);
        $store_id = $_POST['store_id'];
        $add_brand->setStore($store_id);
        }
        else
        {
        $store_id = $_POST['store_id'];
        $name = ucfirst($_POST['name']);
        $price_range = $_POST['price_range'];
        $new_brand = new Brand($name, $price_range);
        $new_brand->save();
        $new_brand->setStore($store_id);
        }
        $current_store = Store::find($store_id);
        $brands = $current_store->getBrands();
        return $app['twig']->render('store.html.twig', array('store' => $current_store, 'brands' => $brands, 'all_brands' => Brand::getAll()));
    });

    return $app;
?>
