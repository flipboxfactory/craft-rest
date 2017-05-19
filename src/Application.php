<?php
/**
 * @link      http://buildwithcraft.com/
 * @copyright Copyright (c) 2015 Pixel & Tonic, Inc.
 * @license   http://buildwithcraft.com/license
 */

namespace flipbox\rest;

use Craft;
use craft\base\ApplicationTrait;
use craft\helpers\FileHelper;
use yii\web\Response;
use craft\web\ServiceUnavailableHttpException;
use craft\web\View;
use flipbox\spark\helpers\ArrayHelper;

class Application extends \yii\web\Application
{

    use ApplicationTrait;

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {

        Craft::$app = $this;

        // Remove any debug toolbar
        ArrayHelper::remove($config, 'debug');
//
//        var_dump($config);
//        exit;

        parent::__construct($config);
    }

    /**
     * Initializes the application.
     *
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->_init();
    }


    /**
     * Handles the specified request.
     *
     * @param Request $request the request to be handled
     *
     * @return Response the resulting response
     * @throws HttpException
     * @throws ServiceUnavailableHttpException
     * @throws \craft\errors\DbConnectException
     * @throws ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     */
    public function handleRequest($request): Response
    {

//        var_dump($request);

        // Load rules

//        exit;


        // If the system in is maintenance mode and it's a site request, throw a 503.
        if ($this->getIsInMaintenanceMode() && $request->getIsSiteRequest()) {
//            $this->_unregisterDebugModule();
            throw new ServiceUnavailableHttpException();
        }

//        // Process install requests
//        if (($response = $this->_processInstallRequest($request)) !== null) {
//            return $response;
//        }

//        // Check if the app path has changed.  If so, run the requirements check again.
//        if (($response = $this->_processRequirementsCheck($request)) !== null) {
//            $this->_unregisterDebugModule();
//
//            return $response;
//        }

        // Makes sure that the uploaded files are compatible with the current database schema
        if (!$this->getUpdates()->getIsSchemaVersionCompatible()) {
//            $this->_unregisterDebugModule();

//            if ($request->getIsCpRequest()) {
//                $version = $this->getInfo()->version;
//                $url = App::craftDownloadUrl($version);
//
//                throw new HttpException(200, Craft::t('app', 'Craft CMS does not support backtracking to this version. Please upload Craft CMS {url} or later.', [
//                    'url' => "[{$version}]({$url})",
//                ]));
//            } else {
                throw new ServiceUnavailableHttpException();
//            }
        }

        // getIsCraftDbMigrationNeeded will return true if we're in the middle of a manual or auto-update for Craft itself.
        // If we're in maintenance mode and it's not a site request, show the manual update template.
        if ($this->getIsUpdating()) {
            throw new ServiceUnavailableHttpException();
//            return $this->_processUpdateLogic($request) ?: $this->getResponse();
        }

        // If there's a new version, but the schema hasn't changed, just update the info table
        if ($this->getUpdates()->getHasCraftVersionChanged()) {
            $this->getUpdates()->updateCraftVersionInfo();

//            // Clear the template caches in case they've been compiled since this release was cut.
//            FileHelper::clearDirectory($this->getPath()->getCompiledTemplatesPath());
        }

        if(!$this->getIsSystemOn()) {
            throw new ServiceUnavailableHttpException();
        }

        // If the system is offline, make sure they have permission to be here
        if(!$this->getIsSystemOn()) {
            throw new ServiceUnavailableHttpException();
        }
//        $this->_enforceSystemStatusPermissions($request);

        // Check if a plugin needs to update the database.
        if ($this->getUpdates()->getIsPluginDbUpdateNeeded()) {
            throw new ServiceUnavailableHttpException();
//            return $this->_processUpdateLogic($request) ?: $this->getResponse();
        }

//        // If this is a non-login, non-validate, non-setPassword CP request, make sure the user has access to the CP
//        if ($request->getIsCpRequest() && !($request->getIsActionRequest() && $this->_isSpecialCaseActionRequest($request))) {
//            $user = $this->getUser();
//
//            // Make sure the user has access to the CP
//            if ($user->getIsGuest()) {
//                return $user->loginRequired();
//            }
//
//            if (!$user->checkPermission('accessCp')) {
//                throw new ForbiddenHttpException();
//            }
//
//            // If they're accessing a plugin's section, make sure that they have permission to do so
//            $firstSeg = $request->getSegment(1);
//
//            if ($firstSeg !== null) {
//                /** @var Organization|null $plugin */
//                $plugin = $plugin = $this->getPlugins()->getPlugin($firstSeg);
//
//                if ($plugin && !$user->checkPermission('accessPlugin-'.$plugin->handle)) {
//                    throw new ForbiddenHttpException();
//                }
//            }
//        }
//
//        // If this is an action request, call the controller
//        if (($response = $this->_processActionRequest($request)) !== null) {
//            return $response;
//        }

        // If we're still here, finally let Yii do it's thing.
        return parent::handleRequest($request);

    }

}