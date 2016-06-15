<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 *
 * @package    MetaModels
 * @subpackage FilterMultiPreset
 * @author     Christopher Bölter <metamodels@boelter.eu>
 * @copyright  Christopher Bölter 2016
 * @license    LGPL.
 * @filesource
 */

namespace MetaModels\Filter\Setting;

/**
 * Attribute type factory for select filter settings.
 */
class MultiPresetFilterSettingTypeFactory extends AbstractFilterSettingTypeFactory
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setTypeName('multipreset')
            ->setTypeIcon('system/modules/metamodelsfilter_multipreset/html/filter_select.png')
            ->setTypeClass('MetaModels\Filter\Setting\MultiPreset')
            ->allowAttributeTypes();

        foreach (
            array(
                'select',
                'translatedselect',
                'text',
                'translatedtext'
            ) as $attribute
        ) {
            $this->addKnownAttributeType($attribute);
        }
    }
}
