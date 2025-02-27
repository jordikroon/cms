<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace craft\web\assets\cp;

use Craft;
use craft\base\ElementInterface;
use craft\config\GeneralConfig;
use craft\elements\User;
use craft\helpers\Assets;
use craft\helpers\Cp;
use craft\helpers\Html;
use craft\helpers\Json;
use craft\helpers\StringHelper;
use craft\helpers\UrlHelper;
use craft\i18n\Locale;
use craft\models\Section;
use craft\services\Sites;
use craft\web\AssetBundle;
use craft\web\assets\axios\AxiosAsset;
use craft\web\assets\d3\D3Asset;
use craft\web\assets\datepickeri18n\DatepickerI18nAsset;
use craft\web\assets\elementresizedetector\ElementResizeDetectorAsset;
use craft\web\assets\fabric\FabricAsset;
use craft\web\assets\fileupload\FileUploadAsset;
use craft\web\assets\focusvisible\FocusVisibleAsset;
use craft\web\assets\garnish\GarnishAsset;
use craft\web\assets\iframeresizer\IframeResizerAsset;
use craft\web\assets\jquerypayment\JqueryPaymentAsset;
use craft\web\assets\jquerytouchevents\JqueryTouchEventsAsset;
use craft\web\assets\jqueryui\JqueryUiAsset;
use craft\web\assets\picturefill\PicturefillAsset;
use craft\web\assets\selectize\SelectizeAsset;
use craft\web\assets\tailwindreset\TailwindResetAsset;
use craft\web\assets\velocity\VelocityAsset;
use craft\web\assets\xregexp\XregexpAsset;
use craft\web\View;
use yii\web\JqueryAsset;

/**
 * Asset bundle for the control panel
 */
class CpAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__ . '/dist';

    /**
     * @inheritdoc
     */
    public $depends = [
        TailwindResetAsset::class,
        AxiosAsset::class,
        D3Asset::class,
        ElementResizeDetectorAsset::class,
        FocusVisibleAsset::class,
        GarnishAsset::class,
        JqueryAsset::class,
        JqueryTouchEventsAsset::class,
        JqueryUiAsset::class,
        JqueryPaymentAsset::class,
        DatepickerI18nAsset::class,
        PicturefillAsset::class,
        SelectizeAsset::class,
        VelocityAsset::class,
        FileUploadAsset::class,
        XregexpAsset::class,
        FabricAsset::class,
        IframeResizerAsset::class,
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        'css/cp.css',
    ];

    /**
     * @inheritdoc
     */
    public $js = [
        'cp.js',
    ];

    /**
     * @inheritdoc
     */
    public function registerAssetFiles($view): void
    {
        parent::registerAssetFiles($view);

        if ($view instanceof View) {
            $this->_registerTranslations($view);
        }

        // Define the Craft object
        $craftJson = Json::encode($this->_craftData(), JSON_UNESCAPED_UNICODE);
        $js = <<<JS
window.Craft = $craftJson;
JS;
        $view->registerJs($js, View::POS_HEAD);
    }

    /**
     * @param View $view
     */
    private function _registerTranslations(View $view): void
    {
        $view->registerTranslations('app', [
            '(blank)',
            '<span class="visually-hidden">Characters left:</span> {chars, number}',
            'A server error occurred.',
            'Actions',
            'Add…',
            'All',
            'Any changes will be lost if you leave this page.',
            'Apply this to the {number} remaining conflicts?',
            'Apply',
            'Are you sure you want to close the editor? Any changes will be lost.',
            'Are you sure you want to close this screen? Any changes will be lost.',
            'Are you sure you want to delete this address?',
            'Are you sure you want to delete this image?',
            'Are you sure you want to delete “{name}”?',
            'Are you sure you want to discard your changes?',
            'Are you sure you want to transfer your license to this domain?',
            'Buy {name}',
            'Cancel',
            'Choose a user',
            'Choose which table columns should be visible for this source, and in which order.',
            'Choose which user groups should have access to this source.',
            'Clear',
            'Close Preview',
            'Close',
            'Color hex value',
            'Color picker',
            'Continue',
            'Copied to clipboard.',
            'Copy the URL',
            'Copy the reference tag',
            'Copy to clipboard',
            'Couldn’t delete “{name}”.',
            'Couldn’t save new order.',
            'Create',
            'Delete custom source',
            'Delete folder',
            'Delete heading',
            'Delete their content',
            'Delete them',
            'Delete {num, plural, =1{user} other{users}} and content',
            'Delete {num, plural, =1{user} other{users}}',
            'Delete',
            'Desktop',
            'Device type',
            'Discard changes',
            'Discard',
            'Display as thumbnails',
            'Display in a table',
            'Done',
            'Draft Name',
            'Edit draft settings',
            'Edit',
            'Edited',
            'Element',
            'Elements',
            'Enabled for {site}',
            'Enabled',
            'Enter the name of the folder',
            'Enter your password to continue.',
            'Enter your password to log back in.',
            'Error',
            'Export Type',
            'Export',
            'Export…',
            'Failed',
            'Format',
            'From {date}',
            'From',
            'Give your tab a name.',
            'Handle',
            'Heading',
            'Hide nested sources',
            'Hide sidebar',
            'Hide',
            'Incorrect password.',
            'Information',
            'Instructions',
            'Keep both',
            'Keep me logged in',
            'Keep them',
            'Label',
            'Landscape',
            'License transferred.',
            'Limit',
            'Loading',
            'Make not required',
            'Make required',
            'Matrix block could not be added. Maximum number of blocks reached.',
            'Merge the folder (any conflicting files will be replaced)',
            'Mobile',
            'More',
            'More…',
            'Move down',
            'Move to the left',
            'Move to the right',
            'Move up',
            'Move',
            'Name',
            'New category',
            'New child',
            'New custom source',
            'New entry',
            'New heading',
            'New order saved.',
            'New position saved.',
            'New subfolder',
            'New {group} category',
            'New {section} entry',
            'Next Page',
            'No limit',
            'Notes',
            'Notice',
            'OK',
            'Open the full edit page in a new tab',
            'Options',
            'Password',
            'Past year',
            'Past {num} days',
            'Pay {price}',
            'Pending',
            'Phone',
            'Portrait',
            'Preview',
            'Previewing {type} device in {orientation}',
            'Previewing {type} device',
            'Previous Page',
            'Really delete folder “{folder}”?',
            'Refresh',
            'Remove {label}',
            'Remove',
            'Rename folder',
            'Rename',
            'Reorder',
            'Replace it',
            'Replace the folder (all existing files will be deleted)',
            'Rotate',
            'Save as a new asset',
            'Save',
            'Saved {timestamp} by {creator}',
            'Saved {timestamp}',
            'Saving',
            'Score',
            'Search in subfolders',
            'Select all',
            'Select transform',
            'Select',
            'Settings',
            'Show nav',
            'Show nested sources',
            'Show sidebar',
            'Show',
            'Show/hide children',
            'Showing your unsaved changes.',
            'Sign in',
            'Sign out now',
            'Skip to {title}',
            'Sort by {attribute}',
            'Source settings saved',
            'Structure',
            'Submit',
            'Switching sites will lose unsaved changes. Are you sure you want to switch sites?',
            'Table Columns',
            'Tablet',
            'The draft could not be saved.',
            'The draft has been saved.',
            'This can be left blank if you just want an unlabeled separator.',
            'This field has been modified.',
            'This month',
            'This week',
            'This year',
            'Tip',
            'To {date}',
            'To',
            'Today',
            'Top of preview',
            'Transfer it to:',
            'Try again',
            'Update {type}',
            'Upload a file',
            'Upload failed for {filename}',
            'Upload files',
            'User Groups',
            'View',
            'Warning',
            'What do you want to do with their content?',
            'What do you want to do?',
            'You must specify a tab name.',
            'Your changes could not be stored.',
            'Your changes have been stored.',
            'Your session has ended.',
            'Your session will expire in {time}.',
            'by {creator}',
            'day',
            'days',
            'hour',
            'hours',
            'minute',
            'minutes',
            'second',
            'seconds',
            'week',
            'weeks',
            '{ctrl}C to copy.',
            '{first, number}-{last, number} of {total, number} {total, plural, =1{{item}} other{{items}}}',
            '{first}-{last} of {total}',
            '{num, number} {num, plural, =1{Available Update} other{Available Updates}}',
            '{total, number} {total, plural, =1{{item}} other{{items}}}',
            '{type} Criteria',
            '{type} saved.',
            '“{name}” deleted.',
        ]);
    }

    private function _craftData(): array
    {
        $upToDate = Craft::$app->getIsInstalled() && !Craft::$app->getUpdates()->getAreMigrationsPending();
        $request = Craft::$app->getRequest();
        $generalConfig = Craft::$app->getConfig()->getGeneral();
        $sitesService = Craft::$app->getSites();
        $formattingLocale = Craft::$app->getFormattingLocale();
        $locale = Craft::$app->getLocale();
        $orientation = $locale->getOrientation();
        $userSession = Craft::$app->getUser();
        $currentUser = $userSession->getIdentity();
        $primarySite = $upToDate ? $sitesService->getPrimarySite() : null;

        $elementTypeNames = [];
        foreach (Craft::$app->getElements()->getAllElementTypes() as $elementType) {
            /** @var string|ElementInterface $elementType */
            /** @phpstan-var class-string<ElementInterface>|ElementInterface $elementType */
            $elementTypeNames[$elementType] = [
                $elementType::displayName(),
                $elementType::pluralDisplayName(),
                $elementType::lowerDisplayName(),
                $elementType::pluralLowerDisplayName(),
            ];
        }

        $data = [
            'actionTrigger' => $generalConfig->actionTrigger,
            'actionUrl' => UrlHelper::actionUrl(),
            'allowAdminChanges' => $generalConfig->allowAdminChanges,
            'allowUpdates' => $generalConfig->allowUpdates,
            'allowUppercaseInSlug' => $generalConfig->allowUppercaseInSlug,
            'announcements' => $upToDate ? Craft::$app->getAnnouncements()->get() : [],
            'apiParams' => Craft::$app->apiParams,
            'appId' => Craft::$app->id,
            'asciiCharMap' => StringHelper::asciiCharMap(true, Craft::$app->language),
            'autosaveDrafts' => $generalConfig->autosaveDrafts,
            'baseApiUrl' => Craft::$app->baseApiUrl,
            'baseCpUrl' => UrlHelper::cpUrl(),
            'baseSiteUrl' => UrlHelper::siteUrl(),
            'baseUrl' => UrlHelper::url(),
            'canAccessQueueManager' => $userSession->checkPermission('utility:queue-manager'),
            'clientOs' => $request->getClientOs(),
            'cpTrigger' => $generalConfig->cpTrigger,
            'dataAttributes' => Html::$dataAttributes,
            'datepickerOptions' => $this->_datepickerOptions($formattingLocale, $locale, $currentUser, $generalConfig),
            'defaultCookieOptions' => $this->_defaultCookieOptions(),
            'defaultIndexCriteria' => [],
            'editableCategoryGroups' => $upToDate ? $this->_editableCategoryGroups() : [],
            'edition' => Craft::$app->getEdition(),
            'elementTypeNames' => $elementTypeNames,
            'fileKinds' => Assets::getFileKinds(),
            'handleCasing' => $generalConfig->handleCasing,
            'httpProxy' => $this->_httpProxy($generalConfig),
            'isImagick' => Craft::$app->getImages()->getIsImagick(),
            'isMultiSite' => Craft::$app->getIsMultiSite(),
            'language' => Craft::$app->language,
            'left' => $orientation === 'ltr' ? 'left' : 'right',
            'limitAutoSlugsToAscii' => $generalConfig->limitAutoSlugsToAscii,
            'maxUploadSize' => Assets::getMaxUploadSize(),
            'omitScriptNameInUrls' => $generalConfig->omitScriptNameInUrls,
            'orientation' => $orientation,
            'pageNum' => $request->getPageNum(),
            'pageTrigger' => $generalConfig->getPageTrigger(),
            'path' => $request->getPathInfo(),
            'pathParam' => $generalConfig->pathParam,
            'previewIframeResizerOptions' => $this->_previewIframeResizerOptions($generalConfig),
            'primarySiteId' => $primarySite ? (int)$primarySite->id : null,
            'primarySiteLanguage' => $primarySite->language ?? null,
            'Pro' => Craft::Pro,
            'publishableSections' => $upToDate && $currentUser ? $this->_publishableSections($currentUser) : [],
            'registeredAssetBundles' => ['' => ''], // force encode as JS object
            'registeredJsFiles' => ['' => ''], // force encode as JS object
            'remainingSessionTime' => !in_array($request->getSegment(1), ['updates', 'manualupdate'], true) ? $userSession->getRemainingSessionTime() : 0,
            'right' => $orientation === 'ltr' ? 'right' : 'left',
            'runQueueAutomatically' => $generalConfig->runQueueAutomatically,
            'scriptName' => basename($request->getScriptFile()),
            'siteId' => $upToDate ? (Cp::requestedSite()->id ?? null) : null,
            'sites' => $this->_sites($sitesService),
            'siteToken' => $generalConfig->siteToken,
            'slugWordSeparator' => $generalConfig->slugWordSeparator,
            'Solo' => Craft::Solo,
            'systemUid' => Craft::$app->getSystemUid(),
            'timepickerOptions' => $this->_timepickerOptions($formattingLocale, $orientation),
            'timezone' => Craft::$app->getTimeZone(),
            'tokenParam' => $generalConfig->tokenParam,
            'translations' => ['' => ''], // force encode as JS object
            'usePathInfo' => $generalConfig->usePathInfo,
            'username' => $currentUser->username ?? null,
        ];

        if ($generalConfig->enableCsrfProtection) {
            $data['csrfTokenName'] = $request->csrfParam;
            $data['csrfTokenValue'] = $request->getCsrfToken();
        }

        return $data;
    }

    private function _datepickerOptions(Locale $formattingLocale, Locale $locale, ?User $currentUser, GeneralConfig $generalConfig): array
    {
        return [
            'constrainInput' => false,
            'dateFormat' => $formattingLocale->getDateFormat(Locale::LENGTH_SHORT, Locale::FORMAT_JUI),
            'dayNames' => $locale->getWeekDayNames(Locale::LENGTH_FULL),
            'dayNamesMin' => $locale->getWeekDayNames(Locale::LENGTH_ABBREVIATED),
            'dayNamesShort' => $locale->getWeekDayNames(Locale::LENGTH_SHORT),
            'firstDay' => (int)(($currentUser?->getPreference('weekStartDay')) ?? $generalConfig->defaultWeekStartDay),
            'monthNames' => $locale->getMonthNames(Locale::LENGTH_FULL),
            'monthNamesShort' => $locale->getMonthNames(Locale::LENGTH_ABBREVIATED),
            'nextText' => Craft::t('app', 'Next'),
            'prevText' => Craft::t('app', 'Prev'),
        ];
    }

    private function _defaultCookieOptions(): array
    {
        $config = Craft::cookieConfig();
        return [
            'path' => $config['path'] ?? '/',
            'domain' => $config['domain'] ?? null,
            'secure' => $config['secure'] ?? false,
            'sameSite' => $config['sameSite'] ?? 'strict',
        ];
    }

    private function _editableCategoryGroups(): array
    {
        $groups = [];

        foreach (Craft::$app->getCategories()->getEditableGroups() as $group) {
            $groups[] = [
                'handle' => $group->handle,
                'id' => (int)$group->id,
                'name' => Craft::t('site', $group->name),
                'uid' => Craft::t('site', $group->uid),
            ];
        }

        return $groups;
    }

    /**
     * @param GeneralConfig $generalConfig
     * @return array|null
     */
    private function _httpProxy(GeneralConfig $generalConfig): ?array
    {
        if (!$generalConfig->httpProxy) {
            return null;
        }

        $parsed = parse_url($generalConfig->httpProxy);

        return array_filter([
            'host' => $parsed['host'],
            'port' => $parsed['port'] ?? strtolower($parsed['scheme']) === 'http' ? 80 : 443,
            'auth' => array_filter([
                'username' => $parsed['user'] ?? null,
                'password' => $parsed['pass'] ?? null,
            ]),
            'protocol' => $parsed['scheme'],
        ]);
    }

    /**
     * @param GeneralConfig $generalConfig
     * @return array|null|false
     */
    private function _previewIframeResizerOptions(GeneralConfig $generalConfig): array|null|false
    {
        if (!$generalConfig->useIframeResizer) {
            return false;
        }

        // Treat false as [] as well now that useIframeResizer exists
        if (empty($generalConfig->previewIframeResizerOptions)) {
            return null;
        }

        return $generalConfig->previewIframeResizerOptions;
    }

    private function _publishableSections(User $currentUser): array
    {
        $sections = [];

        foreach (Craft::$app->getSections()->getEditableSections() as $section) {
            if ($section->type !== Section::TYPE_SINGLE && $currentUser->can("createEntries:$section->uid")) {
                $sections[] = [
                    'entryTypes' => $this->_entryTypes($section),
                    'handle' => $section->handle,
                    'id' => (int)$section->id,
                    'name' => Craft::t('site', $section->name),
                    'sites' => $section->getSiteIds(),
                    'type' => $section->type,
                    'uid' => $section->uid,
                    'canSave' => $currentUser->can("saveEntries:$section->uid"),
                ];
            }
        }

        return $sections;
    }

    private function _entryTypes(Section $section): array
    {
        $types = [];

        foreach ($section->getEntryTypes() as $type) {
            $types[] = [
                'handle' => $type->handle,
                'id' => (int)$type->id,
                'name' => Craft::t('site', $type->name),
            ];
        }

        return $types;
    }

    private function _sites(Sites $sitesService): array
    {
        $sites = [];

        foreach ($sitesService->getAllSites() as $site) {
            $sites[] = [
                'handle' => $site->handle,
                'id' => (int)$site->id,
                'uid' => (string)$site->uid,
                'name' => Craft::t('site', $site->getName()),
            ];
        }

        return $sites;
    }

    private function _timepickerOptions(Locale $formattingLocale, string $orientation): array
    {
        return [
            'closeOnWindowScroll' => false,
            'lang' => [
                'AM' => $formattingLocale->getAMName(),
                'am' => mb_strtolower($formattingLocale->getAMName()),
                'PM' => $formattingLocale->getPMName(),
                'pm' => mb_strtolower($formattingLocale->getPMName()),
            ],
            'orientation' => $orientation[0],
            'timeFormat' => $formattingLocale->getTimeFormat(Locale::LENGTH_SHORT, Locale::FORMAT_PHP),
        ];
    }
}
