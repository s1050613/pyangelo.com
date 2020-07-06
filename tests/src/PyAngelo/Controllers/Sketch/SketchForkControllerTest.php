<?php
namespace tests\src\PyAngelo\Controllers\Sketch;

use PHPUnit\Framework\TestCase;
use Mockery;
use Dotenv\Dotenv;
use Framework\Request;
use Framework\Response;
use PyAngelo\Repositories\SketchRepository;
use PyAngelo\Controllers\Sketch\SketchForkController;

class SketchForkControllerTest extends TestCase {
  public function setUp(): void {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../../../', '.env.test');
    $dotenv->load();
    $this->appDir = $_ENV['APPLICATION_DIRECTORY'];;
    $this->request = new Request($GLOBALS);
    $this->response = new Response('views');
    $this->auth = Mockery::mock('PyAngelo\Auth\Auth');
    $this->sketchRepository = Mockery::mock('PyAngelo\Repositories\SketchRepository');
    $this->sketchFiles = Mockery::mock('PyAngelo\Utilities\SketchFiles');
    $this->controller = new SketchForkController (
      $this->request,
      $this->response,
      $this->auth,
      $this->sketchRepository,
      $this->sketchFiles
    );
  }
  public function tearDown(): void {
    Mockery::close();
  }

  public function testClassCanBeInstantiated() {
    $this->assertSame(get_class($this->controller), 'PyAngelo\Controllers\Sketch\SketchForkController');
  }

  public function testRedirectsToLoginPageWhenNotLoggedIn() {
    $this->auth->shouldReceive('loggedIn')->once()->with()->andReturn(false);

    $response = $this->controller->exec();
    $responseVars = $response->getVars();
    $expectedHeaders = array(array('header', 'Location: /login'));
    $this->assertSame($expectedHeaders, $response->getHeaders());
  }

  public function testRedirectsToHomePageWhenCrsfTokenInvalid() {
    $this->auth->shouldReceive('loggedIn')->once()->with()->andReturn(true);
    $this->auth->shouldReceive('crsfTokenIsValid')->once()->with()->andReturn(false);

    $response = $this->controller->exec();
    $responseVars = $response->getVars();
    $expectedHeaders = array(array('header', 'Location: /'));
    $this->assertSame($expectedHeaders, $response->getHeaders());
  }

  public function testRedirectsToHomePageWhenNoSketchId() {
    $this->auth->shouldReceive('loggedIn')->once()->with()->andReturn(true);
    $this->auth->shouldReceive('crsfTokenIsValid')->once()->with()->andReturn(true);

    $response = $this->controller->exec();
    $responseVars = $response->getVars();
    $expectedHeaders = array(array('header', 'Location: /'));
    $this->assertSame($expectedHeaders, $response->getHeaders());
  }

  public function testRedirectsToSketchPageWhenForkFails() {
    $anySketchId = 101;
    $this->request->post['sketchId'] = $anySketchId;

    $this->auth->shouldReceive('loggedIn')->once()->with()->andReturn(true);
    $this->auth->shouldReceive('crsfTokenIsValid')->once()->with()->andReturn(true);

    $anyPersonId = 101;
    $this->auth->shouldReceive('personId')->once()->with()->andReturn($anyPersonId);
    $this->sketchRepository
         ->shouldReceive('forkSketch')
         ->once()
         ->with($anySketchId, $anyPersonId, \Mockery::any())
         ->andReturn(NULL);

    $response = $this->controller->exec();
    $responseVars = $response->getVars();
    $expectedHeaders = array(array('header', 'Location: /sketch/' . $anySketchId));
    $this->assertSame($expectedHeaders, $response->getHeaders());
  }

  public function testSketchForkedSuccessfully() {
    $anySketchId = 101;
    $newSketchId = 1000;
    $sketchFiles = [
      'name' => 'main.py'
    ];
    $this->request->post['sketchId'] = $anySketchId;

    $this->auth->shouldReceive('loggedIn')->once()->with()->andReturn(true);
    $this->auth->shouldReceive('crsfTokenIsValid')->once()->with()->andReturn(true);

    $anyPersonId = 101;
    $this->auth->shouldReceive('personId')->once()->with()->andReturn($anyPersonId);
    $this->sketchRepository
         ->shouldReceive('forkSketch')
         ->once()
         ->with($anySketchId, $anyPersonId, \Mockery::any())
         ->andReturn($newSketchId);
    $this->sketchRepository
         ->shouldReceive('getSketchFiles')
         ->once()
         ->with($newSketchId)
         ->andReturn($sketchFiles);

    $this->sketchFiles
         ->shouldReceive('forkSketch')
         ->once()
         ->with($anySketchId, $newSketchId, $sketchFiles);

    $response = $this->controller->exec();
    $responseVars = $response->getVars();
    $expectedHeaders = array(array('header', 'Location: /sketch/' . $newSketchId));
    $this->assertSame($expectedHeaders, $response->getHeaders());
  }
}
?>
