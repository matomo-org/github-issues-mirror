<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org/
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */


$app->get(
    '/{number:[0-9]+}', function ($request, $response, $args) {

    $number = (int)$args["number"];

    $issue = new helpers\Issue();

    if (!$issue->exists($number)) {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }

    $details = $issue->getIssue($number);
    return $this->view->render($response, 'issue.twig', $details);
})->setName("issue");

$app->get('/', function ($request, $response, $args) {
    /** @var \Slim\Http\Request $request */
    $pageNumber = (int)$request->getQueryParam('page', 1);

    $page = new helpers\Page();

    if (!$page->exists($pageNumber)) {
        throw new \Slim\Exception\NotFoundException($request, $response);
    }

    $details = $page->getPage($pageNumber);

    return $this->view->render($response, 'page.twig', $details);
})->setName("page");