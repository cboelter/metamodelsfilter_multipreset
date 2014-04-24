<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package MetaModels
 * @subpackage FilterMultiPreset
 * @author Christopher Bölter <c.boelter@cogizz.de>
 * @copyright cogizz - digital communications
 * @license LGPL.
 * @filesource
 */

/**
 * Frontend filter
 */
$GLOBALS['METAMODELS']['filters']['multipreset']['class']         = 'MetaModels\Filter\Setting\MultiPreset';
$GLOBALS['METAMODELS']['filters']['multipreset']['image']         = 'system/modules/metamodelsfilter_multipreset/html/filter_select.png';
$GLOBALS['METAMODELS']['filters']['multipreset']['info_callback'] = array('MetaModels\Dca\Filter', 'infoCallback');
$GLOBALS['METAMODELS']['filters']['multipreset']['attr_filter'][] = 'select';
$GLOBALS['METAMODELS']['filters']['multipreset']['attr_filter'][] = 'text';
