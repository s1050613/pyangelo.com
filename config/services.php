<?php
$di = new Framework\Di($GLOBALS);

$di->set('dotenv', function () use ($di) {
  return Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
});

$di->set('routes', function () use ($di) {
  return require('routes.php');
});

$di->set('router', function () use ($di) {
  $router = new AltoRouter();
  $router->addRoutes($di->get('routes'));
  return $router;
});

$di->set('request', function () use ($di) {
  return new Framework\Request($GLOBALS);
});

$di->set('response', function () use ($di) {
  return new Framework\Response('../views');
});

$di->set('auth', function () use ($di) {
  return new PyAngelo\Auth\Auth(
    $di->get('personRepository'),
    $di->get('request')
  );
});

/* Repositories start here */
$di->set('dbh', function () use ($di) {
  return new \Mysqli(
    $_ENV['DB_HOST'],
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD'],
    $_ENV['DB_DATABASE']);
});

$di->set('campaignRepository', function () use ($di) {
  return new PyAngelo\Repositories\MysqlCampaignRepository($di->get('dbh'));
});

$di->set('mailRepository', function () use ($di) {
  return new PyAngelo\Repositories\MysqlMailRepository($di->get('dbh'));
});

$di->set('personRepository', function () use ($di) {
  return new PyAngelo\Repositories\MysqlPersonRepository($di->get('dbh'));
});

$di->set('sketchRepository', function () use ($di) {
  return new PyAngelo\Repositories\MysqlSketchRepository($di->get('dbh'));
});

$di->set('tutorialRepository', function () use ($di) {
  return new PyAngelo\Repositories\MysqlTutorialRepository($di->get('dbh'));
});

/* Form services start here */
$di->set('registerFormService', function () use ($di) {
  return new PyAngelo\FormServices\RegisterFormService (
    $di->get('personRepository'),
    $di->get('activateMembershipEmail'),
    $di->get('countryDetector'),
    [
      'requestScheme' => $di->get('request')->server['REQUEST_SCHEME'],
      'serverName' => $di->get('request')->server['SERVER_NAME']
    ]
  );
});

$di->set('forgotPasswordFormService', function () use ($di) {
  return new PyAngelo\FormServices\ForgotPasswordFormService (
    $di->get('personRepository'),
    $di->get('forgotPasswordEmail'),
    [
      'requestScheme' => $di->get('request')->server['REQUEST_SCHEME'],
      'serverName' => $di->get('request')->server['SERVER_NAME']
    ]
  );
});

