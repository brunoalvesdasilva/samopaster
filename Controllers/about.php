<?PHP

// GET route Home
$app->get('/about.html', function () use ($app) {

    // About
    $app->render('about.phtml');

});
