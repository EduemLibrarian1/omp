<?php

/**
 * @file classes/services/OMPServiceProvider.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2000-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class OMPServiceProvider
 * @ingroup services
 *
 * @brief Utility class to package all OMP services
 */

namespace APP\services;

require_once(dirname(__FILE__) . '/../../lib/pkp/lib/vendor/pimple/pimple/src/Pimple/Container.php');
require_once(dirname(__FILE__) . '/../../lib/pkp/lib/vendor/pimple/pimple/src/Pimple/ServiceProviderInterface.php');

use Pimple\Container;

use PKP\services\PKPAnnouncementService;
use PKP\services\PKPAuthorService;
use PKP\services\PKPEmailTemplateService;
use PKP\services\PKPFileService;
use PKP\services\PKPSchemaService;
use PKP\services\PKPSiteService;
use PKP\services\PKPUserService;

class OMPServiceProvider implements \Pimple\ServiceProviderInterface
{
    /**
     * Registers services
     *
     * @param Pimple\Container $pimple
     */
    public function register(Container $pimple)
    {

        // Announcement service
        $pimple['announcement'] = function () {
            return new PKPAnnouncementService();
        };

        // File service
        $pimple['file'] = function () {
            return new PKPFileService();
        };

        // Submission service
        $pimple['submission'] = function () {
            return new SubmissionService();
        };

        // Publication service
        $pimple['publication'] = function () {
            return new PublicationService();
        };

        // PublicationFormat service
        $pimple['publicationFormat'] = function () {
            return new PublicationFormatService();
        };

        // NavigationMenus service
        $pimple['navigationMenu'] = function () {
            return new NavigationMenuService();
        };

        // Author service
        $pimple['author'] = function () {
            return new PKPAuthorService();
        };

        // User service
        $pimple['user'] = function () {
            return new PKPUserService();
        };

        // Context service
        $pimple['context'] = function () {
            return new ContextService();
        };

        // Submission file service
        $pimple['submissionFile'] = function () {
            return new SubmissionFileService();
        };

        // Email Template service
        $pimple['emailTemplate'] = function () {
            return new PKPEmailTemplateService();
        };

        // Schema service
        $pimple['schema'] = function () {
            return new PKPSchemaService();
        };

        // Site service
        $pimple['site'] = function () {
            return new PKPSiteService();
        };

        // Publication statistics service
        $pimple['stats'] = function () {
            return new StatsService();
        };

        // Publication statistics service
        $pimple['editorialStats'] = function () {
            return new StatsEditorialService();
        };
    }
}