$di->set('tutorialFormService', function () use ($di) {
  return new PyAngelo\FormServices\TutorialFormService (
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});


/* Email objects here */
$di->set('emailTemplate', function () use ($di) {
  return new PyAngelo\Email\EmailTemplate();
});

$di->set('activateMembershipEmail', function () use ($di) {
  return new PyAngelo\Email\ActivateMembershipEmail (
    $di->get('emailTemplate'),
    $di->get('mailRepository'),
    $di->get('mailer')
  );
});

$di->set('forgotPasswordEmail', function () use ($di) {
  return new PyAngelo\Email\ForgotPasswordEmail (
    $di->get('emailTemplate'),
    $di->get('mailRepository'),
    $di->get('mailer')
  );
});

$di->set('mailer', function () use ($di) {
  if ($_ENV['MAIL_METHOD'] == 'LoggerMail') {
    return new Framework\Mail\LoggerMail(
      $_ENV['APPLICATION_LOG_FILE']
    );
  }
  return new Framework\Mail\AwsSesMail(
    $_ENV['AWS_SES_KEY'],
    $_ENV['AWS_SES_SECRET'],
    $_ENV['AWS_SES_REGION']);
});

/* General objects start here */
$di->set('avatar', function () use ($di) {
  return new Framework\Presentation\Gravatar(75);
});

$di->set('countryDetector', function () use ($di) {
  return new PyAngelo\Utilities\CountryDetector(
    $di->get('request'),
    $di->get('geoReader')
  );
});

$di->set('geoReader', function () use ($di) {
  return new GeoIp2\Database\Reader($_ENV['GEOIP2_COUNTRY_DB']);
});

$di->set('numberFormatter', function () use ($di) {
  return new \NumberFormatter('en_US', NumberFormatter::CURRENCY);
});

$di->set('sketchFiles', function () use ($di) {
  return new PyAngelo\Utilities\SketchFiles(
    $_ENV['APPLICATION_DIRECTORY']
  );
});


/* Controllers Start Here */
$di->set('PageNotFoundController', function () use ($di) {
  return new PyAngelo\Controllers\PageNotFoundController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('HomePageController', function () use ($di) {
  return new PyAngelo\Controllers\HomePageController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('RegisterController', function () use ($di) {
  return new PyAngelo\Controllers\Registration\RegisterController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('RegisterValidateController', function () use ($di) {
  return new PyAngelo\Controllers\Registration\RegisterValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('registerFormService')
  );
});

$di->set('RegisterConfirmController', function () use ($di) {
  return new PyAngelo\Controllers\Registration\RegisterConfirmController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('RegisterActivateController', function () use ($di) {
  return new PyAngelo\Controllers\Registration\RegisterActivateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository')
  );
});

$di->set('RegisterThanksController', function () use ($di) {
  return new PyAngelo\Controllers\Registration\RegisterThanksController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('LogoutController', function () use ($di) {
  return new PyAngelo\Controllers\LogoutController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('LoginController', function () use ($di) {
  return new PyAngelo\Controllers\LoginController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('LoginValidateController', function () use ($di) {
  return new PyAngelo\Controllers\LoginValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('ForgotPasswordController', function () use ($di) {
  return new PyAngelo\Controllers\PasswordReset\ForgotPasswordController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('ForgotPasswordValidateController', function () use ($di) {
  return new PyAngelo\Controllers\PasswordReset\ForgotPasswordValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('forgotPasswordFormService')
  );
});

$di->set('ForgotPasswordConfirmController', function () use ($di) {
  return new PyAngelo\Controllers\PasswordReset\ForgotPasswordConfirmController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('ResetPasswordController', function () use ($di) {
  return new PyAngelo\Controllers\PasswordReset\ResetPasswordController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('ResetPasswordValidateController', function () use ($di) {
  return new PyAngelo\Controllers\PasswordReset\ResetPasswordValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository')
  );
});

$di->set('ProfileController', function () use ($di) {
  return new PyAngelo\Controllers\Profile\ProfileController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository'),
    $di->get('avatar')
  );
});

$di->set('PasswordController', function () use ($di) {
  return new PyAngelo\Controllers\Profile\PasswordController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth')
  );
});

$di->set('PasswordValidateController', function () use ($di) {
  return new PyAngelo\Controllers\Profile\PasswordValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository')
  );
});

$di->set('NewsletterController', function () use ($di) {
  return new PyAngelo\Controllers\Profile\NewsletterController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository')
  );
});

$di->set('NewsletterValidateController', function () use ($di) {
  return new PyAngelo\Controllers\Profile\NewsletterValidateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('personRepository'),
    $di->get('campaignRepository')
  );
});

$di->set('SketchIndexController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchIndexController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});

$di->set('SketchCreateController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchCreateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository'),
    $di->get('sketchFiles')
  );
});

$di->set('SketchShowController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchShowController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});

$di->set('SketchRunController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchRunController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});

$di->set('SketchPresentController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchPresentController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});

$di->set('SketchGetCodeController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchGetCodeController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository'),
    $_ENV['APPLICATION_DIRECTORY']
  );
});

$di->set('SketchSaveController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchSaveController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository'),
    $di->get('sketchFiles')
  );
});

$di->set('SketchForkController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchForkController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository'),
    $di->get('sketchFiles')
  );
});

$di->set('SketchRenameController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchRenameController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});

$di->set('SketchAddFileController', function () use ($di) {
  return new PyAngelo\Controllers\Sketch\SketchAddFileController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository'),
    $di->get('sketchFiles')
  );
});

$di->set('UploadAssetController', function () use ($di) {
  return new PyAngelo\Controllers\Upload\UploadAssetController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('sketchRepository')
  );
});
$di->set('CategoriesShowController', function () use ($di) {
  return new PyAngelo\Controllers\Categories\CategoriesShowController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('CategoriesSortController', function () use ($di) {
  return new PyAngelo\Controllers\Categories\CategoriesSortController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('CategoriesOrderController', function () use ($di) {
  return new PyAngelo\Controllers\Categories\CategoriesOrderController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('TutorialsIndexController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsIndexController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('TutorialsNewController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsNewController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('TutorialsCreateController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsCreateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialFormService')
  );
});

$di->set('TutorialsShowController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsShowController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('TutorialsEditController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsEditController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialRepository')
  );
});

$di->set('TutorialsUpdateController', function () use ($di) {
  return new PyAngelo\Controllers\Tutorials\TutorialsUpdateController (
    $di->get('request'),
    $di->get('response'),
    $di->get('auth'),
    $di->get('tutorialFormService')
  );
});
