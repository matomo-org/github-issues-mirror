<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

function initView($app)
{
    $app->view->setData('projectName', PROJECT_NAME);
    $app->view->setData('githubOrganization', GITHUB_ORGANIZATION);
    $app->view->setData('githubRepository', GITHUB_REPOSITORY);
}

initView($app);

$app->get('/:number', function ($number) use ($app) {
    $number = (int) $number;

    $issue = new helpers\Issue();

    if (!$issue->exists($number)) {
        $app->pass();
        return;
    }

    $details = $issue->getIssue($number);

    $app->render('issue.twig', $details);

})->conditions(array('number' => '\d+'));

$app->get('/', function() use ($app) {
    $pageNumber = (int) $app->request()->get('page', 1);

    $page = new helpers\Page();

    if (!$page->exists($pageNumber)) {
        $app->pass();
        return;
    }

    $details = $page->getPage($pageNumber);

    $app->render('page.twig', $details);
});