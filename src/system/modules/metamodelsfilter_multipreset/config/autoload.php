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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'MetaModels\Filter\Setting\MultiPreset' => 'system/modules/metamodelsfilter_multipreset/MetaModels/Filter/Setting/MultiPreset.php',
));
