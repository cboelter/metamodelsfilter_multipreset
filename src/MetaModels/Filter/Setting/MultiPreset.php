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
 * @author     Christopher Bölter <c.boelter@cogizz.de>
 * @copyright  cogizz - digital communications
 * @license    LGPL.
 * @filesource
 */

namespace MetaModels\Filter\Setting;

use MetaModels\IItem;
use MetaModels\Filter\Filter;
use MetaModels\Filter\IFilter;
use MetaModels\Filter\Rules\StaticIdList as FilterRuleStaticIdList;
use MetaModels\Filter\Rules\SearchAttribute;
use MetaModels\Filter\Rules\Condition\ConditionOr;

/**
 * Filter setting implementation performing a search for presetted multiple values on a
 * configured attribute.
 *
 * @package    MetaModels
 * @subpackage FilterMultiPreset
 * @author     Christopher Bölter <c.boelter@cogizz.de>
 */
class MultiPreset extends Simple
{
    /**
     * {@inheritdoc}
     */
    protected function getParamName()
    {
        $objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
        if ($objAttribute) {
            return $objAttribute->getColName();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareRules(IFilter $objFilter, $arrFilterUrl)
    {
        $objMetaModel = $this->getMetaModel();
        $objAttribute = $objMetaModel->getAttributeById($this->get('attr_id'));
        $strParam     = $this->getParamName();

        if ($objAttribute && $strParam) {
            $arrFilterValue = $arrFilterUrl[$strParam];

            if ($arrFilterValue && is_array($arrFilterValue)) {
                if (count($arrFilterValue) > 1) {
                    $objParentRule = new ConditionOr();

                    foreach ($arrFilterValue as $strValue) {
                        $objSubFilter = new Filter($objMetaModel);
                        $objSubFilter->addFilterRule(new SearchAttribute($objAttribute, $strValue));
                        $objParentRule->addChild($objSubFilter);
                    }

                    $objFilter->addFilterRule($objParentRule);
                    return;

                } else {
                    $objFilter->addFilterRule(new SearchAttribute($objAttribute, $arrFilterValue));
                    return;
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters()
    {
        return ($strParamName = $this->getParamName()) ? array($strParamName) : array();
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterDCA()
    {
        $objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
        $arrOptions   = $objAttribute->getFilterOptions(null, true);

        // add a blank option to the multiple select
        array_insert(
            $arrOptions,
            0,
            array(
                '' => '-'
            )
        );

        return array(
            $this->getParamName() => array
            (
                'label'     => array(
                    sprintf(
                        $GLOBALS['TL_LANG']['MSC']['metamodel_filtersettings_parameter']['multipreset'][0],
                        $objAttribute->getName()
                    ),
                    sprintf(
                        $GLOBALS['TL_LANG']['MSC']['metamodel_filtersettings_parameter']['multipreset'][1],
                        $objAttribute->getName()
                    )
                ),
                'inputType' => 'select',
                'options'   => $arrOptions,
                'eval'      => array(
                    'includeBlankOption' => true,
                    'multiple'           => true,
                    'style'              => 'min-width:450px;margin-bottom:16px;margin-right:10px;'
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getReferencedAttributes()
    {
        if (!($this->get('attr_id')
              && ($objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'))))
        ) {
            return array();
        }
        return array($objAttribute->getColName());
    }
}