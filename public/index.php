<?php 
require '../vendor/autoload.php';

use \Gee\Mongo;
use \Gee\Qiniu;


/*配置twig，也就是view层*/
$view = new \Slim\Views\Twig();
$view->parserOptions = array(
    'debug' => true,
    'charset' => 'utf-8',
    'cache' => realpath(TEMPLATEPATH.'cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension(),
);

/*初始化slim*/
$app = new \Slim\Slim(array(
	'templates.path' => TEMPLATEPATH,
    'view' => $view
));



/**获取assetic后的js 和 css*/
$assetic = new \Gee\Assetic();
$assetic = $assetic->result();
$css = $assetic['css'];
$js = $assetic['js'];


/** 单页面入口*/
$app->get('/', function () use ($app, $css, $js) {

	// $tag = array('name' => 'php');

	// $collation = \Gee\Mongo::getInstance()->create('tags', $tag);

    $app->render('index.html', array(
    	'css_path' => $css->getTargetPath(), 
    	'js_path' => $js->getTargetPath()
    	));
});



/** API */
$api_prefix = '/api';

$app->group($api_prefix, function () use ($app) {
	$app->group('/tags', function() use ($app) {
        $app->get('/', function() {
            $tags = Mongo::getInstance()->mongoList('tags');
            $tags = $tags['results'];
            foreach ($tags as $key => $tag) {
                $tagRef = \MongoDBRef::create('tags', new \MongoId($tag['_id']));
                $tags[$key]['count'] = Mongo::getInstance()->mongoCollectionCount('geees', array('tag' => $tagRef)); 
            }
            echo json_encode($tags);
        });

        $app->get('/:id/geees', function($id) use ($app) {

            $request = $app->request;
            $page = $request->get('page');
            $limit = $request->get('limit');

            $tagRef = \MongoDBRef::create('tags', new \MongoId($id));
            $select = array(
                'limit' => $limit?$limit:10,
                'page' => $page?$page:1,
                'filter' => array(
                    'tag' => $tagRef
                ),
                'sort' => array(
                    'updatedtime' => -1,
                    'createdtime' => -1
                )
            );
            $geees = Mongo::getInstance()->mongoList('geees', $select);
            $geees = $geees['results'];

            foreach ($geees as $key => $geee) {
                $geeeRef = \MongoDBRef::create('geees', new \MongoId($geee['_id']));
                $selectComments = array(
                    'limit' => $limit?$limit:10,
                    'page' => $page?$page:1,
                    'filter' => array(
                        'geee' => $geeeRef
                    ),
                    'sort' => array(
                        'createdtime' => -1
                    ) 
                );
                $comments = Mongo::getInstance()->mongoList('comments', $selectComments);
                if (!isset($geees[$key]['comments'])) {
                    $geees[$key]['comments'] = array();
                }
                $geees[$key]['commentsCount'] = count($geees[$key]['comments']);
                $geees[$key]['comments'] = $comments['results'];
            }

            echo json_encode($geees);
        });
	});


    $app->group('/geees', function() use ($app) {

        $app->post('/', function() use ($app) {
            $geee = json_decode($app->request()->getBody(), true);
            // foreach ($geee['images']  as $key => $value) {
            //     $geee['images'][$key] = Qiniu::getInstance()->url($value);
            // }
            $geee['createdtime'] = new \MongoDate();
            $geee['updatedtime'] = new \MongoDate();
            $geee['likes'] = 0;
            $geee['tag'] = \MongoDBRef::create('tags', new \MongoId($geee['tag']['_id']));
            $result = Mongo::getInstance()->create('geees', $geee);

            echo json_encode($result);
        });

        $app->get('/', function() use ($app) {
            $select = array(
                'limit' => 10,
                'page' => 1,
                'sort' => array(
                    'updatedtime' => -1,
                    'createdtime' => -1
                )
            );
            $geees = Mongo::getInstance()->mongoList('geees', $select, true);
            echo json_encode($geees['results']);
        });

        $app->get('/:id', function($id) {
            $select = array('_id' => new \MongoId($id));
            $geee = Mongo::getInstance()->findOne('geees', $select, true);
            if (!isset($geee['comments'])) {
                $geee['comments'] = array();
            }
            $geee['comments'] = array_reverse($geee['comments']);
            echo json_encode($geee);
        });

        $app->put('/:id/like', function($id) {
            $document = array(
                '$inc' => array(
                    'likes' => 1
                )
            );
            $result = Mongo::getInstance()->update('geees', $id, $document);
            echo json_encode($result);
        });

        $app->get('/:id/comments', function($id) use ($app) {

            $request = $app->request;
            $page = $request->get('page');
            $limit = $request->get('limit');

            $geeeRef = \MongoDBRef::create('geees', new \MongoId($id));
            $selectComments = array(
                'limit' => $limit?$limit:10,
                'page' => $page?$page:1,
                'filter' => array(
                    'geee' => $geeeRef
                ),
                'sort' => array(
                    'createdtime' => -1
                ) 
            );

            $comments = Mongo::getInstance()->mongoList('comments', $selectComments);
            echo json_encode($comments['results']);
        });
    });

    $app->group('/comments', function() use ($app) {
        $app->post('/', function() use ($app) {
            $comment = json_decode($app->request()->getBody(), true);
            $comment['createdtime'] = new \MongoDate();
            $comment['geee'] = \MongoDBRef::create('geees', new \MongoId($comment['geee']['_id']));
            $comment['likes'] = 0;
            $result = Mongo::getInstance()->create('comments', $comment);
            if (empty($result['error'])) {
                $commentRef = \MongoDBRef::create('comments', new \MongoId($result['_id']));
                $document = array(
                    '$push' => array(
                        'comments' => $commentRef,
                        'updatedtime' => new \MongoDate()
                        )
                    );
                $resultback = Mongo::getInstance()->update('geees', $comment['geee']['$id'], $document);
                if (!empty($resultback['error'])) {
                    echo json_encode($resultback);
                    return false;
                }
            }

            echo json_encode($result);
        });

    });


    $app->group('/images', function() use ($app) {
        $app->post('/', function() use ($app) {
            if (!empty($_FILES)) {
                $file = $_FILES['file']['tmp_name'];
                $result = Qiniu::getInstance()->upload($file);
                echo json_encode($result);
            }
        });

        $app->delete('/:key', function($key) use ($app) {
            if ($key) {
                $result = Qiniu::getInstance()->delete($key);
                echo json_encode($result);
            }

        });
    });
});


$app->run();